<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $resultado = Membership::all();
        return response()->json([
            'success' => true,
            'message' => $resultado
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

        $user = auth()->user();

        $this->validate($request, [
            'party_id'  
        ]);

        $resultado = Membership::where('party_id', '=', $request->party_id)->where('user_id', '=', $user->id)->get();

        if($resultado->isEmpty()){
            $party = Membership::create([
                'user_id' => $user->id,
                'party_id' => $request->party_id,
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

        return response()->json([
            'success' => true,
            'message' => "Ya estabas dentro de este party."
        ], 200); 

    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function show($party_id)
    {
        //
        $resultado = Membership::all()->groupBy('party_id');
        return response()->json([
            'success' => true,
            'message' => $resultado
        ], 200); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Membership $membership)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function destroy($party_id)
    {
        //

        $user = auth()->user();

        $resultado = Membership::where('party_id', '=', $party_id)->where('user_id', '=', $user->id)->get();

        if($resultado->isEmpty()){
        
            return response()->json([
                'success' => false,
                'message' => "No estás dentro de esta party"
            ], 400); 
        }else {
            try{
                $resultado = Membership::selectRaw('id')
                ->where('party_id', '=', $party_id)
                ->where('user_id', '=', $user->id)->delete();

                return response()->json([
                    'success' => true,
                    'messate' => "Has abandonado la party"
                ], 200); 

            }catch(QueryException $err){
                return response()->json([
                    'success' => false,
                    'data' => $err
                ], 400); 
            }
        }
    }
}
