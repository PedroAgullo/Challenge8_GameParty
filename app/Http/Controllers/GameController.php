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
            'url' => $request->url
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
    public function update(Request $request, Game $game)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }
}
