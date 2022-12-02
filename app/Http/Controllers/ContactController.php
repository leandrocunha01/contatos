<?php

namespace App\Http\Controllers;

use App\Models\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();
        return $user->contacts()->with('address')->get();
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:contacts',
            'cpf' => 'required:unique:contacts'
        ]);

        return $user->contacts()->create($request->all());

    }

    public function update(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'cpf' => 'required'
        ]);

        $contact = $user->contact()->with('address')->findOrFail($request->id);
        $contact->update($request->all());

        return $contact;
    }

    public function view(Request $request)
    {
        $user = $request->user();
        $contact = $user->contacts()->findOrFail($request->id);
        $contact->update($request->all());
        return $contact;
    }
}
