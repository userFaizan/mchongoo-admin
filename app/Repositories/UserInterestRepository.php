<?php

namespace App\Repositories;

use App\Models\UserInterest;
use App\Repositories\BaseRepository;

/**
 * Class UserInterestRepository
 * @package App\Repositories
 * @version June 28, 2023, 6:01 pm UTC
*/

class UserInterestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'interest_id'
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
        return UserInterest::class;
    }
}
