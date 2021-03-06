<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\CompteFormation;
use App\Models\Cour;
use App\Models\Entreprise;
use App\Models\Formation;
use App\Models\Module;
use App\Models\Secteur;
use App\User;
use Illuminate\Support\Facades\Hash;

use App\Models\Organisme;
use App\Models\Pay;
use App\Models\Torganisme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

	    $user = User::find(Auth::user()->id);
	    $formations = $user->formations;
	    return view('Member/Formations/index')->with(compact('formations'));
    }

	public function subscribe(Request $request){
		$formation = Formation::where('token',$request->token)->first();
		$cf = [];
		$cf['active'] = $formation->gratuite?1:0;
		$cf['compte_id'] = Auth::user()->id;
		$cf['entreprise_formation_id'] =0;
		$cf['formation_id'] = $formation->id;
		$cf['token'] = sha1(Auth::user()->id . date('Ymdhsi'). $formation->id);
		$cf = CompteFormation::create($cf);
		return response()->json(compact('cf'));
	}


	public function getAllBySecteur($token){
		$secteur = Secteur::where('token',$token)->first();
		return view('Front/Formations/by_secteur')->with(compact('secteur'));
	}

	public function getAllByMetier($token){
		$secteur = Metier::where('token',$token)->first();
		return view('Front/Formations/by_metier')->with(compact('secteur'));
	}

	public function readVideo ($filename) {
		// Pasta dos videos.
		$videosDir = public_path('videos');
		if (file_exists($filePath = $videosDir."/".$filename)) {
			$stream = new \App\Http\VideoStream($filePath);
			return response()->stream(function() use ($stream) {
				$stream->start();
			});
		}
		return response("File doesn't exists", 404);
	}

	public function readAudio($filename){

		return response()->streamDownload(function () use ($filename) {
			$audioDir = public_path('podcasts');
			$filePath = $audioDir."/".$filename;
			if ($stream = fopen($filePath, 'r')) {
				while (!feof($stream)) {
					echo fread($stream, 1024);
					flush();
				}
				fclose($stream);
			}
		}, $filename);

	}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pay  $pay
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        //
	    $formation = Formation::where('token',$token)->first()->load('modules','contributeur');
		return view('/Member/Formations/show')->with(compact('formation'));
	    //return response()->json(compact('formation'));
    }


	public function getModule($token){
		$module = Module::where('token',$token)->first();

		$first_test = $module->tests->where('user_id',Auth::user()->id)->where('premier_id',0)->first();
		if(!$first_test){
			$premier = 0;
			return view('Member/Formations/test')->with(compact('module','premier'));
		}

		return view('/Member/Formations/module')->with(compact('module'));
	}




    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pay  $pay
     * @return \Illuminate\Http\Response
     */
    public function edit(Pay $pay)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pay  $pay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pay $pay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pay  $pay
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pay $pay)
    {
        //
    }
}
