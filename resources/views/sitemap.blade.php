<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ route('welcome') }}</loc>
        <lastmod>2023-05-08</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    <url>
        <loc>{{ route('article.search') }}</loc>
        <lastmod>2023-05-08</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    @foreach ($articles as $article)
        <url>
            <loc>{{ route('article.view', ['slug' => $article->slug]) }}</loc>
            <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z', strtotime($article->updated_at_original)) }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
