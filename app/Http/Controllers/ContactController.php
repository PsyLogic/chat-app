<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use Auth;


class ContactController extends Controller
{

    public function get(){
        // get all users except the authenticated one
        $contacts = User::where('id', '!=', auth()->id())->get();
        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $unreadIds = Message::select(\DB::raw('`sender` as sender_id, count(`sender`) as messages_count'))
            ->where('receiver', auth()->id())
            ->where('read', false)
            ->groupBy('sender')
            ->get();
        //return $unreadIds;
        // add an unread key to each contact with the count of unread messages
        $contacts = $contacts->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });
        return response()->json($contacts);
    }
}
