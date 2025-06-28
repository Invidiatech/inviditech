<?php
namespace App\Models\Seo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class SeoRobots extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'status',
        'last_updated_by',
        'validation_status',
        'validation_errors'
    ];

    protected $casts = [
        'validation_errors' => 'array',
    ];

    public function updater()
    {
        return $this->belongsTo(Seo::class, 'last_updated_by');
    }
}
