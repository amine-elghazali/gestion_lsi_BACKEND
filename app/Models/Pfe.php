<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pfe extends Model
{
    protected $table="pves";
    use HasFactory;

    protected $fillable=['sujet','etudiant_id','professeur_id'];

    public function professeurs()
      {
           return $this->belongsTo(Professeur::class);
      }

      public function etudiant(){
          return $this->belongsTo(Etudiant::class);
      }
}
