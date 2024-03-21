<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Regiones;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function stream()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        header('X-Accel-Buffering: no');
        header('Access-Control-Allow-Origin: http://localhost:4200');
    
        $lastState = DB::table('regiones')->get();
    
        while (true) {
            $currentState = DB::table('regiones')->get();
    
            if ($currentState != $lastState) {
                echo "data: " . json_encode(true) . "\n\n";
                ob_flush();
                flush();
                $lastState = $currentState;
            } else {
                echo "data: " . json_encode(false) . "\n\n";
                ob_flush();
                flush();
            }
    
            sleep(5);
        }
    }
}
