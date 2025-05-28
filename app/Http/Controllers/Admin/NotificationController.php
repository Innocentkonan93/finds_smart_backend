<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
class NotificationController extends Controller
{
    public function notificationsList()
    {
        $notifications = DatabaseNotification::where('notifiable_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        

        return view('admin.notifications.notificationsList', compact('notifications'));
    }

    public function viewNotification($id)
    {
        $notification = DatabaseNotification::find($id);
        return view('admin.notifications.viewNotification', compact('notification'));
    }

    public function markAsRead($id)
    {
        $notification = DatabaseNotification::find($id);
        $notification->markAsRead();
        return redirect()->route('viewNotification', $id);
    }

    public function markAllAsRead()
    {
        $notifications = DatabaseNotification::where('notifiable_id', Auth::user()->id)->get();
        foreach ($notifications as $notification) {
            $notification->markAsRead();
        }
        return redirect()->route('notificationsList')->with('success', 'Toutes les notifications ont été marquées comme lues');
    }

    public function deleteNotification($id)
    {
        $notification = DatabaseNotification::find($id);
        $notification->delete();
        return redirect()->route('notificationsList')->with('success', 'Notification supprimée avec succès');
    }
}
