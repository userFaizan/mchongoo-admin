<?php

namespace App\Repositories;

use App\Models\ServiceImage;
use App\Repositories\BaseRepository;

/**
 * Class ServiceImageRepository
 * @package App\Repositories
 * @version July 8, 2023, 7:49 pm UTC
*/

class ServiceImageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'service_id',
        'images'
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
        return ServiceImage::class;
    }
}
