<?php

namespace Tests\Feature;

use Tests\TestCase;

class SearchEngineBlockingTest extends TestCase
{
    /**
     * Test that robots.txt blocks confidential pages
     */
    public function test_robots_txt_blocks_confidential_pages(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        
        // Check admin/backend blocks
        $response->assertSee('Disallow: /seo/');
        $response->assertSee('Disallow: /admin/');
        $response->assertSee('Disallow: /storage/');
        
        // Check auth blocks
        $response->assertSee('Disallow: /login');
        $response->assertSee('Disallow: /register');
        $response->assertSee('Disallow: /forgot-password');
        
        // Check sitemap reference
        $response->assertSee('Sitemap:');
    }

    /**
     * Test that authentication pages have noindex meta tags
     */
    public function test_login_page_has_noindex_header(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet');
    }

    /**
     * Test that register page has noindex meta tags
     */
    public function test_register_page_has_noindex_header(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet');
    }

    /**
     * Test that admin login has noindex
     */
    public function test_admin_login_has_noindex_header(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet');
    }

    /**
     * Test that public pages DO NOT have noindex
     */
    public function test_public_pages_do_not_have_noindex(): void
    {
        $publicPages = ['/', '/about', '/services', '/contact'];

        foreach ($publicPages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200);
            $response->assertHeaderMissing('X-Robots-Tag');
        }
    }

    /**
     * Test that sitemap includes only public pages
     */
    public function test_sitemap_excludes_confidential_pages(): void
    {
        $response = $this->get('/sitemap-pages.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        
        // Should include public pages
        $response->assertSee(route('home'));
        $response->assertSee(route('about'));
        
        // Should NOT include auth pages
        $response->assertDontSee('/login');
        $response->assertDontSee('/register');
        $response->assertDontSee('/admin');
    }
}
