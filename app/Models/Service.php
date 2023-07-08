<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Service
 * @package App\Models
 * @version July 8, 2023, 7:48 pm UTC
 *
 * @property Category $category
 * @property User $user
 * @property \Illuminate\Database\Eloquent\Collection $favouriteServices
 * @property \Illuminate\Database\Eloquent\Collection $plansAndPackages
 * @property \Illuminate\Database\Eloquent\Collection $servicesImages
 * @property integer $user_id
 * @property integer $category_id
 * @property string $name
 * @property string $gender
 * @property string $experience
 * @property string $service_type
 * @property string $address
 * @property string $service_price
 * @property number $rating
 * @property string $lat
 * @property string $long
 */
class Service extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'services';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'category_id',
        'name',
        'gender',
        'experience',
        'service_type',
        'address',
        'service_price',
        'rating',
        'lat',
        'long'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'category_id' => 'integer',
        'name' => 'string',
        'gender' => 'string',
        'experience' => 'string',
        'service_type' => 'string',
        'address' => 'string',
        'service_price' => 'string',
        'rating' => 'float',
        'lat' => 'string',
        'long' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'category_id' => 'required',
        'name' => 'nullable|string|max:255',
        'gender' => 'nullable|string|max:255',
        'experience' => 'nullable|string|max:255',
        'service_type' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'service_price' => 'nullable|string|max:255',
        'rating' => 'nullable|numeric',
        'lat' => 'nullable|string|max:255',
        'long' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return BelongsTo
     **/
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return BelongsTo
     **/
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasMany
     **/
    public function favouriteServices(): HasMany
    {
        return $this->hasMany(\App\Models\FavouriteService::class, 'service_id');
    }

    /**
     * @return HasMany
     **/
    public function plansAndPackages(): HasMany
    {
        return $this->hasMany(Plan::class, 'service_id');
    }

    /**
     * @return HasMany
     **/
    public function servicesImages(): HasMany
    {
        return $this->hasMany(ServiceImage::class, 'service_id');
    }
}
