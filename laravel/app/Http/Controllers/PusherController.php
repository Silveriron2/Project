<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SenderMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\NewUserMail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Events\PusherBroadcast;

class PusherController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'pusherKey' => env('PUSHER_APP_KEY'),
            'pusherCluster' => env('PUSHER_APP_CLUSTER')
        ]);
    }
    
    public function broadcast(Request $request)
    {
        broadcast(new PusherBroadcast($request->get('message')))->toOthers();

        return view('broadcast', ['message' => $request->get('message')]);
    }
    public function receive(Request $request)
    {
        return view('receive', ['message' => $request->get('message')]);
    }
}
