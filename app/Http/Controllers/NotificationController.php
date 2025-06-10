<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
class NotificationController extends Controller
{
    // Afficher toutes les notifications d'un utilisateur
    public function index(Request $request)
    {
        $notifications = DatabaseNotification::where('notifiable_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    // Créer une notification
    public function store(StoreNotificationRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['sent_at'] = now();
        $notification = Notification::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification created successfully',
            'notification' => $notification
        ], 201);
    }

    // Marquer une notification comme lue
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {

        $notification->update(['is_read' => $request->is_read]);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification updated successfully',
            'notification' => $notification
        ], 200);
    }

    // Supprimer une notification
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Notification deleted successfully',
            'notification' => $notification
        ], 200);
    }
}