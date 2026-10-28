<?php

namespace App\Support;

use App\Models\City;
use App\Models\Post;
use App\Models\Service;
use App\Models\Setting;

/**
 * Pembantu SEO: meta tag dan data terstruktur (JSON-LD).
 */
class Seo
{
    public static function meta(array $overrides = []): array
    {
        $og = Setting::get('og_image');

        return array_merge([
            'title'       => Setting::get('seo_title', 'Enigma Works Indonesia'),
            'description' => Setting::get('seo_description', ''),
            'canonical'   => url()->current(),
            'image'       => Media::url($og),
            'type'        => 'website',
            'robots'      => 'index, follow',
        ], array_filter($overrides, fn ($v) => $v !== null && $v !== ''));
    }

    public static function title(?string $title): string
    {
        return Text::plain($title).Setting::get('title_suffix', ' | Enigma Works Indonesia');
    }

    public static function organization(): array
    {
        $s = fn ($k, $d = null) => Setting::get($k, $d);

        $areas = City::ordered()->get()
            ->map(fn ($c) => ['@type' => 'Place', 'name' => $c->name])
            ->push(['@type' => 'AdministrativeArea', 'name' => 'Sumatera Utara'])
            ->push(['@type' => 'Country', 'name' => 'Indonesia'])
            ->values()->all();

        return array_filter([
            '@context'      => 'https://schema.org',
            '@type'         => 'ProfessionalService',
            '@id'           => url('/').'#organization',
            'name'          => $s('legal_name', 'PT Enigma Works Indonesia'),
            'alternateName' => $s('company_name', 'Enigma Works Indonesia'),
            'url'           => url('/'),
            'logo'          => Media::url($s('logo')),
            'telephone'     => $s('phone_e164'),
            'email'         => $s('email'),
            'address'       => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => $s('street'),
                'addressLocality' => $s('city'),
                'addressRegion'   => $s('region'),
                'addressCountry'  => 'ID',
            ],
            'areaServed'    => $areas,
            'knowsAbout'    => ['SIMRS', 'Sistem Informasi Rumah Sakit', 'Bridging BPJS Kesehatan', 'SATUSEHAT', 'Rekam Medis Elektronik'],
            'sameAs'        => array_values(array_filter([$s('linkedin'), $s('instagram'), $s('youtube')])),
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name'  => 'Layanan IT Rumah Sakit',
                'itemListElement' => Service::active()->ordered()->get()->map(fn ($svc) => [
                    '@type' => 'Offer',
                    'itemOffered' => ['@type' => 'Service', 'name' => $svc->name, 'url' => route('services.show', $svc->slug)],
                ])->all(),
            ],
        ]);
    }

    /** @param array<int, array{0:string,1:string}> $faqs */
    public static function faq(array $faqs): ?array
    {
        if (empty($faqs)) {
            return null;
        }

        return [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => array_map(fn ($f) => [
                '@type' => 'Question',
                'name'  => $f[0],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
            ], $faqs),
        ];
    }

    /** @param array<int, array{0:string,1:string|null}> $items */
    public static function breadcrumb(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn ($item, $i) => array_filter([
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $item[0],
                'item'     => $item[1] ?? null,
            ]))->all(),
        ];
    }

    public static function service(Service $service): array
    {
        return [
            '@context'    => 'https://schema.org',
            '@type'       => 'Service',
            'name'        => $service->name,
            'description' => $service->seo_description ?: $service->short,
            'url'         => route('services.show', $service->slug),
            'provider'    => ['@id' => url('/').'#organization'],
            'areaServed'  => [['@type' => 'Place', 'name' => 'Medan'], ['@type' => 'AdministrativeArea', 'name' => 'Sumatera Utara']],
        ];
    }

    public static function article(Post $post): array
    {
        return array_filter([
            '@context'      => 'https://schema.org',
            '@type'         => 'BlogPosting',
            'headline'      => $post->title,
            'description'   => $post->description,
            'datePublished' => optional($post->published_at)->toAtomString(),
            'dateModified'  => $post->updated_at?->toAtomString(),
            'image'         => Media::url($post->cover),
            'author'        => ['@type' => 'Organization', 'name' => $post->author],
            'publisher'     => ['@id' => url('/').'#organization'],
            'mainEntityOfPage' => route('blog.show', $post->slug),
            'inLanguage'    => 'id-ID',
        ]);
    }

    public static function json(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
    }
}
