<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Order
 * @package App\Models
 * @version August 9, 2023, 9:58 pm UTC
 *
 * @property \App\Models\Service $service
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $ordersBookingInformations
 * @property integer $user_id
 * @property integer $service_id
 * @property string $order_no
 * @property string $order_type
 * @property string $start_time
 * @property string $end_time
 * @property boolean $available
 * @property boolean $booking
 * @property string $lat
 * @property string $lng
 */
class Order extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'orders';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'service_id',
        'order_no',
        'order_type',
        'start_time',
        'end_time',
        'available',
        'booking',
        'lat',
        'lng'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'service_id' => 'integer',
        'order_no' => 'string',
        'order_type' => 'string',
        'start_time' => 'string',
        'end_time' => 'string',
        'available' => 'boolean',
        'booking' => 'boolean',
        'lat' => 'string',
        'lng' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'service_id' => 'required',
        'order_no' => 'nullable|string|max:255',
        'order_type' => 'nullable|string|max:255',
        'start_time' => 'nullable|string|max:255',
        'end_time' => 'nullable|string|max:255',
        'available' => 'nullable|boolean',
        'booking' => 'nullable|boolean',
        'lat' => 'nullable|string|max:255',
        'lng' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function service()
    {
        return $this->belongsTo(\App\Models\Service::class, 'service_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     **/
    public function bookingInformation()
    {
        return $this->hasOne(\App\Models\BookingInformation::class, 'order_id');
    }
}
