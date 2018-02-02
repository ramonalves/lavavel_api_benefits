<?php

namespace App\Http\Controllers;

use App\Benefit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

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
            $validator = Validator::make($request->all(), [
                'excel' => 'required|mimes:xlsx,csv'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Error de validação do arquivo.'
                ], 422);
            }
            $path = $request->file('excel')->getRealPath();
    
            $data = Excel::load($path, function($reader) {})->get();
    
            if(!empty($data) && $data->count()) {
                foreach ($data->toArray() as $key => $value) {
                    if(!empty($value)){
                        unset($value['0']);
                        try {
                            Benefit::insert($value);
                        } catch (\Exception $e) {
                            return response()->json([
                                'message' => $e->message()
                            ], 500);
                        }   
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
