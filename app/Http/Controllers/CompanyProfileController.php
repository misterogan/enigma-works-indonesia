<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Support\Media;
use Illuminate\Contracts\View\View;

class CompanyProfileController extends Controller
{
    /** Halaman company profile PT Enigma Works Indonesia di domain company. */
    public function __invoke(): View
    {
        $config = config('company');
        $contact = collect($config['contact'])
            ->map(fn (string $fallback, string $key) => Setting::get($key, $fallback))
            ->all();

        return view('company.index', [
            'company' => $config,
            'contact' => $contact,
            'filled' => fn (?string $value): bool => filled($value) && ! str_contains($value, '[ISI'),
            'ogImage' => Media::url(Setting::get('og_image')),
            'schema' => $this->organizationSchema($config, $contact),
        ]);
    }

    /**
     * @param  array<string, mixed>  $config
     * @param  array<string, string>  $contact
     * @return array<string, mixed>
     */
    protected function organizationSchema(array $config, array $contact): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => 'https://'.$config['domain'].'/#organization',
            'name' => $config['legal_name'],
            'alternateName' => $config['name'],
            'url' => 'https://'.$config['domain'].'/',
            'description' => $config['seo']['description'],
            'telephone' => $contact['phone_e164'],
            'email' => $contact['email'],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $contact['street'],
                'addressLocality' => $contact['city'],
                'addressRegion' => $contact['region'],
                'addressCountry' => 'ID',
            ],
            'sameAs' => [$config['main_url']],
        ];
    }
}
