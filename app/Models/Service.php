<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Service Model supporting MongoDB and relational DB fallback.
 */
class Service extends BaseModel
{
    use HasFactory;

    protected $table = 'services';
    protected $collection = 'services';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'image_url',
        'status', // 'active' or 'draft'
        'button_text',
        'button_link',
        'display_order',
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
     * Scope a query to only include active services.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
