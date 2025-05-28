<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackBenefitRequest;
use App\Http\Requests\UpdatePackBenefitRequest;
use App\Models\PackBenefit;

class PackBenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $packBenefits = PackBenefit::all();
        return response()->json([
            'success' => true,
            'message' => 'Pack benefits retrieved successfully',
            'data' => $packBenefits
        ], 200);
    }

 
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackBenefitRequest $request)
    {
        //
        $packBenefit = PackBenefit::create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Pack benefit created successfully',
            'data' => $packBenefit
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PackBenefit $packBenefit)
    {
        //
        return response()->json([
            'success' => true,
            'message' => 'Pack benefit retrieved successfully',
            'data' => $packBenefit
        ], 200);
    }

 

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackBenefitRequest $request, PackBenefit $packBenefit)
    {
        //
        $packBenefit->update($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Pack benefit updated successfully',
            'data' => $packBenefit
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackBenefit $packBenefit)
    {
            //
        $packBenefit->delete();
        return response()->json([
            'success' => true,
            'message' => 'Pack benefit deleted successfully',
            'data' => null
        ], 204);
    }
}
