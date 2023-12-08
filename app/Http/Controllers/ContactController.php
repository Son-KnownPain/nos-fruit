<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function send(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);
        $dataSubmit = $request->all();

        Contact::create([
            'contact_name' => $dataSubmit['name'],
            'email' => $dataSubmit['email'],
            'message' => $dataSubmit['message'],
        ]);

        $request->session()->flash('submit', 'Thông tin liên hệ và lời nhắn của bạn đã được gửi đi!');

        return redirect()->back();
    }

    public function contacts(Request $request) {
        $contacts;

        if ($request->query()['search'] ?? false) {
            $contacts = Contact::where('contact_name', 'LIKE', '%'.$request->query()['search'].'%')->get();
        } else {
            $contacts = Contact::all();
        }

        return view('admin.contacts.index', [
            'title' => 'Quản lí các liên hệ',
            'contacts' => $contacts,
        ]);
    }
}
