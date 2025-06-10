<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Models\Ad;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Notifications\AdValidatedNotification;
class AdController extends Controller
{
    /**
     * Liste des annonces.
     */
    public function index(): JsonResponse
    {
        $ads = Ad::with('user', 'category')->latest()->get();

        return response()->json([
            'status' => 'success',
            'ads' => $ads
        ], 200);
    }

    /**
     * Créer une nouvelle annonce.
     */
    public function store(StoreAdRequest $request): JsonResponse
    {
        $ad = Ad::create([
            'user_id' => $request->user_id, // Récupérer l'utilisateur connecté
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $request->budget,
            'start_date' => $request->start_date,
            'city' => $request->city,
            'district' => $request->district,
            'status' => 'pending',
        ]);
        //
        $user = User::find($ad->user_id);
        $user->notify(new AdValidatedNotification($ad));
        
        return response()->json([
            'status' => 'success',
            'message' => 'Annonce créée avec succès.',
            'ad' => $ad
        ], 201);
    }
    /**
     * Voir une annonce.
     */
    public function show(Ad $ad): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'ad' => $ad->load('user', 'category')
        ], 200);
    }

    /**
     * Supprimer une annonce.
     */
    public function destroy(Ad $ad): JsonResponse
    {
        $ad->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Annonce supprimée avec succès.'
        ], 200);
    }
}