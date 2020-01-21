<?php

namespace App\Http\Controllers\Api;

use App\Constants\Constants;
use App\Http\Controllers\Controller;
use App\Repositories\DeliveryRepository;

use App\Http\Requests\DeliveriesRequest;
use App\Http\Resources\DeliveryResource;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DeliveriesController extends Controller
{

    const DELIVERIES_TIME_CACHE_IN_MINUTES = 60;

    /**
     * @var \App\Repositories\DeliveryRepository
     */
    private $deliveryRepository;


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
        return $this->load_deliveries_from_cache();
    }

    /**
     * Método para retornar todos os deliveries a partir do cache.
     */
    public function load_deliveries_from_cache()
    {
        $timeCacheInMinutes = Carbon::now()->addMinutes(self::DELIVERIES_TIME_CACHE_IN_MINUTES);
        $deliveries = Cache::remember(Constants::DELIVERIES_CACHE_KEY, $timeCacheInMinutes, function () {
            $deliveries = $this->deliveryRepository->all();
            return DeliveryResource::collection($deliveries);
        });

        return $deliveries;
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


    /**
     * Método para deletar um delivery
     *
     * @param int $id
     *
     */
    public function destroy(int $id)
    {
        $this->deliveryRepository->delete($id);
        return response()->noContent();
    }
}
