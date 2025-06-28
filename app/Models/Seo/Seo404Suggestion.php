<?php
namespace App\Models\Seo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo404Suggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'referer',
        'user_agent',
        'ip_address',
        'hits',
        'last_hit',
        'suggested_redirect',
        'status',
        'resolved_at',
        'resolved_by'
    ];

    protected $casts = [
        'last_hit' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function resolver()
    {
        return $this->belongsTo(Seo::class, 'resolved_by');
    }
}
