<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coureur extends Model
{
    use HasFactory;
    protected $table = 'coureur';
    protected $primaryKey = 'id_coureur';
    public $timestamps = false;
}
