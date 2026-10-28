<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\City;
use App\Models\Faq;
use App\Models\PortfolioItem;
use App\Models\Post;
use App\Models\Service;
use App\Models\Setting;
use App\Support\Seo;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function home()
    {
        $faqs = Faq::active()->ordered()->get();

        return view('pages.home', [
            'services'  => Service::active()->ordered()->get(),
            'case'      => CaseStudy::active()->ordered()->first(),
            'portfolio' => PortfolioItem::active()->ordered()->get(),
            'cities'    => City::ordered()->get(),
            'posts'     => Post::published()->take(3)->get(),
            'faqs'      => $faqs,
            'seo'       => Seo::meta(),
            'schema'    => array_filter([
                Seo::organization(),
                Seo::faq($faqs->map(fn ($f) => [$f->question, $f->answer])->all()),
            ]),
        ]);
    }

    public function services()
    {
        return view('services.index', [
            'services' => Service::active()->ordered()->get(),
            'seo' => Seo::meta([
                'title'       => Seo::title('Layanan SIMRS dan IT Rumah Sakit'),
                'description' => 'Implementasi SIMRS, bridging BPJS, integrasi SATUSEHAT, aplikasi pendukung, hardware, jaringan, keamanan data, maintenance, dan solusi Mekari untuk rumah sakit.',
            ]),
            'schema' => [Seo::breadcrumb([['Beranda', route('home')], ['Layanan', null]])],
        ]);
    }

    public function service(string $slug)
    {
        $service = Service::active()->where('slug', $slug)->firstOrFail();

        return view('services.show', [
            'service' => $service,
            'others'  => Service::active()->ordered()->where('id', '!=', $service->id)->take(5)->get(),
            'cities'  => City::withPage()->ordered()->get(),
            'case'    => CaseStudy::active()->ordered()->first(),
            'posts'   => Post::published()->take(3)->get(),
            'seo'     => Seo::meta([
                'title'       => Seo::title($service->seo_title ?: $service->name),
                'description' => $service->seo_description ?: $service->short,
            ]),
            'schema'  => array_filter([
                Seo::service($service),
                Seo::breadcrumb([['Beranda', route('home')], ['Layanan', route('services.index')], [$service->name, null]]),
                Seo::faq($service->faqs ?? []),
            ]),
        ]);
    }

    public function city(string $slug)
    {
        $city = City::withPage()->where('slug', $slug)->firstOrFail();

        return view('cities.show', [
            'city'     => $city,
            'nearby'   => City::withPage()->whereIn('slug', $city->nearby ?? [])->get(),
            'services' => Service::active()->ordered()->get(),
            'seo'      => Seo::meta([
                'title'       => Seo::title($city->seo_title ?: 'IT Rumah Sakit '.$city->name),
                'description' => $city->seo_description ?: Str::limit($city->intro, 155),
            ]),
            'schema'   => [Seo::breadcrumb([['Beranda', route('home')], ['Area layanan', route('home').'#area'], [$city->name, null]])],
        ]);
    }

    public function caseStudies()
    {
        return view('case-studies.index', [
            'cases'     => CaseStudy::active()->ordered()->get(),
            'portfolio' => PortfolioItem::active()->ordered()->get(),
            'seo' => Seo::meta([
                'title'       => Seo::title('Studi Kasus dan Portofolio'),
                'description' => 'Studi kasus implementasi SIMRS, bridging BPJS, dan integrasi SATUSEHAT oleh Enigma Works Indonesia, beserta portofolio rumah sakit.',
            ]),
            'schema' => [Seo::breadcrumb([['Beranda', route('home')], ['Studi kasus', null]])],
        ]);
    }

    public function caseStudy(string $slug)
    {
        $case = CaseStudy::active()->where('slug', $slug)->firstOrFail();

        return view('case-studies.show', [
            'case'     => $case,
            'services' => Service::active()->whereIn('slug', $case->service_slugs ?? [])->ordered()->get(),
            'seo'      => Seo::meta([
                'title'       => Seo::title($case->seo_title ?: $case->title),
                'description' => $case->seo_description ?: Str::limit($case->summary, 155),
                'type'        => 'article',
            ]),
            'schema'   => [Seo::breadcrumb([['Beranda', route('home')], ['Studi kasus', route('cases.index')], [$case->client, null]])],
        ]);
    }

    public function about()
    {
        return view('pages.about', [
            'body' => Str::markdown((string) Setting::get('about_body', ''), ['html_input' => 'strip']),
            'cities' => City::withPage()->ordered()->get(),
            'seo' => Seo::meta([
                'title'       => Seo::title('Tentang Kami'),
                'description' => Str::limit((string) Setting::get('about_intro'), 155),
            ]),
            'schema' => [Seo::organization(), Seo::breadcrumb([['Beranda', route('home')], ['Tentang kami', null]])],
        ]);
    }

    public function contact()
    {
        return view('pages.contact', [
            'services' => Service::active()->ordered()->get(),
            'seo' => Seo::meta([
                'title'       => Seo::title('Kontak dan Konsultasi Gratis'),
                'description' => 'Hubungi Enigma Works Indonesia untuk konsultasi SIMRS, bridging BPJS, dan integrasi SATUSEHAT. WhatsApp '.Setting::get('phone').'.',
            ]),
            'schema' => [Seo::breadcrumb([['Beranda', route('home')], ['Kontak', null]])],
        ]);
    }
}
