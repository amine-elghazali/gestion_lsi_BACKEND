<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use App\Models\Professeur;
use App\Models\Note;

class ProfController extends Controller
{
    public function getProf ()
     {
        $profs = Professeur::get();
        return $profs;
     }

     public function getOneProf($id){
         return $getProf = Professeur::find($id);
     }

     public function store(){
        // Validation :
        request()->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required',
        ]);


        // Adding :
        return Professeur::create([
            'nom' => request ('nom'),
            'prenom' =>request('prenom'),
            'email' =>request ('email'),
        ]);

     }

     public function update(Professeur $professeur){

        // Validation :
        request()->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required',
        ]);

        // Updating data :
        $success = $professeur->update([
            'nom' => request ('nom'),
            'prenom' =>request('prenom'),
            'email' =>request ('email'),
        ]);

        return ['success' => $success];

     }

     public function destroy(Professeur $professeur){
        $success = $professeur->delete();

        return ['success' => $success];
     }






     // Prof ajoute Les notes aux etudiants  :

    public function updateNote($id,$nom_module){
         // This is just to make sure that I'm having the exact data that I want
            //$note_etd=Note::where( ['etudiant_id' => $id,'module' => $nom_module])

           //dd($note_etd);



        request()->validate([
            'note' => 'required'
        ]);

        // Updating :
        $success =  Note::where(
            ['etudiant_id' => $id,
            'module' => $nom_module]
            )->update([
            'note' => request('note'),
        ]);

        return ['success' => $success];
    }

    public function indexProf($module){
       // dd (Note::where('module',$module)->get());
        return Note::where('module',$module)->get();
    }

}
