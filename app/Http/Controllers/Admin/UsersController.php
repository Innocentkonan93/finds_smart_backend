<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
class UsersController extends Controller
{
    public function addUser()
    {
        return view('admin.users.addUser');
    }
    
    public function usersGrid()
    {
        $users = User::where('role', '!=', 'admin')->paginate(12);
        return view('admin.users.usersGrid', compact('users'));
    }

    public function usersList()
    {
        $users = User::where('role', '!=', 'admin')->with('jobCategory')->paginate(10);
        return view('admin.users.usersList', compact('users'));
    }

    public function clientsList()
    {
        $users = User::where('user_type', 'client')->paginate(10);
        return view('admin.users.clientsList', compact('users'));
    }

    public function professionalsList()
    {
        $users = User::where('user_type', 'professional')->paginate(10);
        return view('admin.users.professionalsList', compact('users'));
    }
    
    public function viewProfile($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.viewProfile', compact('user'));
    }


    public function storeUser(Request $request)
    {
 

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'user_type' => 'required|in:client,professional',
            'image_path' => 'nullable|image|max:2048',  // Image optionnelle, taille max 2 Mo
            'phone' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'role' => 'required|in:user,admin,moderator,author',
        ]);
        // Stocker l'image si elle est fournie
        if ($request->hasFile('image_path')) {
            // Stocker l'image dans le répertoire 'user_images' dans storage/app/public
            $imagePath = $request->file('image_path')->store('users');
            $validatedData['image_path'] = $imagePath;
        }
        // Hacher le mot de passe
        $validatedData['password'] = bcrypt(123456);
        $validatedData['is_active'] = true;
        $validatedData['role'] = $request->role;
        $validatedData['is_active'] = false;
        $validatedData['is_available'] = true;
        $validatedData['is_deleted'] = false;
        $validatedData['email_verified_at'] = now();  // Par défaut, email non vérifié

        // Créer l'utilisateur avec les données validées
        $user = User::create($validatedData);


        return redirect()->route('usersList')->with('success', 'Utilisateur créé avec succès.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_type' => 'required|in:client,professional',
            'image_path' => 'nullable|image|max:2048',  // Image optionnelle, taille max 2 Mo
            'phone_number' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
            'role' => 'required|in:user,admin',
            'city' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
        ]);

        // Stocker l'image si elle est fournie
        if ($request->hasFile('image_path')) {
            // Stocker l'image dans le répertoire 'user_images' dans storage/app/public
            $imagePath = $request->file('image_path')->store('users');
            $validatedData['image_path'] = $imagePath;
        }
        // Hacher le mot de passe

        // $validatedData['email_verified_at'] = now();  // Par défaut, email non vérifié

        if($request->hasFile('password')){
            $validatedData['password'] = bcrypt($request->password);
        }

        // Créer l'utilisateur avec les données validées
        $user->update($validatedData);

        return redirect()->route('viewProfile', $user->id)->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Hacher le mot de passe
        $user->is_deleted = true;
        $user->is_active = false;
        $user->save();
        // Créer l'utilisateur avec les données validées
        $user->delete();

        return redirect()->route('usersList')->with('success', 'Utilisateur supprimé avec succès.');
    }
    

}
