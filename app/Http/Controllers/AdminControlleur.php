<?php

namespace App\Http\Controllers;

use App\Models\CourseTemps;
use App\Models\Penalite;
use App\Models\V_classement_coureur_par_equipe;
use App\Models\V_etape_coureur_lib;
use Illuminate\Http\Request;
use Carbon\Carbon;
class AdminControlleur extends Controller
{
    //

    public function update_debut(Request $request){
        // Valider que la date reçue est bien au format HTML5 datetime-local
        $request->validate([
            'debut' => 'required|date_format:Y-m-d\TH:i',
        ]);

        // Convertir la date au format requis
        $debut = Carbon::createFromFormat('Y-m-d\TH:i', $request->debut)->format('d-m-Y H:i:s');
        
        // Récupérer l'id_etape
        $id_etape = $request->id_etape;

        // Mettre à jour la date de début
        $course = new CourseTemps();
        $success = $course->updateDebut($debut, $id_etape);

        // Retourner une réponse appropriée
        if ($success) {
            return back()->with('success', 'L\'heure de début a été mise à jour avec succès.');
        } else {
            return back()->with('error', 'Impossible de mettre à jour l\'heure de début.');
        }
    }
    public function affectation_temps($id){
        // jerena dool ze joueur miazakazaka ao
        $lib_vue = V_etape_coureur_lib::select('*')->where('id_etape',$id)->get();
        
        $data = [
            'vue' => $lib_vue,
            'id' => $id
        ];
        return view('admin.affectation_temps_unique',$data);
    }

    
    public function edit_fin(Request $request){
        // dd($request);
        $fin = $request->fin;
        $tab_fk_coureur = $request->fk_coureur;
        $id_etape = $request->id_etape;

        try {
            $course = new CourseTemps();
            $row = $course->update_fin($fin,$tab_fk_coureur,$id_etape);
            if ($row) {
                return back()->with('success','Joueur enregistre :'.$row);
            }
        } catch (\Throwable $th) {
            throw $th;
            // return back()->with('erorr',$th);
        }
        return back()->with('success','aucun joueur affecter');
        
    }

    public function store_penalite(Request $request){
        $penalite = $request->penalite;
        $id_etape = $request->id_etape;
        $id_equipe = $request->id_equipe;
        // dd($request);
        Penalite::insert_penalite($penalite,$id_etape,$id_equipe);
        return back();
    }

    public function delete_penalite(Request $request){
        $id_penalite = $request->id_penalite;
        Penalite::delete_penalite($id_penalite);
        return back()->with('success','Pénalité effacer');
    }
    
    public function alea2($id) {
        $data_go = V_classement_coureur_par_equipe::where('id_utilisateur',$id)->get();
        $data = [
            'liste'=>$data_go,
        ];
        return view('admin.classement_detail',$data);
    }
    

    // public function edit_fin(Request $request) {
    //     $fin = $request->fin;
    //     $id_coureur = $request->id_coureur;
        
    //     $course = new CourseTemps();

    //     $course->update_fin($fin,$id_coureur);
    //     redirect('/liste_etape_admin');
    // }
        
        // $fin = Carbon::createFromFormat('Y-m-d\TH:i', $request->fin)->format('d-m-Y H:i:s');
        // $id_coureur = $request-> id_coureur;

        // $valiny = new CourseTemps();
        // $valiny->update_fin($fin,$id_coureur);
}
