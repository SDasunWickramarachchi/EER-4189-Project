<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model as BaseModel;

class Setting extends BaseModel
{
    public const DEFAULTS = [
        'studio_name'            => 'Ashan Rumaiz',
        'bio'                    => 'Atelier director leading commercial high-fashion, high-profile nuptials, and architectural campaigns throughout South Asia and the UAE.',
        'dispatch_email'         => 'ashan@ashanrumaiz.com',
        'phone'                  => '+94 77 123 4567',
        'tax_id'                 => null,
        'address'                => 'Negombo',
        'artist_note'            => 'All high-resolution digital masters remain under original artistic copyright of Ashan Rumaiz Atelier. Editorial licenses granted subject to primary contract terms.',
        'shooting_days'          => [2, 3, 4, 5, 6, 0],
        'daily_start'            => '06:00',
        'daily_end'              => '19:30',
        'turnaround_hours'       => 48,
        'notify_high_value'      => true,
        'notify_contract_signed' => true,
        'notify_deposit'         => true,
        'high_value_threshold'   => 3000,
        'retainer_percent'       => 40,
        'grace_hours'            => 72,
    ];
 
    protected $table = 'settings';
    protected $collection = 'settings';
 
    protected $fillable = [
        'key',
        'studio_name',
        'bio',
        'dispatch_email',
        'phone',
        'tax_id',
        'address',
        'artist_note',
        'avatar_path',
        'shooting_days',
        'daily_start',
        'daily_end',
        'turnaround_hours',
        'notify_high_value',
        'notify_contract_signed',
        'notify_deposit',
        'high_value_threshold',
        'retainer_percent',
        'grace_hours',
    ];
 
    protected $casts = [
        'shooting_days'          => 'array',
        'turnaround_hours'       => 'integer',
        'notify_high_value'      => 'boolean',
        'notify_contract_signed' => 'boolean',
        'notify_deposit'         => 'boolean',
        'high_value_threshold'   => 'integer',
        'retainer_percent'       => 'integer',
        'grace_hours'            => 'integer',
    ];
 
    protected $appends = ['avatar_url'];

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
 
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar_path ? asset('storage/' . $this->avatar_path) : null;
    }
 
    public static function current(): self
    {
        return static::firstOrCreate(['key' => 'studio'], self::DEFAULTS);
    }
}