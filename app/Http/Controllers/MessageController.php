<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Auth;
use App\Events\NewMessage;
class MessageController extends Controller
{

    public function getMessagesFor($id){

        $messages = Message::where('sender',Auth::id())
                                ->where('receiver',$id)
                                ->Orwhere('sender',$id)
                                ->where('receiver',Auth::id())
                                ->orderByDesc('created_at')->take(10)->get();
        return response()->json($messages);
    }

    public function sendMessage(Request $request){
        $message = Message::create([
            'sender' => Auth::user()->id,
            'receiver' => $request->receiver_id,
            'text' => $request->message
        ]);
        if($message){
            broadcast(new NewMessage($message));
            return response()->json($message);
        }
    }

    public function updateUnreadMessages(Request $request) {
        $update = Message::where('sender', $request->id_sender)->where('receiver', auth()->id())->update(['read' => true]);
        return response()->json($update);
    }
}
