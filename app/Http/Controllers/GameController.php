<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //    
        $resultado = Game::all();
        
        return response()->json([
            'success' => true,
            'data' => $resultado
        ], 200);

    }


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function byId(Request $request)
    {
        //    
        $game = Game::all()->find($request->gameId);
        
        return response()->json([
            'success' => true,
            'data' => $game,
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
            'title' => 'required',
            'image' => 'required',
            'url' => 'required',
        ]);

        $game = Game::create([
            'title' => $request->title,
            'image' => $request->image,
            'url' => $request->url,
            'genre' => $request->genre
        ]);

        if ($game){

            return response()->json([
                'success' => true,
                'data' => $game
            ], 200);  

        }else{
            return response()->json([
                'success' => false,
                'message' => 'Error. Game not created'
            ], 400);  
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show($game)
    {
        //
        $resultado = Game::find($game);
        
        return response()->json([
            'success' => true,
            'data' => $resultado
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $user = auth()-> user();

        if($user->isAdmin == false){
            return response()->json([
                'success' => true,
                'message' => 'No tienes permiso para editar los datos de los juegos ' 
            ], 400);
        }


        $updated = $game->fill($request->all())->save();
        
        if ($updated)
            return response()->json([
                'success' => true,
                'message' => 'Data user updated'
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'User can not be updated'
            ], 500);





    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */

     public function destroy($id)
    {
        //

        $user = auth()-> user();

        if($user->isAdmin == false){
            return response()->json([
                'success' => true,
                'message' => 'No tienes permiso para eliminar juegos ' 
            ], 400);
        }

        $game = Game::all()->find($id);

        if ($game -> delete()){
            return response()->json([
                'succes' => true,
                'message' => 'The game ' . $game->title . ' with the id ' . $game->id . ' has been deleted'
            ]);
        }else {
            return response() ->json([
                'success' => false,
                'message' => 'Game can not be deleted',
            ], 500);
        }

    }
}
