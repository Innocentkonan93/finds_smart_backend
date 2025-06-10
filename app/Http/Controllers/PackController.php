<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackRequest;
use App\Http\Requests\UpdatePackRequest;
use App\Models\Pack;
use Illuminate\Http\Request;

class PackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packs = Pack::with('benefits')->get();
        return response()->json([
            'success' => true,
            'message' => 'Packs récupérés avec succès',
            'packs' => $packs
        ]);
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackRequest $request)
    {
        $validatedData = $request->validated();
        $pack = Pack::create($validatedData);
        if(isset($validatedData['benefits'])){
            // $pack->benefits()->sync($validatedData['benefits']);
            foreach($validatedData['benefits'] as $benefit){
                $pack->benefits()->create([
                    'benefit' => $benefit
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Pack créé avec succès',
            'data' => $pack
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pack $pack)
    {
        return response()->json([
            'success' => true,
            'message' => 'Pack récupéré avec succès',
            'data' => $pack
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackRequest $request, Pack $pack)
    {
        $pack->update($request->validated());
        if ($request->has('benefits')) {
            $pack->benefits()->delete();
            $pack->benefits()->createMany($request->benefits);
        }
        return response()->json([
            'success' => true,
            'message' => 'Pack updated successfully',
            'data' => $pack
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pack $pack)
    {
        $pack->delete();
        return response()->json([
            'success' => true,
            'message' => 'Pack supprimé avec succès',
            'data' => null
        ], 204);
    }

    
    
}
