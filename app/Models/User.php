<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @version June 22, 2023, 8:25 pm UTC
 *
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property integer $phone_no
 * @property string $email
 * @property string $password
 * @property string $user_type
 * @property boolean $terms_and_condition
 * @property integer $otp
 * @property string $account_usage
 * @property boolean $account_status
 * @property string|\Carbon\Carbon $email_verified_at
 * @property string $remember_token
 */
class User extends Authenticatable
{
    use SoftDeletes;

    use HasApiTokens, HasFactory, Notifiable;

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'first_name',
        'last_name',
        'username',
        'phone_no',
        'email',
        'password',
        'user_type',
        'terms_and_condition',
        'otp',
        'account_usage',
        'account_status',
        'otp_verified',
        'email_verified_at',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'username' => 'string',
        'phone_no' => 'integer',
        'email' => 'string',
        'password' => 'string',
        'user_type' => 'string',
        'terms_and_condition' => 'boolean',
        'otp' => 'integer',
        'account_usage' => 'string',
        'account_status' => 'boolean',
        'email_verified_at' => 'datetime',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'username' => 'nullable|string|max:255',
        'phone_no' => 'required|integer',
        'email' => 'required|email|max:255',
        'password' => 'required|string|max:255',
        'user_type' => 'nullable|string|max:255',
        'terms_and_condition' => 'required|boolean',
        'otp' => 'nullable|integer',
        'account_usage' => 'nullable|string|max:255',
        'account_status' => 'nullable|boolean',
        'email_verified_at' => 'nullable',
        'remember_token' => 'nullable|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function interests()
    {
        return $this->belongsToMany(Intrest::class);
    }
    public function category()
    {
        return $this->belongsToMany(Category::class);
    }
    public function userKyc()
    {
        return $this->hasMany(UserKYC::class);
    }

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }
}
