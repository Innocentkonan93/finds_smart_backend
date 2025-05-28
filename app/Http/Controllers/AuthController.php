<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserType;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Mail\VerificationCodeMail;
use App\Mail\CongratulationsVerificationMail;
use Illuminate\Support\Facades\Log;
use App\Models\Wallet;
class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'birth_date' => 'required|date',
            'country' => 'required|string',
            'city' => 'required|string',
            'experience_years' => 'nullable|integer|min:0',
            'user_type' => 'required|in:client,professional',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|unique:users',
            'password' => 'required|min:6|confirmed',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'job_category_id' => 'nullable|exists:job_categories,id',
        ]);

        if ($request->hasFile('image_path')) {
            // Stocker l'image dans le répertoire 'user_images' dans storage/app/public
            $imagePath = $request->file('image_path')->store('user_images', 'public');
            $validatedData['image_path'] = $imagePath;
        }

        $validatedData['password'] = bcrypt($validatedData['password']);
        // Générer un code de vérification à 6 chiffres
        $verificationCode = rand(100000, 999999);

        // Ajouter le code de vérification et la date d'envoi dans les données validées
        $validatedData['email_verification_code'] = $verificationCode;
        $validatedData['email_verified_at'] = null;
        $validatedData['role'] = UserRole::USER;
        $validatedData['user_type'] = UserType::from($request->user_type);
        $validatedData['is_active'] = false;
        $validatedData['is_available'] = true;
        $validatedData['is_deleted'] = false;
        $validatedData['job_category_id'] = $request->job_category_id;

        $user = User::create($validatedData);

        // Envoyer un email de vérification à l'utilisateur
        try {
            Log::info('Tentative d\'envoi d\'email de vérification à : ' . $user->email);
            Mail::to($user->email)->send(new VerificationCodeMail($user));
            Log::info('Email envoyé à : ' . $user->email);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
            return response()->json([
                'message' => 'L\'envoi de l\'email de vérification a échoué. Veuillez réessayer.',
                'error' => $e->getMessage()
            ], 500);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        Wallet::create([
            'user_id' => $user->id,
            'balance' => 0 // Ou un bonus de bienvenue 👀
        ]);

        return response()->json([
            'message' => 'User created successfully. Verification email sent.',
            'status' => 'success',
            'user' => $user,
            'token' => $token
        ], 201);
    }


    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)
            ->where('email_verification_code', $request->verification_code)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid verification code or email.'
            ], 400);
        }

        // Marquer l'email comme vérifié
        $user->email_verified_at = now();
        $user->email_verification_code = null;  // Supprimer le code de vérification
        $user->is_active = true;  // Supprimer le code de vérification
        $user->save();


        // Envoyer un email de félicitations pour la vérification
        try {
            Log::info('Tentative d\'envoi d\'email de félicitations à : ' . $user->email);
            Mail::to($user->email)->send(new CongratulationsVerificationMail($user));
            Log::info('Email de félicitations envoyé à : ' . $user->email);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'email de félicitations : ' . $e->getMessage());
            return response()->json([
                'message' => 'L\'envoi de l\'email de félicitations a échoué. Veuillez réessayer.',
                'error' => $e->getMessage()
            ], 500);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Email verified successfully.',
            'user' => $user
        ], 200);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::with('documents')->where('email', $request->email)->first();
        
        if($user->is_deleted){
            return response()->json([
                'status' => 'failed',
                'message' => 'Votre compte a été désactivé.',
            ], 400);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Les informations de connexion sont incorrectes.'],
            ]);
        }

        if( $user->user_type == 'professional' && $user->activation_due_date && $user->activation_due_date < now()){
            $user->is_active = false;
            $user->save();
        }

        $user->is_available = true;
        $user->save();

        return response()->json([
            'status' => 'success',
            'token' => $user->createToken('API Token')->plainTextToken,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $user = $request->user();
        $user->is_available = false;
        $user->save();
        return response()->json(['message' => 'Déconnexion réussie']);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required',

        ]);

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Le mot de passe actuel est incorrect.',
            ], 200);
        }

        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Mot de passe mis à jour avec succès.',
        ], 200);
    }
}
