<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::with('documents', 'orders.service.category', 'jobCategory')
            ->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Users fetched successfully.',
            'users' => $users
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::with('documents', 'wallet', 'orders.service.category', 'jobCategory', 'subscription')->find($user->id);

        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found',
            ], 404);
        }

        if ($user->is_deleted) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User is deleted',
            ], 404);
        }

        // Vérifier si c'est un professionnel et si son abonnement est expiré
        if ($user->user_type === 'professional' && $user->subscription) {
            if (now()->greaterThan($user->subscription->end_date)) {
                // Désactiver le compte si l'abonnement est expiré
                $user->update(['is_active' => false]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User fetched successfully.',
            'user' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $user = User::find($user->id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|min:6',
            'user_type' => 'nullable|in:student,professional,enthusiast',
            'image_path' => 'nullable|image|max:2048',
            'city' => 'nullable|string',
            'job_category_id' => 'nullable|exists:job_categories,id',
            
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'is_deleted' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_path')) {
            // Supprimer l'ancienne image si elle existe
            if ($user->image_path) {
                Storage::delete($user->image_path);
            }
            // Stocker la nouvelle image
            $imagePath = $request->file('image_path')->store('user_images');
            $validatedData['image_path'] = $imagePath;
        }

        if ($request->has('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.',
            'user' => $user
        ], 200);
    }

    public function uploadUserImage(Request $request)
    {
        $user = $request->user();

        // Vérifier si une image est bien envoyée
        if (!$request->hasFile('image_path')) {
            return response()->json([
                'status' => 'error',
                'message' => 'No image uploaded.',
            ], 400);
        }

        $image = $request->file('image_path');

        // Supprimer l'ancienne image si elle existe
        if ($user->image_path && Storage::disk('public')->exists($user->image_path)) {
            Storage::disk('public')->delete($user->image_path);
        }

        // Stocker la nouvelle image
        $imagePath = $image->store('user_images', 'public');

        // Mettre à jour le chemin de l'image pour l'utilisateur
        $user->image_path = $imagePath;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User image uploaded successfully.',
            'image_url' => Storage::url($imagePath) // Retourner l'URL de l'image
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */

     public function  deleteUser(Request $request)
     {
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found',
            ], 404);
        }
        $user->update([
            'is_deleted' => true,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.',
            
        ], 200);
     }
    public function destroy(User $user)
    {
        //
        $user->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.',
        ], 200);
    }

    public function setAvailability(Request $request)
    {
        $user = User::find($request->user()->id);

        if (!$user->user_type == 'professional') {
            return response()->json([
                'status' => 'failed',
                'message' => 'Seuls les professionnels peuvent modifier leur disponibilité',
            ], 403);
        }

        $user->update([
            'is_available' => $request->is_available,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Disponibilité mise à jour avec succès',
            'is_available' => $user->is_available,
        ], 200);
    }

    public function getProfessionals()
    {
        $professionals = User::where('user_type', 'professional')
            ->withCount(['services as completed_orders_count' => function ($query) {
                $query->join('orders', 'services.id', '=', 'orders.service_id')
                    ->where('orders.status', 'completed');
            }])
            ->get();

        return response()->json([
            'status' => 'success',
            'professionals' => $professionals
        ], 200);
    }

    public function getProfessionalsByJobCategory(string $jobCategory)
    {
        $professionals = User::where('user_type', 'professional')
            ->where('job_category_id', $jobCategory)->get();
        return response()->json([
            'status' => 'success',
            'professionals' => $professionals
        ], 200);
    }

    public function getUserNotifications(Request $request)
    {
        $user = $request->user();
        $notifications = DatabaseNotification::where('notifiable_id', $user->id)->get();
        return response()->json([
            'status' => 'success',
            'notifications' => $notifications
        ], 200);
    }


    public function unlockProfessional(Request $request, $professionalId)
    {
        // On récupère l'utilisateur connecté (client)
        $client = $request->user();

        // On recherche le professionnel par son ID et son user_type
        $professional = User::where('id', $professionalId)
            ->where('user_type', 'professional')
            ->first();

        if (!$professional) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Professionnel introuvable.'
            ], 404);
        }

        // Vérifier si le profil a déjà été débloqué par ce client
        $alreadyUnlocked = DB::table('unlocked_profiles')
            ->where('client_id', $client->id)
            ->where('professional_id', $professionalId)
            ->exists();

        if ($alreadyUnlocked) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Profil déjà débloqué.',
                'professional' => $professional
            ], 200);
        }

        // Vérifier si le client dispose de suffisamment de jetons (balance >= 5)
        if ($client->wallet->balance < 5) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Solde insuffisant. Vous pouvez acheter des jetons pour débloquer le profil.'
            ], 200);
        }

        // Utilisation d'une transaction pour garantir l'atomicité des opérations
        DB::transaction(function () use ($client, $professional) {
            // Déduction de 5 jetons du portefeuille du client
            $client->wallet->decrement('balance', 5);

            // Enregistrement de la transaction de jetons
            DB::table('wallet_transactions')->insert([
                'user_id'    => $client->id,
                'type'       => 'debit',
                'amount'     => 5,
                'description' => 'Déblocage du profil de ' . $professional->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Marquer le profil professionnel comme débloqué par le client
            DB::table('unlocked_profiles')->insert([
                'client_id'        => $client->id,
                'professional_id'  => $professional->id,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Profil débloqué avec succès.',
            'professional' => $professional
        ], 200);
    }
}
