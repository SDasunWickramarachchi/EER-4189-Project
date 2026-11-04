<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends BaseModel
{
    use HasFactory;

    public const STATUSES = ['new' , 'replied' , 'in_review' , 'converted' , 'archived'];

    public const TABS =[
        'new' => ['new'],
        'replied_review' => ['replied', 'in_review'],
        'converted' => ['converted'],
        'archived' => ['archived'],
    ];

    protected $table = 'inquiries';
    protected $collection = 'inquiries';
    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone',
        'inquiry_type',
        'message',
        'location',
        'session_date',
        'priority',
        'status',
        'replied_at',
        'history',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
        'history' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        if (extension_loaded('mongodb') && env('DB_CONNECTION') === 'mongodb'){
            $this->connection = 'mongodb';
            $this->primaryKey = '_id';
        } else { 
            $this->connection = env('DB_CONNECTION', 'sqlite');
        }

        parent::__construct($attributes);
    }

    protected $appends = ['reference_number', 'history_count'];

    public function getReferenceNumberAttribute(): string
    {
        $idStr = (string) ($this->_id ?? $this->id ?? '0');
        $code = is_numeric($idStr) && intval($idStr) > 0
            ? sprintf('%04d', $idStr)
            : strtoupper(substr(md5($idStr . $this->client_email), 0, 5));
        $year = $this->created_at ? $this->created_at->format('Y') : date('Y');

        return "INQ-{$year}-{$code}";
    }
    public function getHistoryCountAttribute(): int
    {
        return count($this->history ?? []);
    }
    public function addHistory(string $type, string $text): void
    {
        $history = $this->history ?? [];
        $history[] = [
            'type' => $type,
            'text' => $text,
            'at' => now()->toIso8601String(),
        ];
        $this->history = $history;
    }

    public function scopeStatus($query, $status)
    {
        if (!empty($status) && $status !== 'all'){
            return $query->where('status', strtolower($status));
        }
        return $query;
    }
}


