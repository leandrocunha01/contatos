<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        return Contact::with('address')->get();
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:contacts',
            'cpf' => 'required:unique:contacts'
        ];
        $validator = $this->validator($request, $rules);
        if ($validator->fails()) {
            $response = ['success' => false];
            $response['response'] = $validator->messages();
            return $response;
        } else {
            return Contact::create($request->all());;
        }
    }

    public function update(Request $request){
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'cpf' => 'required'
        ];
        $validator = $this->validator($request, $rules);

        $response = ['success' => false];
        if ($validator->fails()) {
            $response['response'] = $validator->messages();
            return $response;
        }

        $contact = Contact::find($request->id);
        if(!$contact){
            return ['success' => false, 'response' =>  'Contato não encontrado'];
        }else{
            $contact->update($request->all());
        }
        return $contact;
    }

    public function view(Request $request){
        $contact = Contact::find($request->id);
        if(!$contact){
            return ['success' => false, 'response' =>  'Contato não encontrado'];
        }else{
            $contact->update($request->all());
        }
        return $contact;
    }

    public function validator(Request $request, $rules){
        $response = array('response' => '', 'success' => false);

        $validator = Validator::make($request->all(), $rules);

        return $validator;
    }
}
