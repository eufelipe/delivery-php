<?php

namespace App\Observers;

use App\Constants\Constants;
use App\Models\Delivery;
use Illuminate\Support\Facades\Cache;

class DeliveryObserver
{

    /**
     * Método para limpar (zerar) os registros no cache.
     */
    public function clear_cache()
    {
        Cache::forget(Constants::DELIVERIES_CACHE_KEY);
    }

    /**
     * Handle the delivery "created" event.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return void
     */
    public function created(Delivery $delivery)
    {
         $this->clear_cache();
    }

    /**
     * Handle the delivery "updated" event.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return void
     */
    public function updated(Delivery $delivery)
    {
         $this->clear_cache();
    }

    /**
     * Handle the delivery "deleted" event.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return void
     */
    public function deleted(Delivery $delivery)
    {
         $this->clear_cache();
    }

    /**
     * Handle the delivery "restored" event.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return void
     */
    public function restored(Delivery $delivery)
    {
         $this->clear_cache();
    }

    /**
     * Handle the delivery "force deleted" event.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return void
     */
    public function forceDeleted(Delivery $delivery)
    {
         $this->clear_cache();
    }
}
