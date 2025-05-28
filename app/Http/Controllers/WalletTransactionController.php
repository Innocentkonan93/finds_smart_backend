<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWalletTransactionRequest;
use App\Http\Requests\UpdateWalletTransactionRequest;
use App\Models\WalletTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletTransactionController extends Controller
{
    /**
     * Affiche la liste de toutes les transactions de portefeuille.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $walletTransactions = WalletTransaction::where('user_id', $user->id)->get();

        return response()->json([
            "status" => "success",
            "wallet_transactions" => $walletTransactions,
        ], 200);
    }

    /**
     * Affiche le formulaire de création d'une transaction.
     *
     * (Méthode non utilisée pour une API REST, mais conservée pour la compatibilité)
     */
    public function create()
    {
        //
    }

    /**
     * Stocke une nouvelle transaction dans la base de données.
     */
    public function store(StoreWalletTransactionRequest $request): JsonResponse
    {
        $walletTransaction = WalletTransaction::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction créée avec succès',
            'wallet_transaction' => $walletTransaction,
        ], 201);
    }

    /**
     * Affiche une transaction de portefeuille spécifique.
     */
    public function show(WalletTransaction $walletTransaction): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'wallet_transaction' => $walletTransaction,
        ], 200);
    }

    /**
     * Affiche le formulaire pour l'édition d'une transaction.
     *
     * (Méthode non utilisée pour une API REST)
     */
    public function edit(WalletTransaction $walletTransaction)
    {
        //
    }

    /**
     * Met à jour une transaction existante dans la base de données.
     */
    public function update(UpdateWalletTransactionRequest $request, WalletTransaction $walletTransaction): JsonResponse
    {
        $walletTransaction->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction mise à jour avec succès',
            'wallet_transaction' => $walletTransaction,
        ], 200);
    }

    /**
     * Supprime une transaction de la base de données.
     */
    public function destroy(WalletTransaction $walletTransaction): JsonResponse
    {
        $walletTransaction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction supprimée avec succès'
        ], 200);
    }

    public function userWalletTransactions(Request $request): JsonResponse
{
    // Récupérer l'utilisateur authentifié
    $user = $request->user(); 
    
    $transactions = WalletTransaction::where('user_id', $user->id)->get();

    return response()->json([
         'status' => 'success',
         'wallet_transactions' => $transactions,
    ], 200);
}
}
