<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_categorie_coureur_lib extends Model
{
    use HasFactory;
    protected $table = 'v_categorie_coureur_lib';
    protected $primaryKey = 'id_categorie_coureur';
    
}
