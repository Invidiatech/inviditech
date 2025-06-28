<?php
namespace App\Models\Seo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoRedirect extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_url',
        'to_url',
        'status_code',
        'type',
        'hits',
        'last_hit',
        'status',
        'created_by',
        'notes'
    ];

    protected $casts = [
        'last_hit' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(Seo::class, 'created_by');
    }
}
