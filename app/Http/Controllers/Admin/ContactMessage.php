<?php

namespace App\Http\Controllers\Admin;

use App\Model\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactMessage extends Controller
{
    public function index(Request $request){
        $messages = ContactUs::query()->search($request)->latest()->paginate(10);
        // dd($messages->toArray());
        return view('admin.contact_message.list', compact('messages'));
    }

    public function show($id){
        $message = ContactUs::find($id);
        // return $messages;
        return view('admin.contact_message.show', compact('message'));

    }
}
