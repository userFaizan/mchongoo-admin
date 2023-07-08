<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Plan
 * @package App\Models
 * @version July 8, 2023, 7:50 pm UTC
 *
 * @property Service $service
 * @property integer $service_id
 * @property string $plan_amount
 * @property string $plan_duration
 */
class Plan extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'plans_and_packages';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'service_id',
        'plan_amount',
        'plan_duration'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'service_id' => 'integer',
        'plan_amount' => 'string',
        'plan_duration' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'service_id' => 'required',
        'plan_amount' => 'nullable|string|max:255',
        'plan_duration' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return BelongsTo
     **/
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
