<?php
namespace App\Models\Seo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeoPage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'content',
        'excerpt',
        'featured_image',
        'status',
        'publish_date',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'schema_markup',
        'created_by',
        'seo_score',
        'focus_keyword',
        'readability_score'
    ];

    protected $casts = [
        'publish_date' => 'datetime',
        'schema_markup' => 'json',
    ];

    public function creator()
    {
        return $this->belongsTo(Seo::class, 'created_by');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
