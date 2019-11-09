<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Actif;
use App\Models\Bilan;
use App\Models\ChoicesProjet;
use App\Models\Parametre;
use App\Models\ProduitsProjet;
use App\Models\Projet;
use App\Models\Resultat;
use App\Models\Tactif;
use App\Models\Tags;
use App\Models\TagsProjet;

use App\Models\Tprojet;
use App\Models\Variante;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ModeleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pacte()
    {
        //
	    $param = Parametre::find(1);
	    return response()->download(public_path('files/docs/').$param->pacte_associes);
    }

	public function pret()
	{
		//
		$param = Parametre::find(1);
		return response()->download(public_path('files/docs/').$param->contrat_pret);
	}

	public function actif()
	{
		//
		$param = Parametre::find(1);
		return response()->download(public_path('files/docs/').$param->contrat_cession_actifs);
	}
	public function creance()
	{
		//
		$param = Parametre::find(1);
		return response()->download(public_path('files/docs/').$param->contrat_cession_creances);
	}

	public function concession()
	{
		//
		$param = Parametre::find(1);
		return response()->download(public_path('files/docs/').$param->contrat_concession);
	}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tactifs = Tactif::all();
        //$tinvestissements = Tinvestissement::all();
        //$variantes = Variante::all();
	    $villes = Ville::all();

        return view('/Owner/Actifs/create')->with(compact('tactifs','villes'));
    }

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 * edit a field with a new value
	 */



	public function addTags(Request $request){
		//dd(public_path('img'));

		$projet = Projet::where('token',$request->projet_token)->first();
		$tag = TagsProjet::all()->where('tag_id',$request->tag_id)->where('projet_id',$projet->id)->first();
		if(!$tag){
			$tag = new TagsProjet();
			$tag->tag_id = $request->tag_id;
			$tag->projet_id = $projet->id;
			$tag->save();
		}
		return back();
	}




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
	   // dd($request);
	    $token = sha1(date('ydmhis') . Auth::user()->id);
	    $actif = new Actif();
        $actif->name = $request['name'];
        $actif->ville_id = $request['ville_id'];
	    $actif->tactif_id = $request['tactif_id'];
	    $actif->description = $request['description'];
	    $actif->caracteristiques = $request['caracteristiques'];
	    $actif->prix = $request['prix'];
	    $actif->owner_id = Auth::user()->id;
	    $actif->token = $token;
	    if($request->imageUri){
		    $file = $request->imageUri;
		    $ext = $file->getClientOriginalExtension();
		    $arr_ext = array('jpg','png','jpeg','gif');
		    if(in_array($ext,$arr_ext)) {
			    if (!file_exists(public_path('img') . '/actifs')) {
				    mkdir(public_path('img') . '/actifs');
			    }

			    if (file_exists(public_path('img') . '/actifs/' . $token . '.' . $ext)) {
				    unlink(public_path('img') . '/actifs/' . $token . '.' . $ext);
			    }
			    $name = $token . '.' . $ext;
			    $file->move(public_path('img/actifs'), $name);
			    $actif->imageUri = 'actifs/' . $name;
		    }

	    }

        $actif->save();
	    $request->session()->flash('success','L\'article a été correctement enregistré !!!');
	    return redirect('/owner/actifs');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        //
		$tags = Tags::all();
	    $projet = Actif::where(['token'=>$token])->first();
	    //dd($dossier->bilans);
	    $tactifs = Tactif::all();
	    $villes = Ville::all();
	    return view('Owner/Actifs/show')->with(compact('projet','tags','tactifs','villes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function edit($token)
    {
        //
	    $actif = Actif::where(['token'=>$token])->first();
	   // dd($actif);
	    $tactifs = Tactif::all();
	    $villes = Ville::all();
	    return view('Owner/Actifs/edit')->with(compact('actif','villes','tactifs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actif $actif)
    {
        //
	    dd($request);
    }

	public function save(Request $request){

		$token = $request->token;
		$actif = Actif::find($request->id);

		$actif->name = $request['name'];
		$actif->ville_id = $request['ville_id'];
		$actif->tactif_id = $request['tactif_id'];
		$actif->description = $request['description'];
		$actif->caracteristiques = $request['caracteristiques'];
		$actif->prix = $request['prix'];
		$actif->owner_id = Auth::user()->id;

		//$actif->token = $token;
		if($request->imageUri){
			$file = $request->imageUri;
			$ext = $file->getClientOriginalExtension();
			$arr_ext = array('jpg','png','jpeg','gif');
			if(in_array($ext,$arr_ext)) {
				if (!file_exists(public_path('img') . '/actifs')) {
					mkdir(public_path('img') . '/actifs');
				}

				if (file_exists(public_path('img') . '/' . $actif->imageUri )) {
					unlink(public_path('img') . '/' . $actif->imageUri);
				}
				$name = $token . '.' . $ext;
				$file->move(public_path('img/actifs'), $name);
				$actif->imageUri = 'actifs/' . $name;
			}

		}

		$actif->save();
		$request->session()->flash('success','L\'article a été correctement enregistré !!!');
		return redirect('/owner/actifs/'.$actif->token);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projet $projet)
    {
        //
    }
}