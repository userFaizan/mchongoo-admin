<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class UserKYC
 * @package App\Models
 * @version June 24, 2023, 9:35 pm UTC
 *
 * @property \App\Models\User $user
 * @property integer $user_id
 * @property string $logo
 * @property string $business_registration
 * @property string $business_license
 */
class UserKYC extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'user_kyc_documents';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'logo',
        'business_registration',
        'business_license'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'logo' => 'string',
        'business_registration' => 'string',
        'business_license' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

        'logo' => 'nullable|string|max:255',
        'business_registration' => 'nullable|string|max:255',
        'business_license' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
