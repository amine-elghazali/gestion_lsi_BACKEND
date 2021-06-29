<?php

namespace App\Http\Controllers;

use App\Models\Professeur;

use App\Models\Note;
use App\Models\Etudiant;
use App\Models\Module;
use App\Http\Resources\EtudiantResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function getModulesByProf(Request $request){
        //$id=Professeur::find($user_id);
        //$modules = Professeur::find($id)->modules;


        $prof =Professeur::firstWhere('user_id',$request->user()->id);

        $module = Module::firstWhere('professeur_id',$prof->id);
        return $module;
   }

   public function getNoteByEtudiant(Request $request){

        $etudiant =Etudiant::firstWhere('user_id',$request->user()->id);

        return $notes= Note::where('etudiant_id',$etudiant->id)->get();

        //$notes = Etudiant::find($id)->notes;

        //return $notes;
   }

    public function getNoteByModule(Request $request){

        $prof =Professeur::firstWhere('user_id',$request->user()->id);

        $module = Module::firstWhere('professeur_id',$prof->id);
        $notes = Note::all()->where('module',$module['nom']);
        foreach ($notes as $note ) {
            $note -> etudiant;
        }
        
        return $notes;
        
    }
}
