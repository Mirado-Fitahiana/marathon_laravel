<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_classement_equipe extends Model
{
    use HasFactory;
    protected $table = 'v_classement_equipe';
    protected $primaryKey  = 'id_utilisateur';
    
}
