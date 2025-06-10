<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
class OrdersController extends Controller
{
    //
    public function ordersList()
    {
        $orders = Order::with(['client', 'professional', 'service.category'])->paginate(10);
        return view('admin.orders.ordersList', compact('orders'));
    }

    public function viewOrder($id)
    {
        $order = Order::with(['client', 'professional', 'service.category'])->findOrFail($id);
        return view('admin.orders.viewOrder', compact('order'));
    }

    public function addOrder()
    {
        $services = Service::all();
        return view('admin.orders.addOrder', compact('services'));
    }

    public function storeOrder(Request $request)
    {
        $order = Order::create($request->all());
        return redirect()->route('ordersList')->with('success', 'Commande créée avec succès');  
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return redirect()->route('ordersList')->with('success', 'Commande mise à jour avec succès');
    }

    public function deleteOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('ordersList')->with('success', 'Commande supprimée avec succès');
    }
    
}
