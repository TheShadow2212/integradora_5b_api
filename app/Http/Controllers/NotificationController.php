<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Habitacion;

class NotificationController extends Controller
{

    public function getHighNotifications()
    {
        $notifications = Notification::where('type', 'alta')->where('emergency', 0)->get()->map(function ($notification) {
            $room = Habitacion::find($notification->room_id);
            return [
                'id' => $notification->id,
                'room' => $room->nombre,
                'data' => $notification->data,
            ];
        });
        return response()->json($notifications);
    }
             
    public function getNotificationsByRoomId($id)
    {
        $id = (int)$id;

        $notifications = Notification::where('room_id', $id)->get()->map(function ($notification) {
            return [
                'id' => $notification->id,
                'type' => $notification->type,
                'data' => $notification->data,
            ];
        });
        return response()->json($notifications);
    }

    public function update($id)
    {
        $id = (int)$id;
    
        $affectedRows = Notification::where('id', $id)->update(['emergency' => 1]);
    
        return response()->json(['affected_rows' => $affectedRows]);
    }
}
