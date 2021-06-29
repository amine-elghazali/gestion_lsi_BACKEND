<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Etudiant;
use App\Models\Professeur;
use App\Models\Pfe;

class PfeController extends Controller
{

    public function CreatePfe(){

            // Validation :
            request()->validate([
                'sujet' => 'required',
                'etudiant_id' => 'required',
                'professeur_id' => 'required'
            ]);


            // Adding :
            return Pfe::create([
                'sujet' => request('sujet'),
                'etudiant_id' => request('etudiant_id'),
                'professeur_id' => request('professeur_id')
            ]);

    }

    public function UpdatePfe($id){

        // Validation :
        request()->validate([
            'sujet' => 'required',
            'etudiant_id' => 'required',
            'professeur_id' => 'required'
        ]);


        // Adding :
        $success = Pfe::where('id',$id)->update([
            'sujet' => request('sujet'),
            'etudiant_id' => request('etudiant_id'),
            'professeur_id' => request('professeur_id')
        ]);

        return ['success : ',$success];

}

    public function getPfeByProf(Request $request){
        $prof = Professeur::firstWhere('user_id',$request->user()->id);

        $pfes = Pfe::where('professeur_id',$prof->id)->get();

        foreach ($pfes as $pfe) {
            $pfe -> etudiant;
        }
        return $pfes;
   }

   public function getPfeByEtudiant(Request $request){

    $etudiant =Etudiant::firstWhere('user_id',$request->user()->id)->pves;

    $pfe = Professeur::firstWhere('id',$etudiant->professeur_id);

    return [$etudiant,$pfe];
    //$pfe = Etudiant::where($id)->pves;
    //return $pfe;
   }
}
