<?php

namespace App\Repositories;

use App\Models\UserKYC;
use App\Repositories\BaseRepository;

/**
 * Class UserKYCRepository
 * @package App\Repositories
 * @version June 24, 2023, 9:35 pm UTC
*/

class UserKYCRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'logo',
        'business_registration',
        'business_license'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserKYC::class;
    }
}
