<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    use HasFactory;
    
    protected $table = 'etape';
    protected $primaryKey = 'id_etape';
    public $timestamps = false;
    
}
