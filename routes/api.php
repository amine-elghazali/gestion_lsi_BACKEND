<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfController;

use App\Http\Controllers\PfeController;
use App\Http\Controllers\EtudiantController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Espace Admin  :
    // Gestion etudiant :

        // Get all Etudiant :
        Route::get('/admin/etudiant',[EtudiantController::class,'getEtudiants']);

            // Get one Etudiant :
        Route::get('/admin/etudiant/{id}',[EtudiantController::class,'getOneEtd']);
            // Add Etudiant :
        Route::post('/admin/etudiant',[EtudiantController::class,'store']);
            // edit Etudiant :
        Route::put('/admin/etudiant/{etudiant}',[EtudiantController::class,'update']);
            // delete Etudiant :
        Route::delete('/admin/etudiant/{etudiant}',[EtudiantController::class,'destroy']);

    // Gestion prof  :

        // Get all Prof :
        Route::get('/admin/prof',[ProfController::class,'getProf']);

            // Get one Prof :
        Route::get('/admin/prof/{id}',[ProfController::class,'getOneProf']);
            // Add Prof :
        Route::post('/admin/prof',[ProfController::class,'store']);
            // edit Prof :
        Route::put('/admin/prof/{professeur}',[ProfController::class,'update']);
            // delete Prof :
        Route::delete('/admin/prof/{professeur}',[ProfController::class,'destroy']);


    // Prof Modifier les notes des etudiants :
        Route::put('/prof/etudNote/{id}/{nom_module}',[ProfController::class,'updateNote']);
        // get module by prof
        Route::get('/prof/{module}',[ProfController::class,'indexProf']);


    Route::get('/module/prof',[ModuleController::class,'getModulesByProf']);

    // Pour l'etudiant :
    Route::get('/note/etudiant',[ModuleController::class,'getNoteByEtudiant']); // affiche tt les note d'un étudiant

    // Pour le prof :
    Route::get('/note/module',[ModuleController::class,'getNoteByModule']);// afficher les notes de tt les etudiants du même module

        // Gestion de PFE par les profs :
    Route::post('/pfe/prof/create' , [PfeController::class,'CreatePfe']);

    Route::put('/pfe/prof/update/{id}' , [PfeController::class,'UpdatePfe']);

    Route::get('/pfe/prof',[PfeController::class,'getPfeByProf']);// retourne les pfe que encadre un prof


    // retourne pfe de l'etudiant
    Route::get('/pfe/etudiant',[PfeController::class,'getPfeByEtudiant']);




        use App\Http\Controllers\AuthController;

        Route::group([
            'middleware' => 'api',

        ], function ($router) {
            Route::post('/login', [AuthController::class, 'login']);
            Route::post('/register_prof', [AuthController::class, 'register_prof']);
            Route::post('/register_etudiant', [AuthController::class, 'register_etudiant']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::get('/user', [AuthController::class, 'userProfile']);
        });



?>
