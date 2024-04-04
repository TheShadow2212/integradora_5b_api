<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Habitacion;
use App\Models\User;

class NotificationController extends Controller
{

    public function getHighNotifications(Request $request)
    {
        $usuario = $request->user();
        $notifications = Notification::where('type', 'alta')->where('emergency', 0)->get()->map(function ($notification) use ($usuario) {
            $room = Habitacion::find($notification->room_id);
            if ($room->usuario_id == $usuario->id) {
                return [
                    'id' => $notification->id,
                    'room' => $room->nombre,
                    'data' => $notification->data,
                ];
            }
        });
    
        $notifications = $notifications->filter()->values();
    
        if ($notifications->isEmpty()) {
            return response()->json([]);
        }
    
        return response()->json($notifications);
    }
    
    
    
             
    public function getNotificationsByRoomId(Request $request, $id)
    {
        $id = (int)$id;
        $usuario = $request->user();
        
        $notifications = Notification::where('room_id', $id)->get()->map(function ($notification) use ($usuario) {
            $room = Habitacion::find($notification->room_id);
            if ($room->usuario_id == $usuario->id) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'data' => $notification->data,
                ];
            }
        });

        $notifications = $notifications->filter()->values();

        if ($notifications->isEmpty()) {
            return response()->json([]);
        }

        return response()->json($notifications);
    }

    public function update($id)
    {
        $id = (int)$id;
    
        $affectedRows = Notification::where('id', $id)->update(['emergency' => 1]);
    
        return response()->json(['affected_rows' => $affectedRows]);
    }
}
