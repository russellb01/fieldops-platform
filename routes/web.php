<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'marketing.home')->name('home');

Route::view('/services/hvac', 'marketing.services.hvac')->name('services.hvac');
Route::view('/services/commercial-refrigeration', 'marketing.services.commercial-refrigeration')->name('services.commercial-refrigeration');
Route::view('/services/ice-machines', 'marketing.services.ice-machines')->name('services.ice-machines');
Route::view('/services/restaurant-equipment', 'marketing.services.restaurant-equipment')->name('services.restaurant-equipment');
Route::view('/services/preventive-maintenance', 'marketing.services.preventive-maintenance')->name('services.preventive-maintenance');

Route::view('/service-areas/loudon-tn', 'marketing.service-areas.loudon-tn')->name('service-areas.loudon');
Route::view('/service-areas/lenoir-city-tn', 'marketing.service-areas.lenoir-city-tn')->name('service-areas.lenoir-city');
Route::view('/service-areas/tellico-village-tn', 'marketing.service-areas.tellico-village-tn')->name('service-areas.tellico-village');
Route::view('/service-areas/knoxville-tn', 'marketing.service-areas.knoxville-tn')->name('service-areas.knoxville');

Route::view('/request-service', 'marketing.request-service')->name('request-service');
Route::view('/financing', 'marketing.financing')->name('financing');

Route::get('/robots.txt', function () {
    return response(
        "User-agent: *\nAllow: /\nSitemap: " . url('/sitemap.xml') . "\n",
        200,
        ['Content-Type' => 'text/plain']
    );
});

Route::get('/sitemap.xml', function () {
    $pages = [
        ['path' => '/', 'priority' => '1.0', 'changefreq' => 'weekly'],
        ['path' => '/services/hvac', 'priority' => '0.9', 'changefreq' => 'monthly'],
        ['path' => '/services/commercial-refrigeration', 'priority' => '0.95', 'changefreq' => 'monthly'],
        ['path' => '/services/ice-machines', 'priority' => '0.85', 'changefreq' => 'monthly'],
        ['path' => '/services/restaurant-equipment', 'priority' => '0.85', 'changefreq' => 'monthly'],
        ['path' => '/services/preventive-maintenance', 'priority' => '0.85', 'changefreq' => 'monthly'],
        ['path' => '/request-service', 'priority' => '0.9', 'changefreq' => 'monthly'],
        ['path' => '/financing', 'priority' => '0.85', 'changefreq' => 'monthly'],
        ['path' => '/service-areas/loudon-tn', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['path' => '/service-areas/lenoir-city-tn', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['path' => '/service-areas/tellico-village-tn', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['path' => '/service-areas/knoxville-tn', 'priority' => '0.75', 'changefreq' => 'monthly'],
    ];

    $lastmod = now()->toAtomString();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    foreach ($pages as $page) {
        $xml .= "    <url>\n";
        $xml .= '        <loc>' . e(url($page['path'])) . "</loc>\n";
        $xml .= '        <lastmod>' . e($lastmod) . "</lastmod>\n";
        $xml .= '        <changefreq>' . e($page['changefreq']) . "</changefreq>\n";
        $xml .= '        <priority>' . e($page['priority']) . "</priority>\n";
        $xml .= "    </url>\n";
    }

    $xml .= '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml']);
});
