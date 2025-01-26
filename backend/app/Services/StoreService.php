<?php

namespace App\Services;

use App\Models\Store;

class StoreService
{
    public static function index()
    {
        $stores = Store::all();

        return $stores;
    }

    public static function store(array $data)
    {
        $store = Store::create($data);

        return $store;
    }

    public static function update(array $data, Store $store)
    {
        $store->update($data);

        return $store;
    }

    public static function destroy(Store $store)
    {
        $store->delete();

        return $store;
    }

    public static function changeActive(Store $store)
    {
        $store->update([
            'active' => !$store->active,
        ]);

        return $store;
    }
}
