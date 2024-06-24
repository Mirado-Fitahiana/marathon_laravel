<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Utilisateur extends Model
{
    use HasFactory;
    protected $table = 'utilisateur';
    protected $primaryKey = 'id_utilisateur';

    public function verify_pass($mail,$pass){
        $verify = DB::table('utilisateur')->where('mail',$mail)->where('password',$pass)->first();
        // dd($verify);
        if($verify){
            if ($verify->is_admin === 5) {
                session(['admin' => $verify]);
            }else {
                session(['utilisateur' => $verify]);
            }
            return true;
        }else{
            return false;
        }
    }  
}
