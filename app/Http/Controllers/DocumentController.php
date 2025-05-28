<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Afficher la liste des documents de l'utilisateur connecté.
     */
    public function index()
    {
        // Récupère tous les documents de l'utilisateur connecté
        $documents = Document::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Documents récupérés avec succès.',
            'documents' => $documents
        ], 200);
    }

    /**
     * Afficher le formulaire pour créer un nouveau document.
     */
    public function create()
    {
        // Optionnel : Si tu souhaites utiliser cette méthode pour une interface web, tu peux retourner une vue.
        return view('documents.create');
    }

    /**
     * Enregistrer un nouveau document dans la base de données.
     */
    public function store(StoreDocumentRequest $request)
    {
        if ($request->hasFile('document')) {
            // Vérifie que le fichier est valide
            $request->validate([
                'document' => 'required|file|mimes:pdf,jpg,png,docx|max:2048', // Validation si nécessaire
            ]);
    
            // Stocke le fichier
            $path = $request->file('document')->store('documents', 'public');
    
            // Créer un document en base de données
            $document = Document::create([
                'file_path' => $path,
                'original_name' => $request->file('document')->getClientOriginalName(),
                'user_id' => $request->user_id, // L'utilisateur connecté
                'type' => $request->type,
            ]);
    
            // Retourner la réponse
            return response()->json([
                'status' => 'success',
                'message' => 'Document uploaded successfully.',
                'document' => $document,
            ], 201);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No document file uploaded.'
            ], 400);
        }
    }

    public function upload(StoreDocumentRequest $request)
    {
        if ($request->hasFile('document')) {
            // Vérifie que le fichier est valide
            $request->validate([
                'document' => 'required|file|mimes:pdf,jpg,png,docx|max:2048', // Validation si nécessaire
            ]);
    
            // Stocke le fichier
            $path = $request->file('document')->store('documents', 'public');
    
            // Créer un document en base de données
            $document = Document::create([
                'file_path' => $path,
                'original_name' => $request->file('document')->getClientOriginalName(),
                'user_id' => $request->user_id, // L'utilisateur connecté
                'type' => $request->type,
            ]);
    
            // Retourner la réponse
            return response()->json([
                'status' => 'success',
                'message' => 'Document uploaded successfully.',
                'document' => $document,
            ], 201);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No document file uploaded.'
            ], 400);
        }
    }

    /**
     * Afficher un document spécifique.
     */
    public function show(Document $document, $id)
    {
        // Vérifier que le document appartient à l'utilisateur connecté
        if ($document->user_id !== $id) {
            return response()->json(['message' => 'Accès non autorisé.'], 403);
        }

        return response()->json($document);
    }

    /**
     * Afficher le formulaire pour éditer un document spécifique.
     */
    public function edit(Document $document)
    {
        // Optionnel : Utilisé pour une interface web où tu veux éditer un document.
        return view('documents.edit', compact('document'));
    }

    /**
     * Mettre à jour un document spécifique dans la base de données.
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        // Vérifier que l'utilisateur est propriétaire du document
        if ($document->user_id !== $request->user_id) {
            return response()->json(['message' => 'Accès non autorisé.'], 403);
        }

        // Si un nouveau fichier est téléchargé
        if ($request->hasFile('document')) {
            // Supprimer l'ancien fichier
            Storage::delete($document->file_path);

            // Stocker le nouveau fichier
            $path = $request->file('document')->store('documents', 'public');
            $document->file_path = $path;
            $document->original_name = $request->file('document')->getClientOriginalName();
        }

        // Mettre à jour les autres informations (si nécessaire)
        $document->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Document updated successfully.',
            'document' => $document
        ], 200);
    }

    /**
     * Supprimer un document de la base de données.
     */
    public function destroy(Document $document, $id)
    {
        // Vérifier que l'utilisateur est propriétaire du document
        if ($document->user_id !== $id) {
            return response()->json(['message' => 'Accès non autorisé.'], 403);
        }

        // Supprimer le fichier physique du disque
        Storage::delete($document->file_path);

        // Supprimer le document de la base de données
        $document->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Document deleted successfully.',
        ], 200);
    }
}
