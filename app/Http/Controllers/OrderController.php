<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Notifications\OrderPlacedNotification;
use App\Notifications\OrderAcceptedNotification;
use App\Notifications\OrderCompletedNotification;
use App\Models\User;
class OrderController extends Controller
{
    /**
     * Liste toutes les commandes.
     */
    public function index(): JsonResponse
    {
        $orders = Order::with(['service', 'client.orders.service.category', 'professional'])->get();

        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ], 200);
    }

    /**
     * Stocke une nouvelle commande.
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = Order::create($request->validated());

        $client = $request->user();
        $client->notify(new OrderPlacedNotification($order));

        return response()->json([
            'status' => 'success',
            'message' => 'Commande créée avec succès',
            'order' => $order->load(['service', 'client.orders.service.category', 'professional'])
        ], 201);
    }

    /**
     * Affiche une commande spécifique.
     */
    public function show(Order $order): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'order' => $order->load(['service', 'client.orders.service.category', 'professional'])
        ], 200);
    }

    /**
     * Met à jour une commande existante.
     */
    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $order->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Commande mise à jour avec succès',
            'order' => $order->load(['service', 'client.orders.service.category', 'professional'])
        ], 200);
    }

    /**
     * Supprime une commande.
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Commande supprimée avec succès'
        ], 200);
    }
    /**
     * Liste les commandes passées par un client.
     */
    public function getClientOrders($id): JsonResponse
    {
        $orders = Order::where('client_id', $id)
            ->with(['service.category', 'professional'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ], 200);
    }

    /**
     * Liste les commandes reçues par un professionnel.
     */
    public function getProfessionalOrders($id): JsonResponse
    {
        $orders = Order::where('professional_id', $id)
            ->with(['service.category', 'client'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ], 200);
    }

    public function getAcceptedOrders(string $professional_id): JsonResponse
    {
        $orders = Order::where('status', 'accepted')->where('professional_id', $professional_id)->with(['service.category', 'client.orders.service.category', 'professional'])->get();
     

        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ], 200);
    }



    public function pendingOrders(): JsonResponse
    {
        $orders = Order::where('status', 'pending')->with(['service.category', 'client.orders.service.category', 'professional'])->get();

        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ], 200);
    }


    public function completedOrders(): JsonResponse
    {
        $orders = Order::where('status', 'completed')->with(['service.category', 'client.orders.service.category', 'professional'])->get();
        $professional = User::find($orders->professional_id);
        $professional->notify(new OrderCompletedNotification($orders));
        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ], 200);
    }


    public function acceptOrder(Request $request): JsonResponse
    {
        $order = Order::find($request->order_id);
        $order->status = 'accepted';
        $order->professional_id = $request->professional_id;
        $order->save();
        $client = User::find($order->client_id);
        $client->notify(new OrderAcceptedNotification($order));
        return response()->json([
            'status' => 'success',
            'message' => 'Commande acceptée avec succès',
            'order' => $order
        ], 200);
    }


    public function completeOrder(Request $request): JsonResponse
    {
        $order = Order::find($request->order_id);
        $order->status = 'completed';
        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Commande terminée avec succès',
            'order' => $order
        ], 200);
    }
}
