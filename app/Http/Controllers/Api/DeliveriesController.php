<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\DeliveryRepository;

use App\Http\Requests\DeliveriesRequest;
use App\Http\Resources\DeliveryResource;

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


    /**
     * Funcionalidade para criar um novo delivery.
     *
     * @param \App\Http\Requests\DeliveriesRequest
     * @return \App\Http\Resources\DeliveryResource
     */
    public function store(DeliveriesRequest $request)
    {
        $data = $request->all();
        $delivery = $this->deliveryRepository->create($data);

        return new DeliveryResource($delivery);
    }

    /**
     * Método para atualizar um delivery.
     *
     * @param \App\Http\Requests\DeliveriesRequest
     * @param int $id
     * @return \App\Http\Resources\DeliveryResource
     */
    public function update(DeliveriesRequest $request, int $id)
    {
        $data = $request->all();
        $tool = $this->deliveryRepository->update($data, $id);

        return new DeliveryResource($tool);
    }

}
