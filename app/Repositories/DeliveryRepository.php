<?php

namespace App\Repositories;

use App\Models\Delivery;

class DeliveryRepository extends AbstractRepository
{
    public function model()
    {
        return Delivery::class;
    }
}
