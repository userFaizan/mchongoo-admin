<?php

namespace App\Repositories;

use App\Models\FavouriteService;
use App\Repositories\BaseRepository;

/**
 * Class FavouriteServiceRepository
 * @package App\Repositories
 * @version July 8, 2023, 7:49 pm UTC
*/

class FavouriteServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'service_id',
        'is_favorite'
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
        return FavouriteService::class;
    }
}
