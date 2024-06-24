<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SDamian\Larasort\AutoSortable;

class V_classement_rang extends Model
{
    use HasFactory;
    use AutoSortable;
    protected $table = 'v_classement_rang';
    protected $primaryKey = 'id_course_temps';

    private array $sortables = [
        'id_course_temps',
        'id_coureur',
        'nom_coureur',
        'numero_dossard',
        'date_naissance',
        'genre',
        'id_etape',
        'nom_etape',
        'nombre_coureur',
        'debut',
        'fin',
        'duree',
        'id_utilisateur',
        'nom_equipe',
        'penalite',
        'duree_total',
        'rang',
        'points'
    ];
    


    
}
