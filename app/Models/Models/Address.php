<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';

    protected $fillable = ['address','city', 'complement', 'district', 'state', 'cep', 'number','lat','lng'];

    public function contact(){
        return $this->belongsTo(Contact::class);
    }
}
