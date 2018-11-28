<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use Auth;


class ContactController extends Controller
{

    public function get(){
        // $contacts = User::where('id', '!=', Auth::user()->id)->get();
        // $contacts = $contacts->map(function($contact) {
        //     $message = Message::select('sender')->where('receiver',Auth::id())->where('sender',$contact->id)->where('read',0)->groupBy('sender')->get();
        //     return $contact->setAttribute('count',$message->count());
        // });
        // $contacts = $contacts->sortByDesc('count')->values()->all();
        // $contacts = $contacts->values()->all();
        // return response()->json($contacts);


        // get all users except the authenticated one
        $contacts = User::where('id', '!=', auth()->id())->get();
        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $unreadIds = Message::select(\DB::raw('`sender` as sender_id, count(`sender`) as messages_count'))
            ->where('receiver', auth()->id())
            ->where('read', false)
            ->groupBy('sender')
            ->get();
        // add an unread key to each contact with the count of unread messages
        $contacts = $contacts->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });
        return response()->json($contacts);
    }

    public function getMessagesFor($id){
        $messages = Message::where('receiver',$id)->orWhere('sender',$id)->get();

        return response()->json($messages);
    }
}
