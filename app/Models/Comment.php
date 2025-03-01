<?php
 namespace App\Models;

 use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
 
 class Comment extends Model
 {
     use HasFactory, SoftDeletes;
 
     protected $fillable = [
         'user_id',
         'article_id',
         'parent_id',
         'content',
         'is_approved',
     ];
 
     protected $casts = [
         'is_approved' => 'boolean',
     ];
 
     public function user()
     {
         return $this->belongsTo(User::class);
     }
 
     public function article()
     {
         return $this->belongsTo(Article::class);
     }
 
     public function parent()
     {
         return $this->belongsTo(Comment::class, 'parent_id');
     }
 
     public function replies()
     {
         return $this->hasMany(Comment::class, 'parent_id')->where('is_approved', true);
     }
 
     public function scopeApproved($query)
     {
         return $query->where('is_approved', true);
     }
 
     public function scopeRootComments($query)
     {
         return $query->whereNull('parent_id');
     }
 
}