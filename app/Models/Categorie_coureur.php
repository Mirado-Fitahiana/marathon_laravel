<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Categorie_coureur extends Model
{
    use HasFactory;
    protected $table = 'categorie_coureur';
    protected $primaryKey = 'id_categorie_coureur';

    public $timestamps = false;

    public static function set_genre(){
        $coureur = Coureur::all();

        $homme = 'M';
        $femme = 'F';
        try {
            DB::beginTransaction();
            foreach ($coureur as $item) {
                if ($item -> genre === $homme) {
                    $categorie_coureur = new Categorie_coureur();
                    $categorie_coureur->fk_coureur = $item->id_coureur;
                    $categorie_coureur->fk_categorie = 5;
                    $categorie_coureur->save();
                }else if ($item -> genre === $femme) {
                    $categorie_coureur = new Categorie_coureur();
                    $categorie_coureur->fk_coureur = $item->id_coureur;
                    $categorie_coureur->fk_categorie = 6;
                    $categorie_coureur->save();
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public static function set_age(){
        $coureur = Coureur::all();
        try {
            DB::beginTransaction();
            foreach ($coureur as $item) {
                $date = new DateTime($item->date_naissance) ;
                $year = $date->format('Y');
                $currentYear = date('Y');
                $age = $currentYear - $year;
    
                if ($age < 18) {
                    $categorie_coureur = new Categorie_coureur();
                    $categorie_coureur->fk_coureur = $item->id_coureur;
                    $categorie_coureur->fk_categorie = 7;
                    $categorie_coureur->save();
                }else {
                    $categorie_coureur = new Categorie_coureur();
                    $categorie_coureur->fk_coureur = $item->id_coureur;
                    $categorie_coureur->fk_categorie = 8;
                    $categorie_coureur->save();
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public static function generate_categorie(){
        try {
            DB::select('delete from categorie_coureur');
            DB::commit();
            self::set_genre();
            self::set_age();
        } catch (\Throwable $th) {
            throw $th;
        }

    }
}
