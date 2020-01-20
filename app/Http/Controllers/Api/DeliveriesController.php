<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\DeliveryRepository;

class DeliveriesController extends Controller
{

    /**
     * setup
     */
    public function __construct()
    {
        $this->deliveryRepository = resolve(DeliveryRepository::class);
    }


    /**
     * Fetch all deliveries
     * @return Collection
     */
    public function index()
    {
        return $this->deliveryRepository->all();
    }
}
