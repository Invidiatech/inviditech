<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'sort_order',
        'article_id',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function codeSnippets()
    {
        return $this->hasMany(CodeSnippet::class, 'section_id');
    }
}