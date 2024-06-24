<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Penalite extends Model
{
    use HasFactory;
    protected $table = 'penalite';
    protected $primaryKey = 'id_penalite';
    public $timestamps = false;

    public static function insert_penalite($penalite,$fk_etape,$fk_equipe){
        $pen = new Penalite();
        $penalite = Carbon::parse($penalite);
        $penalite = $penalite->toTimeString();
        try {
            DB::beginTransaction();
            $pen->penalite = $penalite;
            $pen->fk_etape = $fk_etape;
            $pen->fk_equipe = $fk_equipe;
            if ($pen->save()) {
                $coureur = Coureur::where('fk_equipe',$fk_equipe)->get();
                // dd($coureur);
                foreach ($coureur as $item) {
                    $last_course_temps = CourseTemps::where('fk_etape', $fk_etape)
                                ->where('fk_coureur', $item->id_coureur)
                                ->first();
                    if ($last_course_temps != null) {
                        if ($last_course_temps->fin != null) {
                            $sql = "update course_temps set penalite = ('".$last_course_temps->penalite."'::interval + '".$penalite."'::interval),
                                    duree_total = ('".$last_course_temps->duree_total."'::interval + '".$penalite."'::interval )
                                    where fk_coureur = ".$item->id_coureur." and fk_etape = ".$fk_etape."
                                ";
                            DB::statement($sql);
                            Db::commit();
                        }
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public static function delete_penalite($id_penalite){
        $pen = Penalite::where('id_penalite',$id_penalite)->first();
        $coureur = Coureur::where('fk_equipe',$pen->fk_equipe)->get();
        try {
            DB::beginTransaction();
        foreach ($coureur as $item) {
            $last_course_temps = CourseTemps::where('fk_etape', $pen->fk_etape)->where('fk_coureur',$item->id_coureur)->first();
            if ($last_course_temps != null) {
                $sql = "update course_temps set penalite = ('".$last_course_temps->penalite."'::interval + '".$pen->penalite."'::interval),
                                duree_total = ('".$last_course_temps->duree_total."'::interval - '".$pen->penalite."'::interval )
                                where fk_coureur = ".$item->id_coureur." and fk_etape = ".$pen->fk_etape."
                            ";
                $pen->delete();
                DB::statement($sql);
                DB::commit();
            }
        }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

}
