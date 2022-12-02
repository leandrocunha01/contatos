<?php

namespace App\Http\Controllers;

use App\Models\Models\Address;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();
        return $user->contacts()->with('address')->orderBy('name')->get();
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:contacts',
            'cpf' => 'required:unique:contacts',
            'address.address' => 'required',
            'address.complement' => 'required',
            'address.district' => 'required',
            'address.city' => 'required|max:2',
            'address.state' => 'required',
            'address.cep' => 'required|max:9',
            'address.number' => 'required,'
        ]);

        $contact = $user->contacts()->create($request->all());
        $contact->address()->save(new Address($request->address));

        return $contact;

    }

    public function update(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'cpf' => 'required',
            'address.address' => 'required',
            'address.complement' => 'required',
            'address.district' => 'required',
            'address.state' => 'required',
            'address.cep' => 'required',
            'address.number' => 'required,'
        ]);

        $contact = $user->contacts()->with('address')->findOrFail($request->id);
        $contact->update($request->all());
        $contact->address()->update($request->address);
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
