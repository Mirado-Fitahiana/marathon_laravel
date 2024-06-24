<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_classement_coureur_par_equipe extends Model
{
    use HasFactory;
    protected $table='v_classement_coureur_par_equipe';
    protected $primaryKey = 'numero_dossard';
}
