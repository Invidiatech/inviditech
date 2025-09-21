<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'privacy',
        'ip_address',
        'user_agent',
        'status',
        'read_at',
        'replied_at',
        'admin_notes'
    ];

    protected $casts = [
        'privacy' => 'boolean',
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'unread' => '<span class="badge bg-warning">Unread</span>',
            'read' => '<span class="badge bg-info">Read</span>',
            'replied' => '<span class="badge bg-success">Replied</span>',
            'archived' => '<span class="badge bg-secondary">Archived</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-light">Unknown</span>';
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y H:i A');
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getShortMessageAttribute()
    {
        return \Str::limit($this->message, 100);
    }

    // Mutators
    public function markAsRead()
    {
        $this->update([
            'status' => 'read',
            'read_at' => now()
        ]);
    }

    public function markAsReplied()
    {
        $this->update([
            'status' => 'replied',
            'replied_at' => now()
        ]);
    }

    public function markAsArchived()
    {
        $this->update([
            'status' => 'archived'
        ]);
    }

    public function markAsUnread()
    {
        $this->update([
            'status' => 'unread',
            'read_at' => null
        ]);
    }

    // Static methods
    public static function getStatusCounts()
    {
        return [
            'total' => self::count(),
            'unread' => self::unread()->count(),
            'read' => self::read()->count(),
            'replied' => self::replied()->count(),
            'archived' => self::archived()->count(),
        ];
    }

    public static function getRecentContacts($limit = 5)
    {
        return self::recent()->limit($limit)->get();
    }
}