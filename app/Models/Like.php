<?php
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id', 'seo_blog_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seoBlog()
    {
        return $this->belongsTo(\App\Models\Seo\SeoBlog::class, 'seo_blog_id');
    }
}