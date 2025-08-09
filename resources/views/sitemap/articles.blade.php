<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($articles as $article)
    <url>
        <loc>{{ $article['url'] }}</loc>
        <lastmod>{{ $article['lastmod']->toISOString() }}</lastmod>
        <changefreq>{{ $article['changefreq'] }}</changefreq>
        <priority>{{ $article['priority'] }}</priority>
    </url>
@endforeach
</urlset>