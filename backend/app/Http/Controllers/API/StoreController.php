<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\CreateStoreRequest;
use App\Http\Requests\Store\UpdateStoreRequest;
use App\Models\Store;
use App\Services\StoreService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StoreController extends Controller
{
    public function __construct(
        private StoreService $storeService
    )
    {
        
    }

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
    public function store(CreateStoreRequest $request)
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

            
            $store = $this->storeService->store([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $imageUrl,
                'public_id' => $publicId,
                'whatsapp' => $request->whatsapp,
                'owner_id' => Auth::user()->id,
                'chave_pix' => $request->chave_pix,
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
    public function update(UpdateStoreRequest $request, Store $store)
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

            
            $storeUpdated = $this->storeService->update([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $imageUrl ?? $store->image,
                'whatsapp' => $request->whatsapp,
                'public_id' => $publicId ?? $store->public_id,
                'chave_pix' => $request->chave_pix ?? $store->chave_pix,
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

            
            $storeDeleted = $this->storeService->destroy($store);

            return response(['store' => $storeDeleted], 200);
        } catch (Exception $e) {
            return response(['message' => $e], 500);
        }
    }

    public function changeActive(Store $store)
    {
        
        $storeUpdated =  $this->storeService->changeActive($store);

        return response(['store' => $storeUpdated], 200);
    }
}
