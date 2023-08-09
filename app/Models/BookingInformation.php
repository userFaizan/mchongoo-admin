<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BookingInformation
 * @package App\Models
 * @version August 8, 2023, 8:35 pm UTC
 *
 * @property Order $order
 * @property integer $order_id
 * @property string $month
 * @property string $days
 * @property string $year
 */
class BookingInformation extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'orders_booking_information';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'order_id',
        'month',
        'days',
        'year'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'month' => 'string',
        'days' => 'string',
        'year' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'month' => 'nullable|string|max:255',
        'days' => 'nullable|string',
        'year' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return BelongsTo
     **/
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
