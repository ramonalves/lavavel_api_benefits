<?php

namespace App\Http\Controllers;

use App\Benefit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Benefit::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('excel')) {

            $path = $request->file('excel')->getRealPath();
    
            $data = Excel::load($path, function($reader) {})->get();
    
            if(!empty($data) && $data->count()) {
                foreach ($data->toArray() as $key => $value) {
                    if(!empty($value)){
                        unset($value['0']);
                            // print_r($value)  ;exit;
                        Benefit::insert($value);
                    }
    
                }
                return response()->json([
                    'message' => 'Success'
                ], 201);
            }    
        }
    
        return response()->json([
            'message' => 'Error'
        ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Benefit $benefit)
    {
        return $benefit;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Benefit $benefit)
    {
        $benefit->update($request->all());
        return $benefit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Benefit $benefit)
    {
        $benefit->delete();
        return $benefit;
    }
}
