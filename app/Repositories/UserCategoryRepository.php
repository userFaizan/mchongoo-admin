<?php

namespace App\Repositories;

use App\Models\UserCategory;
use App\Repositories\BaseRepository;

/**
 * Class UserCategoryRepository
 * @package App\Repositories
 * @version July 12, 2023, 7:28 pm UTC
*/

class UserCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'category_id'
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
        return UserCategory::class;
    }
}
