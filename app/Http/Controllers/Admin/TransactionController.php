<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function transactionsList()
    {
        $transactions = Transaction::paginate(10);
        return view('admin.transactions.transactionsList', compact('transactions'));
    }

    public function viewTransaction($id)
    {
        $transaction = Transaction::find($id);
        return view('admin.transactions.viewTransaction', compact('transaction'));
    }

    public function addTransaction()
    {
        return view('admin.transactions.addTransaction');
    }
    

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'reference' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'amount' => 'required|numeric', 
            'channel' => 'required|string|max:255',
        ]);

        Transaction::create($request->all());
        return redirect()->route('transactionsList')->with('success', 'Transaction créée avec succès');
    }

    public function updateTransaction(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        $transaction->update($request->all());
        return redirect()->route('transactionsList')->with('success', 'Transaction mise à jour avec succès');
    }

    public function deleteTransaction($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return redirect()->route('transactionsList')->with('success', 'Transaction supprimée avec succès');
    }
}