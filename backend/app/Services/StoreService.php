<?php

namespace App\Services;

use App\Models\Store;

class StoreService
{
    private Store $store;

    public static function index()
    {
        $stores = Store::all();

        return $stores;
    }

    public function store(array $data)
    {
        $this->store = Store::create($data);

        return $this->store;
    }

    public function update(array $data, Store $store)
    {   
        $this->store = $store;

        $this->store->update($data);

        return $this->store;
    }

    public function destroy(Store $store)
    {   
        $this->store = $store;

        $this->store->delete();

        return $this->store;
    }

    public function changeActive(Store $store)
    {
        $this->store = $store;

        $this->store->update([
            'active' => !$store->active,
        ]);

        return $this->store;
    }
}
