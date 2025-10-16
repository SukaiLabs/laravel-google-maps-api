<?php

namespace Cyna\GoogleMaps\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Cyna\GoogleMaps\Http\Requests\StoreAddressHistoryRequest;
use Cyna\GoogleMaps\Http\Resources\AddressHistoryResource;
use Cyna\GoogleMaps\Models\AddressHistory;

class AddressHistoryController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the user's address histories.
     *
     * @param Request $request
     * @response 200 array{data: AddressHistoryResource[]}
     * @group Address History
     */
    public function index(Request $request): JsonResponse
    {
        $addresses = AddressHistory::forUser(Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'data' => AddressHistoryResource::collection($addresses)
        ]);
    }

    /**
     * Store a newly created address history.
     *
     * @param StoreAddressHistoryRequest $request
     * @response 201 array{data: AddressHistoryResource}
     * @response 422 array{message: string, errors: array}
     * @group Address History
     */
    public function store(StoreAddressHistoryRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        $address = AddressHistory::create($validated);

        return response()->json([
            'data' => new AddressHistoryResource($address)
        ], 201);
    }

    /**
     * Display the specified address history.
     *
     * @param AddressHistory $addressHistory
     * @response 200 array{data: AddressHistoryResource}
     * @response 403 array{message: string}
     * @group Address History
     */
    public function show(AddressHistory $addressHistory): JsonResponse
    {
        $this->authorize('view', $addressHistory);

        return response()->json([
            'data' => new AddressHistoryResource($addressHistory)
        ]);
    }

    /**
     * Remove the specified address history from storage.
     *
     * @param AddressHistory $addressHistory
     * @response 204
     * @response 403 array{message: string}
     * @group Address History
     */
    public function destroy(AddressHistory $addressHistory): JsonResponse
    {
        $this->authorize('delete', $addressHistory);

        $addressHistory->delete();

        return response()->json(null, 204);
    }
}
