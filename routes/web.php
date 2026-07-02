<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'marketing.home')->name('home');

Route::get('/robots.txt', function () {
    return response(
        "User-agent: *\nAllow: /\nSitemap: " . url('/sitemap.xml') . "\n",
        200,
        ['Content-Type' => 'text/plain']
    );
});

Route::get('/sitemap.xml', function () {
    $lastmod = now()->toAtomString();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
        . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n"
        . '    <url>' . "\n"
        . '        <loc>' . e(url('/')) . '</loc>' . "\n"
        . '        <lastmod>' . e($lastmod) . '</lastmod>' . "\n"
        . '        <changefreq>weekly</changefreq>' . "\n"
        . '        <priority>1.0</priority>' . "\n"
        . '    </url>' . "\n"
        . '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml']);
});
