<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_classement_categorie_sans_rang extends Model
{
    use HasFactory;
    protected $table = 'v_classement_categorie_sans_rang';
    protected $primaryKey='id_coureur';
}
