<?php

namespace App\Models\Seo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemaMarkup extends Model
{
    use HasFactory;

    protected $table = 'seo_schema_markups';

    protected $fillable = [
        'name',
        'type',
        'schema_data',
        'pages',
        'status',
        'created_by',
        'validation_status',
        'validation_errors'
    ];

    protected $casts = [
        'schema_data' => 'array',
        'pages' => 'array',
        'validation_errors' => 'array',
    ];

    /**
     * Schema types available
     */
    const SCHEMA_TYPES = [
        'local_business' => 'Local Business',
        'faq' => 'FAQ',
        'web_page' => 'Web Page',
        'article' => 'Article',
        'breadcrumb' => 'Breadcrumb',
        'product' => 'Product'
    ];

    /**
     * Status options
     */
    const STATUS_OPTIONS = [
        'active' => 'Active',
        'inactive' => 'Inactive'
    ];

    /**
     * Validation status options
     */
    const VALIDATION_STATUS = [
        'valid' => 'Valid',
        'invalid' => 'Invalid',
        'pending' => 'Pending'
    ];

    /**
     * Get the creator of the schema
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\Seo\Seo::class, 'created_by');
    }

    /**
     * Scope for active schemas
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for valid schemas
     */
    public function scopeValid($query)
    {
        return $query->where('validation_status', 'valid');
    }

    /**
     * Get schema template based on type
     */
    public static function getSchemaTemplate($type)
    {
        $templates = [
            'local_business' => [
                '@context' => 'https://schema.org',
                '@type' => 'LocalBusiness',
                'name' => '',
                'description' => '',
                'url' => '',
                'telephone' => '',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => '',
                    'addressLocality' => '',
                    'postalCode' => '',
                    'addressCountry' => ''
                ],
                'openingHours' => [],
                'priceRange' => ''
            ],
            'faq' => [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => []
            ],
            'web_page' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => '',
                'description' => '',
                'url' => ''
            ],
            'article' => [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => '',
                'description' => '',
                'author' => [
                    '@type' => 'Person',
                    'name' => ''
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => ''
                ],
                'datePublished' => '',
                'dateModified' => '',
                'image' => ''
            ],
            'breadcrumb' => [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => []
            ],
            'product' => [
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => '',
                'description' => '',
                'image' => '',
                'brand' => [
                    '@type' => 'Brand',
                    'name' => ''
                ],
                'offers' => [
                    '@type' => 'Offer',
                    'price' => '',
                    'priceCurrency' => 'GBP',
                    'availability' => 'https://schema.org/InStock'
                ]
            ]
        ];

        return $templates[$type] ?? [];
    }

    /**
     * Generate JSON-LD markup
     */
    public function generateJsonLd()
    {
        return json_encode($this->schema_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
