<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnlockedProfileRequest;
use App\Http\Requests\UpdateUnlockedProfileRequest;
use App\Models\UnlockedProfile;
use Illuminate\Http\Request;

class UnlockedProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreUnlockedProfileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UnlockedProfile $unlockedProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnlockedProfile $unlockedProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnlockedProfileRequest $request, UnlockedProfile $unlockedProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnlockedProfile $unlockedProfile)
    {
        //
    }


    public function getUnlockedProfiles(Request $request)
    {
        // Récupère l'utilisateur authentifié (client)
        $client = $request->user();
        
        // Récupère les professionnels débloqués
        $unlockedProfiles = $client->unlockedProfessionalProfiles()->pluck('professional_id');

        return response()->json([
            'status' => 'success',
            'unlocked_profiles' => $unlockedProfiles
        ], 200);
    }
}
