<?php

namespace App\Models;

use App\Fonction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CourseTemps extends Model
{
    use HasFactory;
    protected $table = 'course_temps';
    protected $primaryKey = 'id_course_temps';
    protected $fillable = [
        'fk_etape',
        'fk_coureur',
        'debut',
        'fin',
        'duree',
        'penalite',
        'duree_total'
    ];

    public $timestamps = false;
    public function updateDebut($debut, $fk_etape)
    {
        return self::where('fk_etape', $fk_etape)->update(['debut' => $debut]);
    }

    function update_date_fin($fin,$id_coureur,$id_etape,$difference){
        $valiny = self::where('fk_coureur', $id_coureur)
        ->where('fk_etape', $id_etape)
        ->first();
        if ($valiny) {
            $valiny->fin = $fin;
            $valiny->duree = $difference;
            $valiny->save();
        }

        return $valiny->getKey();
    }

    
    public function update_fin($tab_fin, $tab_id_coureur, $id_etape)
    {
        // $tab_fin = Fonction::convertStringArrayToTime($tab_fin);
        // dd($tab_fin);
        try {
            DB::beginTransaction();
            $conteur = 0;
            for ($i = 0; $i < count($tab_fin); $i++) { 
                if ($tab_fin[$i] != null) {
                    $temp = self::where('fk_coureur', $tab_id_coureur[$i])
                                ->where('fk_etape', $id_etape)
                                ->first();
                    
                    $date = Fonction::convertDate($tab_fin[$i]);
                    $sql = "
                        update course_temps set fin = '".$date."'::timestamp ,
                        duree = ('".$date."'::timestamp - '$temp->debut'::timestamp),
                        duree_total = ('".$date."'::timestamp - '$temp->debut'::timestamp)
                        where id_course_temps = ".$temp->id_course_temps."
                    ";
                    DB::statement($sql);
                    DB::commit();
                    $conteur = $conteur + 1;
                }
            }
            DB::commit();
            return $conteur;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    
    // public function update_fin($fin, $fk_coureur)
    // {   
    //     $fin = Carbon::createFromFormat('H:i:s',$fin);
    //     DB::beginTransaction();

    //     try {
    //         $valiny = self::where('fk_coureur', $fk_coureur)->first();
    //         if($valiny){
    //             $debut = Carbon::parse($valiny -> debut) ;
    //             $date_debut = $debut->toDateString();
    //             $time_debut = $debut->toTimeString();
    //             $time_debut = Carbon::createFromFormat('H:i:s',$time_debut);
                
    //             $difference = $time_debut ->diff($fin);
    //             $valiny->fin = Carbon::parse($date_debut)->setTimeFrom($fin);
    //             $valiny->duree = $difference;
    //             $classement = new Classement();
    //             $classement -> fk_etape = $valiny ->fk_etape;
    //             $classement -> fk_coureur = $valiny ->fk_coureur;
    //             $classement -> temps = $difference;
    //             $classement -> save();
    //             $valiny->save();
    //         }
    //         DB::commit();
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         throw $th;
    //     }

    //     return $valiny;
    // }

}
