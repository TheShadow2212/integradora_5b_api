<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Habitacion;
use App\Models\User;
use App\Events\CriticalNoti;
use App\Events\alarma;

class NotificationController extends Controller
{
    public function create(Request $request)
    {
        $rooms = Habitacion::all();

        foreach ($rooms as $room) {
            $notification = new Notification();
            $notification->room_id = $room->id;
            $notification->type = $request->type;
            $notification->data = $request->data;
            $notification->emergency = 0;
            $notification->save();
        }
        $this->alarmaActiva();
        // event(new CriticalNoti('Gas en la habitacion', 'No hay'));

        return response()->json(['msg' => 'Registrado correctamente en todas las habitaciones'], 200);
    }

    public function alarmaActiva() {
        Habitacion::query()->update(['alarma' => true]);
        event(new alarma('No hay'));
        return response()->json(['msg' => 'Alarma activada en todas las habitaciones'], 200);
    }

    public function apagarAlarma() {
        Habitacion::query()->update(['alarma' => false]);
        return response()->json(['msg' => 'Alarma apagada en todas las habitaciones'], 200);
    }

    public function getHighNotifications(Request $request)
    {
        $usuario = $request->user();
        $notifications = Notification::where('type', 'alta')->where('emergency', 0)->get()->map(function ($notification) use ($usuario) {
            $room = Habitacion::find($notification->room_id);
            if ($room && $room->usuario_id == $usuario->id) {
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
    
        $room = Habitacion::find($id);
        if ($room === null) {
            return response()->json(['error' => 'Habitación no encontrada'], 404);
        }
    
        if ($room->usuario_id != $usuario->id) {
            return response()->json(['error' => 'Habitación no accesible'], 403);
        }
    
        $notifications = Notification::where('room_id', $id)->get()->map(function ($notification) {
            return [
                'type' => $notification->type,
                'data' => $notification->data,
            ];
        });
    
        return response()->json($notifications);
    }
    public function update($id)
    {    
        $affectedRows = Notification::where('_id', $id)->update(['emergency' => 1]);
    
        return response()->json(['affected_rows' => $affectedRows]);
    }
}
