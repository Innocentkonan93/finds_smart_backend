<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Notifications\NewServiceNotification;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $services = Service::with('user', 'category')
            ->paginate($request->get('per_page', 10));

        return response()->json([
            'status' => 'success',
            'message' => 'Services récupérés avec succès',
            'services' => $services
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
    
        // Gestion de l'upload de l'image si présente
        if ($request->hasFile('image_path')) {
            $validatedData['image_path'] = $request->file('image_path')->store('services', 'public');
        }
    
        $service = Service::create($validatedData);

        $user = User::find($service->user_id);
        $user->notify(new NewServiceNotification($service));
    
        return response()->json([
            'status' => 'success',
            'message' => 'Service créé avec succès',
            'service' => $service->load('user', 'category')
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(Service $service): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Service récupéré avec succès',
            'service' => $service->load('user', 'category')
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service): JsonResponse
    {
        $service->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Service mis à jour avec succès',
            'service' => $service
        ], 200);
    }


public function uploadServiceImage(Request $request)
{
    $service = Service::find($request->service_id);

    // Vérifier si le service existe
    if (!$service) {
        return response()->json([
            'status' => 'error',
            'message' => 'Service introuvable.',
        ], 404);
    }

    // Vérifier si un fichier a été envoyé
    if (!$request->hasFile('image_path')) {
        return response()->json([
            'status' => 'error',
            'message' => 'Aucune image envoyée.',
        ], 400);
    }

    $image = $request->file('image_path');

    // Supprimer l'ancienne image si elle existe
    if ($service->image_path && Storage::disk('public')->exists($service->image_path)) {
        Storage::disk('public')->delete($service->image_path);
    }

    // Stocker la nouvelle image
    $imagePath = $image->store('services', 'public');

    // Mettre à jour l'image du service
    $service->update(['image_path' => $imagePath]);

    return response()->json([
        'status' => 'success',
        'message' => 'Image téléchargée avec succès.',
        'service' => $service,
        'image_url' => Storage::url($imagePath), // Retourner l'URL de l'image
    ], 200);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): JsonResponse
    {
        $service->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Service supprimé avec succès'
        ], 200);
    }

    public function getServicesByUser(Request $request)
    {
        $services = Service::where('user_id', $request->user_id) ->with('user', 'category')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Services récupérés avec succès',
            'services' => $services
        ], 200);
    }

    public function getUserServicesByCategory(string $user_id, string $category)
    {
        $service = Service::where('user_id', $user_id)->where('category_id', $category)->first();

        if (!$service) {
            return response()->json([
                'status' => 'error',
                'message' => 'Service non trouvé'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Service récupéré avec succès',
            'service' => $service->load('user', 'category')
        ], 200);
    }
}
