<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Models\Store;
use App\Services\StoreService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = StoreService::index();

        return response(['stores' => $stores], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if (Gate::allows('user-store')) {
            return response(['message' => 'User already has a store.'], 401);
        }

        try {
            $imageUrl = null;
            $publicId = null;
            if ($request->file('image')) {
                $uploadResult = cloudinary()->upload($request->file('image')->getRealPath(), [
                    'folder' => 'store_images',
                ]);

                $imageUrl = $uploadResult->getSecurePath();
                $publicId = $uploadResult->getPublicId();
            }

            $store = StoreService::store([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $imageUrl,
                'public_id' => $publicId,
                'whatsapp' => $request->whatsapp,
                'owner_id' => Auth::user()->id,
            ]);

            return response(['store' => $store], 201);
        } catch (Exception $e) {
            return response(['message' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        return response(['store' => $store], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Store $store)
    {
        try {
            $imageUrl = null;
            $publicId = null;
            if ($request->file('image')) {
                if ($store->image && $store->public_id) {
                    cloudinary()->uploadApi()->destroy($store->public_id);
                }

                $uploadResult = cloudinary()->upload($request->file('image')->getRealPath(), [
                    'folder' => 'store_images',
                ]);

                $imageUrl = $uploadResult->getSecurePath();
                $publicId = $uploadResult->getPublicId();
            }

            $storeUpdated = StoreService::update([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $imageUrl ?? $store->imagem,
                'whatsapp' => $request->whatsapp,
                'public_id' => $publicId ?? $store->public_id,
            ], $store);

            return response(['store' => $storeUpdated], 200);
        } catch (Exception $e) {
            return response(['message' => $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        try {
            if ($store->image && $store->public_id) {
                cloudinary()->uploadApi()->destroy($store->public_id);
            }

            $storeDeleted = StoreService::destroy($store);

            return response(['store' => $storeDeleted], 200);
        } catch (Exception $e) {
            return response(['message' => $e], 500);
        }
    }

    public function changeActive(Store $store)
    {
        $storeUpdated = StoreService::changeActive($store);

        return response(['store' => $storeUpdated], 200);
    }
}
