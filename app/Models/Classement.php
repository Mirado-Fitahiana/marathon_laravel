<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classement extends Model
{
    use HasFactory;
    protected $table = 'classement';
    protected $primaryKey = 'id_classement';
    public $timestamps = false;
    protected $fillable = ['fk_course_temps', 'temps'];

    public static function store_classement($fk_course_temps,$temps){
        return self::create([
            'fk_course_temps' => $fk_course_temps,
            'temps' => $temps,
        ]);
    }

}
