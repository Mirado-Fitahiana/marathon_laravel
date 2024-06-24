<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Categorie_coureur;
use App\Models\Coureur;
use App\Models\CourseTemps;
use App\Models\Etape;
use App\Models\Utilisateur;
use App\Models\V_classement_categorie_sans_rang;
use App\Models\V_classement_general;
use App\Models\V_classement_rang;
use App\Models\V_classement_equipe;

use App\Models\V_etape_coureur_lib;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use DB;

class InitControlleur extends Controller
{
    //
    public function verify_login(Request $request){
        
        // dd($request);
        // dd(session('utilisateur'));
        $request->validate([
            'mail' => 'required|string|max:255',
        ]);

        $emp = new Utilisateur();

        if ($emp -> verify_pass($request->mail,$request->pass) == true) {
            if (session('utilisateur')) {
                return $this->get_liste_coureur();
            }elseif ((session('admin'))) {
                return $this->get_classement_equipe($request);
            }
        }else {
            return back()->with('success', 'Verifiez vos identifiants')->withInput();
        }

    }
    public function affectation_joueur($id){
        // dd($id);
        $liste_joueur = Coureur::where('fk_equipe', session('utilisateur')->id_utilisateur)->get();
        $etape = Etape::where('id_etape', $id)->first();
        // $nombre_par_etape = $etape->nombre_coureur;
        // $nombre_deja_inscrit = V_etape_coureur_lib::where('id_etape', $etape->id_etape)
        // ->where('fk_equipe', session('utilisateur')->id_utilisateur)
        // ->count();
        // if ($nombre_par_etape <= $nombre_deja_inscrit) {
        //     return back()->with('error','Vous avez atteint vos limites');
        // }
        
        // dd($nombre_deja_inscrit);
        // dd($etape);
        $data = [
            'etape' => $etape,
            'coureur' => $liste_joueur
        ];
        // dd($data);

        return view('equipe.affectation',$data);
        // dd($liste_joueur);
    }
    public function store_affectation(Request $request){
        $id_etape = $request->etape;
        $coureursSelectionnes = $request->input('coureur');
        $etape = Etape::where('id_etape', $id_etape)->first();
        $nombre_inscrit = count($coureursSelectionnes);

        $nombre_deja_inscrit = V_etape_coureur_lib::where('id_etape', $id_etape)
        ->where('fk_equipe', session('utilisateur')->id_utilisateur)
        ->count();
        // dd(count(($n)));
        $reste = $etape->nombre_coureur; - $nombre_deja_inscrit;
        if($etape->nombre_coureur < count($coureursSelectionnes)){
            return back()->with('success', 'Le nombre de courreur maximum est '.$etape->nombre_coureur)->withInput();
        }
        
        if ($reste < $nombre_inscrit) {
            return back()->with('success',"vous n'avez que ".$reste." place disponible alors que vous tentez d'entrer ".$nombre_inscrit);
        }else{
            for ($i=0; $i < count($coureursSelectionnes); $i++) { 
                $verify=CourseTemps::where('fk_etape',$id_etape)->where('fk_coureur',$coureursSelectionnes[$i])->first();
            }
            if ($verify!=null) {
                // dd($verify);
                return back()->with('error','Il y a des joueurs qui se repete pour cette etape'.$verify->fk_coureur);
            }
            
        }
    

        $verify = null;


        $j = 0;
        for ($i=0; $i < count($coureursSelectionnes); $i++) { 
            $course = new CourseTemps();
            $course->fk_etape = $id_etape;
            $course->fk_coureur = $coureursSelectionnes[$i];
            $course->debut=$etape->debut;
            $course->save();
            $j = $j + 1; 
        }
        return back()->with('success', 'coureur inserer'.$j)->withInput();
        // dd($coureursSelectionnes);
    }
    public function destroy(Request $request)
    {
        $request->session()->invalidate();
        return redirect('/');
    }
    public function get_classement_general(){
        $classement = V_classement_general::selectRaw('sum(points) as points, nom_coureur, numero_dossard, nom_equipe')
        ->groupBy('nom_coureur', 'numero_dossard', 'nom_equipe')
        ->orderBy('points', 'desc')
        ->get();    
        $data = [
            'classement' => $classement
        ];
        return view('equipe.classement_general',$data);
    }
    public function get_classement_general_etape($id_etape){
        $classement = V_classement_rang::where('id_etape',$id_etape)->autosort()->get();
        $data = [
            'classement' =>$classement
        ];

        return view('equipe.classement_general_etape',$data);
    }
    public function get_classement_equipe_categorie($id_categorie){
        $sql = '
        WITH classement as (
            select *,
            dense_rank() over (PARTITION BY id_etape,id_categorie order by duree_total) as rang 
            from v_classement_categorie_sans_rang
            where id_categorie = '.$id_categorie.'
        ),
        point_attributs as(
            select
                classement.*,
                COALESCE(point.points,0) as points
                
                from classement
                left join point on classement.rang = point.classement
        )
        select 
            pa.id_utilisateur,
            pa.nom_equipe,
            sum(pa.points) as total_points,
            dense_rank() over (order by sum(pa.points) desc ) as rang
        from point_attributs pa
        group by 
            pa.id_utilisateur,
            pa.nom_equipe
        order by
            total_points desc
        ';
        // dd($sql);
        $data = DB::select($sql);
        return $data;
    }    
    public function get_classement_equipe(Request $request){
        $classement = V_classement_equipe::all();
        $categorie = Categorie::all();
        $classement_classes = null;
        // $total = V_classement_equipe::sum('points');
        // dd($total);
        if ($request-> input('selectedValue')) {
            $classement_classes = $this->get_classement_equipe_categorie($request-> input('selectedValue'));
            return $classement_classes;
        }
        $data = [
            // 'totalPoints' => $total,
            'classement_cat' => $classement_classes,
            'categorie' =>$categorie,
            'classement' =>$classement
        ];
        return view('equipe.liste_equipe',$data);
    }
    public function get_liste_coureur(){
        $id_user = session('utilisateur')->id_utilisateur;
        $data = Etape::all();
        $id_etape = [];
        $i =0; 
        foreach ($data as $item) {
            $id_etape[$i] = $item-> id_etape;
            $i = $i +1 ;
        }
        $data_go = [];
        for ($i=0; $i < count($id_etape) ; $i++) { 
            $temp = V_etape_coureur_lib::where('id_etape',$id_etape[$i])->where('id_utilisateur',$id_user)->get();
            $data_go[] = $temp; 
        }
        $go = [
            'data' => $data_go,
        ];
        return view('equipe.acceuil',$go);
    }
    public function generate_categorie(){
        Categorie_coureur::generate_categorie();
        return back()->with('success','genre setter');
    }

    public function generate_pdf(){
        $classement = V_classement_equipe::where('rang',1)->get();
        // dd($classement);
        if (count($classement) == 1) {
            $pdf = PDF::loadHTML('
            <html>
                    <head><meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <style>
                            body,
                            html {
                                margin: 0;
                                padding: 0;
                                background-color: transparent;
                            }

                            body {
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                height: 100vh;
                                font-family: monospace;
                                font-size: 24px;
                                text-align:center;
                            }

                            .container {
                                background-image: url("assets/fond.jpg");
                                border: 20px solid #d8d2bf;
                                width: 1000px;
                                height: 800px;
                                background-color: transparent;
                                display: flex;
                                flex-direction: column;
                                justify-content: space-around;
                                padding: 40px;
                                box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
                            }

                            .logo {
                                color: #715700;;
                                font-weight: normal;
                                text-align: center;
                            }

                            .marquee,
                            .assignment,
                            .person,
                            .reason {
                                color: #000;
                                font-weight: normal;
                            }

                            .logo {
                                font-size: 36px;
                                font-weight: bold;
                            }

                            .marquee {
                                margin-top: 30px;
                                display: flex;
                                align-items: center;
                                margin-bottom: 30px;
                                justify-content: center;
                            }

                            .assignment {
                                display: flex;
                                justify-content: center;
                                font-family: monospace;
                            }

                            .person {
                                
                                font-size: 32px;
                                font-style: italic;
                                margin: 20px auto;
                            
                            }

                            .reason {
                                text-align: center;
                                font-family: system-ui;
                                font-size: 12pt;        
                            }
                        </style>
                    </head>

                    <body>
                        <div class="container">
                            <div class="logo">
                                ULTIMATE TEAM RACE
                            </div>
                            <hr style="color: #715700; width: 80%; height: 4px; background: #715700;background-color: #715700;">
                            <div class="marquee">
                                <img style="height: 139px;" src="assets/sary.png" alt="" srcset="">
                            </div>

                            <div class="assignment">
                                Ce certificat est attribué à
                            </div>

                            <div class="person">
                                '.$classement[0]->nom_equipe.'
                            </div>

                            <div class="reason">
                                Ce certificat est décerné en reconnaissance de ses efforts, de sa persévérance et de son excellence. Nous saluons sa capacité à relever ce défi physique et mental et à se hisser au sommet avec grâce et courage.
                            </div>
                            <div class="footer" style="
                                display: flex;
                                flex-direction: row;
                                align-content: center;
                                justify-content: space-between;
                                ">
                                <div class="signature">
                                    <p>______________</p>
                                    <p style="text-align: center;">Signature</p>
                                </div>
                                <div class="detail"></div>
                                <div class="date">
                                    <p>______________</p>
                                    <p style="text-align: center;">Date</p>
                                </div>
                            </div>
                        </div>
                    </body>

                    </html>
            ');
            $pdf->setPaper([0, 0, 840, 690], 'paysage');
            return $pdf->download('certificat.pdf');
        }
    }
}

