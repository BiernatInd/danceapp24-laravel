<?php

namespace App\Http\Controllers\Main\Sitemap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function generate()
    {
        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('urlset');
        $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        $staticRoutes = [
            '/faq' => 'monthly',
            '/price-list' => 'monthly',
            '/timetable' => 'monthly',
            '/about-us' => 'monthly',
            '/offer-for-schools' => 'monthly',
            '/new-school' => 'monthly',
            '/contact' => 'monthly',
            '/blog' => 'monthly',
            '/checkout' => 'monthly',
            '/thanks-for-order' => 'monthly',
            '/status' => 'monthly',
            '/policy-privacy' => 'monthly',
            '/statute' => 'monthly',
            '/login' => 'monthly',
            '/register' => 'monthly',
            '/recover-password' => 'monthly',
            '/reset-password' => 'monthly',

        ];

        foreach ($staticRoutes as $path => $changefreq) {
            $this->addUrl($xml, 'http://localhost:3000' . $path, '2023-10-10T00:00:00+00:00', $changefreq, 0.8);
        }

        $entries = BlogList::all();

        foreach ($entries as $entry) {
            $url = 'http://localhost:3000/article/' . $entry->id;
            $lastmod = $entry->updated_at->toIso8601String();
            $this->addUrl($xml, $url, $lastmod, 'weekly', 0.6);
        }

        $xml->endElement();
        $xmlContent = $xml->outputMemory();

        return response($xmlContent)->header('Content-Type', 'text/xml');
    }

    private function addUrl(\XMLWriter $xml, $loc, $lastmod, $changefreq, $priority)
    {
        $xml->startElement('url');
        $xml->writeElement('loc', $loc);
        $xml->writeElement('lastmod', $lastmod);
        $xml->writeElement('changefreq', $changefreq);
        $xml->writeElement('priority', $priority);
        $xml->endElement();
    }
}
