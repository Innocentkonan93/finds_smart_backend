<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Models\Pack;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = Subscription::with('pack', 'user')->get();
        return response()->json([
            'success' => true,
            'message' => 'Subscriptions retrieved successfully',
            'subscriptions' => $subscriptions
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request): JsonResponse
    {
        $user = User::findOrFail($request->user_id);
        $pack = Pack::findOrFail($request->pack_id);

        // Vérifier si l'utilisateur a déjà une souscription
        $existingSubscription = Subscription::where('user_id', $user->id)->first();

        // Calcul de la nouvelle date de fin
        $startDate = now();
        $endDate = $startDate->copy()->addMonths($pack->duration);

        if ($existingSubscription) {
            // Mettre à jour la souscription existante
            $existingSubscription->update([
                'pack_id' => $pack->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
            ]);
        } else {
            // Créer une nouvelle souscription si aucune n'existe
            $existingSubscription = Subscription::create([
                'user_id' => $user->id,
                'pack_id' => $pack->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
            ]);
        }

        // Activer le compte utilisateur si ce n'est pas déjà fait
        if (!$user->is_active) {
            $user->update(['is_active' => true]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Souscription mise à jour avec succès, votre compte est actif.',
            'subscription' => $existingSubscription->load('pack', 'user')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        $subscription = Subscription::with('pack', 'user')->find($subscription->id);
        return response()->json([
            'success' => true,
            'message' => 'Subscription retrieved successfully',
            'subscription' => $subscription
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        $subscription->update($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Subscription updated successfully',
            'subscription' => $subscription
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return response()->json([
            'success' => true,
            'message' => 'Subscription deleted successfully',
            'subscription' => null
        ], 204);
    }
}
