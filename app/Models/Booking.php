<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Booking Model supporting MongoDB and relational DB fallback.
 */
class Booking extends BaseModel
{
    use HasFactory;

    protected $table = 'bookings';
    protected $collection = 'bookings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_name',
        'client_phone',
        'client_email',
        'session_date',
        'start_time',
        'end_time',
        'session_type',
        'location',
        'status', // 'pending', 'confirmed', 'awaiting_retainer', 'completed', 'cancelled'
        'lead_photographer',
        'notes',
    ];

    /**
     * Set database connection dynamically.
     */
    public function __construct(array $attributes = [])
    {
        if (extension_loaded('mongodb') && env('DB_CONNECTION') === 'mongodb') {
            $this->connection = 'mongodb';
            $this->primaryKey = '_id';
        } else {
            $this->connection = env('DB_CONNECTION', 'sqlite');
        }

        parent::__construct($attributes);
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['reference_number'];

    /**
     * Get unique booking reference code.
     */
    public function getReferenceNumberAttribute(): string
    {
        $idStr = (string) ($this->_id ?? $this->id ?? '0');
        $code = is_numeric($idStr) && intval($idStr) > 0 ? sprintf('%04d', $idStr) : strtoupper(substr(md5($idStr . $this->client_email), 0, 5));
        $year = date('Y', strtotime($this->session_date ?? 'now'));
        return "ARP-{$year}-{$code}";
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeStatus($query, $status)
    {
        if (!empty($status) && $status !== 'all') {
            return $query->where('status', strtolower($status));
        }
        return $query;
    }
}
