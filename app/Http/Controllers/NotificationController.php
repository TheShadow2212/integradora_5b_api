<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Events\RegionUpdated;
use Illuminate\Support\Facades\Cache;

class NotificationController extends Controller
{
    public function stream(Request $request)
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        header('X-Accel-Buffering: no');
        header('Access-Control-Allow-Origin: http://192.168.100.84:8000');
        header('Access-Control-Allow-Origin: http://192.168.123.104:8000');
        header('Access-Control-Allow-Origin: http://192.168.100.84:4200');
        header('Access-Control-Allow-Origin: http://192.168.123.104:4200');


        if(Cache::has('RegionUpdated')) {

            echo "data: " . json_encode(true) . "\n\n";
            ob_flush();
            flush();

        }else{
            echo "" . "\n\n";
            ob_flush();
            flush();
        }

        sleep(1);
    }
}
