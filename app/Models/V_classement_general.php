<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_classement_general extends Model
{
    use HasFactory;
    protected $table = 'v_classement_general';
    protected $primaryKey = 'numero_dossard';
    
}
