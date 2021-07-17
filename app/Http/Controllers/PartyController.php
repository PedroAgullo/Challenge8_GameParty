<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $resultado = Party::all();
        
        return response()->json([
            'success' => true,
            'data' => $resultado
        ], 200);

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

        $this->validate($request, [
            'title',
            'game_id'
        ]);

        $party = Party::create([
            'title' => $request->title,
            'game_id' => $request->game_id,
            'userOwner' => auth()->user()->id
        ]);

        if ($party){
            return response()->json([
                'success' => true,
                'data' => $party
            ], 200);  

        }else{
            return response()->json([
                'success' => false,
                'message' => 'Error. Party not created'
            ], 500);  
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function show($game_id)
    {
        //

        $resultado = Party::where('game_id', '=', $game_id)->get();
        
        if (!$resultado) {
            return response() ->json([
                'success' => false,
                'data' => 'No se han encontrado partys con ese juego.'], 400);
        } else {
            return response() ->json([
                'success' => true,
                'data' => $resultado,
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Party $party)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $user = auth()-> user();

        $party = Party::all()->find($id);

        if ($user->isAdmin == true || $user->id == $party->userOwner){
            
            if ($party -> delete()){
                return response()->json([
                    'succes' => true,
                    'message' => 'The party ' . $party->title . ' with the id ' . $party->id . ' has been deleted'
                ]);
            }else {
                return response() ->json([
                    'success' => false,
                    'message' => 'Party can not be deleted',
                ], 500);
            }
        }else{
            return response() ->json([
                'success' => false,
                'message' => 'No tienes permiso para realizar esta acción.' . $party->userOwner . $user->id
            ], 400);
        }
    }
}
