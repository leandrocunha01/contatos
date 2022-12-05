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
            'cpf' => 'required|unique:contacts',
            'address.address' => 'required',
            'address.district' => 'required',
            'address.city' => 'required',
            'address.state' => 'required|max:2',
            'address.cep' => 'required|max:9',
            'address.number' => 'required'
        ]);
        $data = $request->only(['name', 'phone', 'email', 'cpf', 'address.address','address.city',
            'address.complement', 'address.district', 'address.state', 'address.cep', 'address.number']);

        $contact = $user->contacts()->create($data);
        $contact->address()->save(new Address($data['address']));

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
            'address.district' => 'required',
            'address.state' => 'required',
            'address.cep' => 'required',
            'address.number' => 'required'
        ]);


        $data = $request->only(['name', 'phone', 'email', 'cpf', 'address.address',
            'address.complement', 'address.district', 'address.state', 'address.cep', 'address.number']);

        $contact = $user->contacts()->with('address')->findOrFail($request->id);
        $contact->update($data);
        $contact->address()->update($data['address']);
        return $contact->refresh();
    }

    public function view(Request $request)
    {
        $user = $request->user();
        $contact = $user->contacts()->findOrFail($request->id);
        $contact->update($request->all());
        return $contact;
    }
}
