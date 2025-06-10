<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWalletRequest;
use App\Http\Requests\UpdateWalletRequest;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Pack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = Wallet::all();
        return response()->json([
            'status' => 'success',
            'data' => $wallets
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWalletRequest $request)
    {
        $wallet = Wallet::create($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $wallet
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        return response()->json([
            'status' => 'success',
            'data' => $wallet
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWalletRequest $request, Wallet $wallet)
    {
        $wallet->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $wallet
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        $wallet->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Wallet deleted successfully'
        ], 200);
    }

    public function topUpWallet(UpdateWalletRequest $request)
    {
        $wallet = Wallet::find($request->wallet_id);
        $wallet->balance += $request->amount;
        $wallet->save();

        WalletTransaction::create([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'type' => 'credit',
            'description' => 'Recharge de ' . $request->amount,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Wallet updated successfully'
        ], 200);
    }

    public function buyPack(Request $request)
    {

        $user = Auth::user();
        $pack = Pack::find($request->pack_id);
        $wallet = Wallet::find($request->wallet_id);

        if(!$wallet){
            return response()->json([
                'status' => 'failed',
                'message' => 'Vous n\'avez pas de porte-monnaie'
            ], 400);
        }

        if(!$pack){
            return response()->json([
                'status' => 'failed',
                'message' => 'Le pack n\'existe pas'
            ], 400);
        }
        

        if ($pack->type == 'client' && $user->user_type == 'client') {
            $wallet->balance += $pack->coins;
            $wallet->save();

            DB::table('wallet_transactions')->insert([
                'user_id'    => $user->id,
                'type'       => 'credit',
                'amount'     => $pack->coins,
                'description' => 'Rechargement du portefeuille',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pack achété avec succès',
                'wallet' => $wallet,
                'pack' => $pack
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Vous ne pouvez pas acheter un pack si vous êtes un professionnel'
            ], 400);
        }
    }
}
