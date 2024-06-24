<?php

use App\Http\Controllers\AdminControlleur;
use App\Http\Controllers\InitControlleur;
use App\Http\Controllers\PointControlleur;
use App\Http\Controllers\ToolControlleur;

use App\Http\Middleware\Adminvalidation;
use App\Http\Middleware\SessionValidation;
use App\Models\Etape;
use App\Models\Utilisateur;
use App\Models\V_categorie_coureur_lib;
use App\Models\V_detail_penalite;
use Illuminate\Support\Facades\Route;
use App\Models\Employe;

Route::get('/', function () {
    // session()->invalidate();
    return view('login.login_user');
});

Route::get('/resultat/{id_etape}',[InitControlleur::class,'get_classement_general_etape'])->name('result_etape');
Route::get('/resultat_equipe',[InitControlleur::class,'get_classement_equipe'])->name('show_classement_general');

Route::get('/login_admin',function(){
    return view('login.login_admin');
});
Route::post('verify_login',[InitControlleur::class,'verify_login'])->name('verify');

Route::middleware([SessionValidation::class])->group(function(){
    Route::get('/disconnect',[InitControlleur::class,'destroy']);
    Route::get('/liste_etape',function(){
        $etape = DB::select('select * from etape order by rang_etape asc');
        $data = [
            'etape' => $etape
        ];
        return view('equipe.liste_etape',$data);
    });
    Route::get('/affectation/{id}',[InitControlleur::class,'affectation_joueur'])->name('affectation');
    Route::post('/course',[InitControlleur::class,'store_affectation']);
    Route::get('/acceuil',[InitControlleur::class,'get_liste_coureur']);
});

Route::middleware([Adminvalidation::class])->group(function(){
    Route::get('/liste_etape_admin',function(){
        $etape = DB::select('select * from etape order by rang_etape asc');
        $data = [
            'etape' => $etape
        ];
        return view('admin.liste_etape_admin',$data);
    });
    Route::get('/affectation_temps/{id}',[AdminControlleur::class,'affectation_temps'])->name('affectation_temps');
    Route::post('/debut',[AdminControlleur::class,'update_debut']);
    Route::post('/store_affectation_temps',[AdminControlleur::class,'edit_fin']);
    Route::get('/import_etape_resultat',function(){ return view('admin.import_etape_resultat');});
    Route::get('/import_points',function(){ return view('admin.import_point');});
    Route::post('/import_etape_resulat',[ToolControlleur::class,'import_csv_etape_resultat']);
    Route::post('/import_points',[PointControlleur::class,'import_csv_etape_resultat']);
    Route::get('/categorie',function(){
        $categorie_coureur = V_categorie_coureur_lib::all();
        $data = [
            'categorie' => $categorie_coureur
        ];
        return view('admin.categorie',$data);
    });
    Route::get('/setCategorie',[InitControlleur::class,'generate_categorie']);
    Route::get('/reinitialiser',[ToolControlleur::class,'clear']);
    Route::get('/penalite',function(){
        $etape = Etape::all();
        $equipe = Utilisateur::where('is_admin',0)->get();
        $penalite = V_detail_penalite::all();
        // dd($equipe);
        $data = [
            'penalite'=>$penalite,
            'etape' => $etape,
            'equipe' => $equipe
        ];
        return view('admin.penalite',$data);
    });
    Route::post('/store_pen',[AdminControlleur::class,'store_penalite']);
    Route::post('/del_penalite',[AdminControlleur::class,'delete_penalite']);
    Route::get('/generate_pdf',[InitControlleur::class,'generate_pdf']);
    Route::get('/detail_score/{id}',[AdminControlleur::class,'alea2'])->name('detail_score');
});



















// Route::get('/map', function () {
//     return view('page.map');
// });
// Route::get('/import1', function () {
//     return view('page.import_csv');
// });



