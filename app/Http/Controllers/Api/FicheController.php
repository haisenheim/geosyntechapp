<?php

namespace App\Http\Controllers\Api;

use App\Models\Fiche;
use App\Models\Moi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class FicheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
	   //dd(Auth);

	    if (Auth::user()) {

		    $user = Auth::user();
		   // dd(sha1($user->id . date('Ymdhis')));
		    $fiche = Fiche::create(['name'=>str_pad(date('ydm').$user->client_id,10,'0',STR_PAD_LEFT),'jour'=>new \DateTime(), 'user_id'=>$user->id, 'client_id'=>$user->client_id,
		        'token'=>sha1($user->id . date('Ymdhis')), 'moi_id'=>date('m'),'annee'=>date('Y')
		    ]);

		    return response()->json([
			    'success' => true,
			    'message' => 'Fche créée avec succès !!!',
			    'fiche'=>$fiche
		    ]);
	    }else {
		    return response()->json([
			    'success' => false,
			    'message' => 'Impossible de creer la fiche'
		    ]);
	    }



    }


	public function getMonths(){
		if (Auth::user()) {

			$user = Auth::user();
			// dd(sha1($user->id . date('Ymdhis')));
			$months = Moi::all();

			return response()->json([
				'success' => true,
				'message' => 'Toutes les fiches par mois !!!',
				'fiche'=>$months
			]);
		}else {
			return response()->json([
				'success' => false,
				'message' => 'Impossible de charger les mois'
			]);
		}
	}

	public function getFicheByMonth(){
		if (Auth::user()) {

			$fiches = Fiche::all()->where('moi_id',request('id'));
			$month = Moi::find(request('id'));
			return response()->json([
				'success' => true,
				'message' => 'Toutes les fiches par mois !!!',
				'fiches'=>$fiches,
				'month'=>$month
			]);
		}else {
			return response()->json([
				'success' => false,
				'message' => 'Impossible de charger les fiches'
			]);
		}
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}