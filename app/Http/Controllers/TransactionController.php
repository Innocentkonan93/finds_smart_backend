<?php

namespace App\Http\Controllers;

use App\Services\PaiementProService;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Enums\TransactionStatus;
use App\Models\User;
use App\Notifications\PaymentNotification;
use App\Models\Pack;
use App\Models\WalletTransaction;
use App\Enums\PackStatus;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{

    public function index()
    {
        $transactions = Transaction::all();
        return response()->json([
            'success' => true,
            'transactions' => $transactions
        ]);
    }


    public function init(Request $request, PaiementProService $paiementPro)
    {
        $data = [
            'amount' => $request->amount,
            'description' => $request->description,
            'channel' => $request->channel,
            'referenceNumber' => 'FS-' . time(),
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'context' => $request->returnContext,
        ];


        $result = $paiementPro->initPayment($data);
        Log::channel('paiementpro')->info("Callback initPayment reçu", $request->all());

        if (isset($result['success']) && $result['success']) {
            Transaction::create([
                'user_id' => $request->user()->id,
                'reference' => $data['referenceNumber'],
                'status' => TransactionStatus::PENDING,
                'amount' => $request->amount,
                'channel' => $request->channel,
            ]);

            return response()->json([
                'success' => true,
                'url' => $result['url']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Erreur lors du paiement'
        ]);
    }

    public function notify(Request $request)
    {
        Log::channel('paiementpro')->info("Callback notify reçu", $request->all());
        $expectedHash = hash('sha512', $request->referenceNumber . env('PMP_MERCHANT_ID') . $request->amount);

        if ($request->hashcode !== $expectedHash) {
            \Illuminate\Support\Facades\Log::warning('PaiementPro hash invalide', $request->all());
            return response('Hash invalide', 403);
        }

        if ($request->code == 0 || $request->responsecode == 0) {
            $transaction = Transaction::updateOrCreate(
                ['reference' => $request->referenceNumber],
                [
                    'status' => TransactionStatus::SUCCESS, // Exemple : SUCCESS, FAILED
                    'amount' => $request->amount,
                    'channel' => $request->channel,
                    'metadata' => $request->all(),
                ]
            );

            $returnContext = json_decode($request->returnContext, true);

            $pack_id = $returnContext['pack_id'];
            $pack = Pack::find($pack_id);
            $user = User::find($transaction->user_id);
            $userType = $user->user_type;
            $userWallet = $user->wallet;

            if ($pack && $userType == 'client') {
                $userWallet->balance += $pack->coins;
                $userWallet->save();
                WalletTransaction::create([
                    'user_id' => $user->id,
                    'amount' => $pack->price,
                    'type' => 'credit',
                    'description' => 'Achat de pack ' . $pack->name,
                ]);
            }

            if ($pack && $userType == 'professional') {
                $user->is_active = true;
                $user->activation_due_date = now()->addMonths($pack->duration);
                $user->save();
            }


            $user->notify(new PaymentNotification($transaction, true));
        } else {
            $transaction = Transaction::find($request->transaction_id);
            if ($transaction) {
                $transaction->status = TransactionStatus::FAILED;
                $transaction->metadata = $request->all();
                $transaction->save();
            }
            $user = User::find($transaction->user_id);
            $user->notify(new PaymentNotification($transaction, false));
        }
        // Enregistre ou met à jour la transaction dans la base

        return response('OK', 200);
    }

    public function retour(Request $request)
    {
        // ✅ Récupérer les données depuis l’URL
        $referenceNumber = $request->query('referenceNumber');
        $amount = $request->query('amount');
        $responseCode = $request->query('responsecode');

        $returnContextRaw = $request->input('returnContext');

        // Cas où PaiementPro t’envoie %221:4%22 → tu peux faire :
        $returnContextClean = trim(urldecode(is_array($returnContextRaw) ? $returnContextRaw[0] ?? '' : $returnContextRaw), '"');
        
    

        // return $responseCode;
        // 🧪 DEBUG temporaire
        Log::info('✅ returnContext décodé', [
            'raw' => $request->input('returnContext'),
            'parsed' => $returnContextClean,
        ]);


        if ($responseCode == -1) {

            // ❌ Échec du paiement
            $transaction = Transaction::where('reference', $referenceNumber)->first();
            // return $transaction;
            if ($transaction) {
                $transaction->update([
                    'status' => TransactionStatus::FAILED,
                    'metadata' => $request->all(),
                ]);
                $user = User::find($transaction->user_id);
                $user?->notify(new PaymentNotification($transaction, false));
            }

            return view('paiement.failed');

        } else if ($responseCode == 0 || $request->code == 0) {
            [$userId, $packId] = explode(':', $returnContextClean);

            if (!$userId) {
                return response("Erreur : user_id manquant dans returnContext", 400);
            }

            $user = User::find($userId);
            $pack = Pack::find($packId);


            $transaction = Transaction::updateOrCreate(
                ['reference' => $referenceNumber],
                [
                    'user_id' => $user?->id,
                    'status' => TransactionStatus::SUCCESS,
                    'amount' => $amount,
                    'channel' => $request->query('channel'),
                    'metadata' => $request->all(),
                ]
            );

            if ($user && $pack) {
                if ($user->user_type == 'client') {
                    $user->wallet->increment('balance', $pack->coins);

                    WalletTransaction::create([
                        'user_id' => $user->id,
                        'amount' => $pack->price,
                        'type' => 'credit',
                        'description' => 'Achat de pack ' . $pack->name,
                    ]);
                }

                if ($user->user_type == 'professional') {
                    // return [$user, $pack];
                    $user->update([
                        'is_active' => true,
                        'activation_due_date' => now()->addMonths($pack->duration),
                    ]);
                }

                $user->notify(new PaymentNotification($transaction, true));
                return $user;
            }

            return view('paiement.success', [
                'transaction' => $transaction,
                'user' => $user,
            ]);
        }
    }

}
