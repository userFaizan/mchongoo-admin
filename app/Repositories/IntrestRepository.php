<?php

namespace App\Repositories;

use App\Models\Intrest;
use App\Repositories\BaseRepository;

/**
 * Class IntrestRepository
 * @package App\Repositories
 * @version June 25, 2023, 12:41 pm UTC
*/

class IntrestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'icon',
        'name',
        'slug',
        'status'
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
        return Intrest::class;
    }
}
