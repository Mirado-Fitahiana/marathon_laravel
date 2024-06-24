<?php

namespace App\Http\Controllers;

use App\Models\Coureur;
use App\Models\CourseTemps;
use App\Models\Etape;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class ToolControlleur extends Controller
{

    public function clear(){
        DB::beginTransaction();
        try {
            DB::select('delete from etape_temporaire');
            DB::select('delete from resultat_temporaire');
            DB::select('delete from point_temporaire');
            DB::select('delete from point');
            DB::select('delete from classement');
            DB::select('delete from categorie_coureur');
            DB::select('delete from course_temps');
            DB::select('delete from penalite');
            DB::select('delete from coureur');
            DB::select('delete from utilisateur where is_admin != 5');
            DB::select('delete from etape');
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return view('page.index');
    }

    public function csv_to_array($file) {
        if (!file_exists($file)) {
            throw new \Exception("File not found: ".$file);
        }
        $contents = file_get_contents($file);
        $lines = explode(PHP_EOL, $contents);
        $csvData = [];

        for ($i=1; $i <count($lines) ; $i++) { 
            $line = $lines[$i];
            if ($line == '') {
                continue;
            }
            $values = str_getcsv($line); 
            $csvData[] = $values;
        }
        // dd($csvData);
        return $csvData;
    }

    public  function processCSV_etape($file)
    {
        $csvData = $this->csv_to_array($file);
        $data = [];
        $data['data'] = $csvData;
        for ($i = 1 ; $i<count($csvData);$i++ ) {
            $row = $csvData[$i];

            $validator = Validator::make(
                [
                    'etape' => $row[0],
                    'longueur' => $row[1],
                    'nb_coureur'=> $row[2],
                    'rang'=> $row[3],  
                    'date_depart' => $row[4],
                    'heure_depart'=> $row[5],
                ]
                , [
                'etape' => 'required|string',
                'longueur' => 'required|string',
                'nb_coureur'=> 'required|string',
                'rang'=> 'required|string',
                'date_depart'=> 'required|string',
                'heure_depart'=>'required|string',
            ], [
                'etape.required' => 'Le champ etape est requis. Numéro de ligne : '.($i+1),
                'longueur.required' => 'Le champ longueur est requis. Numéro de ligne : '.($i+1),
                'nb_coureur.required' => 'Le champ nb_coureur est requis. Numéro de ligne : '.($i+1),
                'rang.required' => 'Le champ rang des travaux est requis. Numéro de ligne : '.($i+1),
                'date_depart.required' => 'Le champ date est requis. Numéro de ligne : '.($i+1),
                'heure_depart.required' => 'Le champ heure depart est requis. Numéro de ligne : '.($i+1),
            ]);
            
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $data['error'][] = $errors;
                continue;
            }else {
                
            }
        }
       return $data; 
    }
    public  function processCSV_resultat($file)
    {
        $csvData = $this->csv_to_array($file);
        $data = [];
        $data['data'] = $csvData;
        // dd($data);
        for ($i = 1 ; $i<count($csvData);$i++ ) {
            $row = $csvData[$i];

            $validator = Validator::make(
                [
                    'etape_rang' => $row[0],
                    'numero_dossard' => $row[1],
                    'nom'=> $row[2],
                    'genre'=> $row[3],  
                    'date_naissance' => $row[4],
                    'equipe'=> $row[5],
                    'arrivee'=>$row[6]
                ]
                , [
                'etape_rang' => 'required|string',
                'numero_dossard' => 'required|string',
                'nom'=> 'required|string',
                'genre'=> 'required|string',
                'date_naissance'=> 'required|string',
                'equipe'=>'required|string',
                'arrivee' => 'required|string'
            ], [
                'etape_rang.required' => 'Le champ etape_rang est requis. Numéro de ligne : '.($i+1),
                'numero_dossard.required' => 'Le champ Numero_dossard est requis. Numéro de ligne : '.($i+1),
                'nom.required' => 'Le champ nom est requis. Numéro de ligne : '.($i+1),
                'genre.required' => 'Le champ genre des travaux est requis. Numéro de ligne : '.($i+1),
                'date_naissance.required' => 'Le champ date_naissance est requis. Numéro de ligne : '.($i+1),
                'equipe.required' => 'Le champ equipe depart est requis. Numéro de ligne : '.($i+1),
                'arrivee.required' => 'Le champ arrivee depart est requis. Numéro de ligne : '.($i+1),
            ]);
            
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $data['error'][] = $errors;
                continue;
            }else {
                
            }
        }
       return $data; 
    }
    
    public function insert_table_temporaire_resultat(Request $request){
        if ($request->hasFile('file_resultat')) {
            
            $file = $request->file('file_resultat');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $filePath = public_path('uploads') . '/' . $fileName;

            $data = $this->processCSV_resultat($filePath);
            if (isset($data['error'])) {
                dd($data['error']);
                return back()->with('error', $data['error'])->withInput();
            } else{
                for ($i = 0 ; $i<count($data['data']);$i++ ) {
                    $row = $data['data'][$i];
                    $row1 = explode(" %", $row[1])[0];
                    $row1 = str_replace(',', '.', $row1);
                    DB::table('resultat_temporaire')
                    ->insert(
                        [
                            'etape_rang' => $row[0],
                            'numero_dossard' => $row1,
                            'nom' => $row[2],
                            'genre' => $row[3],
                            'date_naissance' => $row[4],
                            'equipe' => $row[5],
                            'arrivee'=>$row[6]
                        ]
                        );
                        DB::commit();
                }
                return back()->with('success', 'upload success')->withInput();
            }
        }
    }
    public function insert_table_temporaire_etape(Request $request){
        // $request->validate([
        //     'file'=>'required|mimes:csv',
        // ]);
        if ($request->hasFile('file_etape')) {
            
            $file = $request->file('file_etape');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $filePath = public_path('uploads') . '/' . $fileName;

            $data = $this->processCSV_etape($filePath);
            if (isset($data['error'])) {
                dd($data['error']);
                return back()->with('error', $data['error'])->withInput();
            } else{
                for ($i = 0 ; $i<count($data['data']);$i++ ) {
                    $row = $data['data'][$i];
                    $row1 = explode(" %", $row[1])[0];
                    $row1 = str_replace(',', '.', $row1);
                    DB::table('etape_temporaire')
                    ->insert(
                        [
                            'etape' => $row[0],
                            'longueur' => $row1,
                            'nb_coureur' => $row[2],
                            'rang' => $row[3],
                            'date_depart' => $row[4],
                            // 'date_depart'=>,
                            'heure_depart' => $row[5],
                        ]
                        );
                        DB::commit();
                }
                return back()->with('success', 'upload success')->withInput();
            }
        }
        // dd('no file');
    }


    public function import_csv_etape_resultat(Request $request){
        try {
            DB::beginTransaction();
            $this->insert_table_temporaire_etape($request);
            $this->insert_table_temporaire_resultat($request);
            $this->insert_equipe();
            $this->insert_coureur();
            $this->insert_etape();
            $this->insert_course_etape();
            
            DB::commit();
            return back()->with('success','succes import');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            // return back()->with('success','succes import');
        }
 
    }
   


    public function insert_equipe(){
        $sql = "insert into utilisateur (nom,mail,password)
                SELECT equipe, equipe,equipe as password
                FROM resultat_temporaire
                GROUP BY equipe";
        DB::insert($sql);
    }
 
    public function insert_coureur(){
        $sql = 'select resultat_temporaire.nom,numero_dossard,genre,date_naissance,utilisateur.id_utilisateur from resultat_temporaire
        join utilisateur on utilisateur.nom = resultat_temporaire.equipe   
        group by resultat_temporaire.nom,resultat_temporaire.numero_dossard,resultat_temporaire.date_naissance,utilisateur.id_utilisateur,genre
        ';

       $data = DB::select($sql);
            foreach ($data as $item) {
                $coureur = new Coureur();
                $coureur->nom_coureur = $item->nom;
                $coureur->numero_dossard = $item->numero_dossard;
                $coureur->genre = $item->genre;
                // $date = Carbon::createFromFormat('d/m/Y', $item->date_naissance,)->format('Y-m-d');
                $coureur->date_naissance = $item->date_naissance;
                $coureur->fk_equipe = $item->id_utilisateur;
                $coureur->save();
            }
    }

    public function insert_etape(){
        $sql = 'select etape,nb_coureur,longueur,rang,date_depart,heure_depart from etape_temporaire';
        $data = DB::select($sql);
        foreach ($data as $item) {
            $etape = new Etape();
            $etape->nom_etape = $item->etape;
            $etape->nombre_coureur = $item->nb_coureur;
            $etape->longueur = $item->longueur;
            $etape->rang_etape = $item->rang;
            $etape->nom_etape = $item->etape;
            $date1 =$item->date_depart;
            $time = $item->heure_depart;
            $etape->date_debut = $date1;
            $etape->heure_debut = $time;
            $etape->debut = $date1.' '.$time;
            $etape->save();
        }
    }

    public function insert_course_etape(){
        $sql = 'select id_etape ,id_coureur, etape.debut, resultat_temporaire.arrivee from resultat_temporaire
        join etape on etape.rang_etape = resultat_temporaire.etape_rang
        join coureur on coureur.nom_coureur = resultat_temporaire.nom
        group by id_etape,id_coureur,etape.debut,resultat_temporaire.arrivee
        ';

        $data = DB::select($sql);
        foreach($data as $item){
            $course = new CourseTemps();
            $course->fk_etape = $item->id_etape;
            $course->fk_coureur = $item->id_coureur;
            $debut = Carbon::parse($item->debut);
            $fin =  Carbon::createFromFormat('d/m/Y H:i:s', $item->arrivee);
            $course->debut = $debut;
            $course->fin = $item->arrivee;
            $course->duree = $debut->diff($fin);
            $course->duree_total = $debut->diff($fin);
            $course->save();
        }
    }

}
