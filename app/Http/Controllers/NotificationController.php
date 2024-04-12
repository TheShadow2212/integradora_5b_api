<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Habitacion;
use App\Models\User;

class NotificationController extends Controller
{
    public function create(Request $request)
    {
        $notification = new Notification();
        $notification->room_id = $request->room_id;
        $notification->type = $request->type;
        $notification->data = $request->data;
        $notification->emergency = 0;
        $notification->save();
        return response()->json(['msg' => 'Registrado correctamente', 'notification' => $notification], 200);
    }

    public function getHighNotifications(Request $request)
    {
        $usuario = $request->user();
        $notifications = Notification::where('type', 'alta')->where('emergency', 0)->get()->map(function ($notification) use ($usuario) {
            $room = Habitacion::find($notification->room_id);
            if ($room->usuario_id == $usuario->id) {
                return [
                    'id' => $notification->_id,
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
        $affectedRows = Notification::where('_id', $id)->update(['emergency' => 1]);
    
        return response()->json(['affected_rows' => $affectedRows]);
    }
}