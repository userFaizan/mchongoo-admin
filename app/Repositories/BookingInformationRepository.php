<?php

namespace App\Repositories;

use App\Models\BookingInformation;
use App\Repositories\BaseRepository;

/**
 * Class BookingInformationRepository
 * @package App\Repositories
 * @version August 8, 2023, 8:35 pm UTC
*/

class BookingInformationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'order_id',
        'month',
        'days',
        'year'
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
        return BookingInformation::class;
    }
}
