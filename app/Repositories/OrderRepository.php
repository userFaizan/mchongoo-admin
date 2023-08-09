<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\BaseRepository;

/**
 * Class OrderRepository
 * @package App\Repositories
 * @version August 9, 2023, 9:58 pm UTC
*/

class OrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'service_id',
        'order_no',
        'order_type',
        'start_time',
        'end_time',
        'available',
        'booking',
        'lat',
        'lng'
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
        return Order::class;
    }
}
