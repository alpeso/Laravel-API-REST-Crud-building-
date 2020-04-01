<?php

namespace Building\Http\Controllers;

use Illuminate\Http\Request;
use Building\Building;
use Building\Helpers\APIHelpers;
use Validator;
class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buildings = Building::all();
        $response = APIHelpers::createAPIResponse(false, 200, '',$buildings);
        return response()->json($response, 200);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // We create the validation rules
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:building',
            'phone' => 'required',
            'birth_date' => 'required'
        ];
        //  // Ejecutamos el validador, en caso de que falle devolvemos la respuesta
        $validator = \Validator::make($request->all(), $rules);
         if ($validator->fails()) {
             //401 return array of errors
            $response = APIHelpers::createAPIResponse(true, 401, $validator->errors()->all(), null);
            return response()->json($response);
         }

        $building_save = Building::create($request->all());
        if($building_save){
            $response = APIHelpers::createAPIResponse(false, 201, 'Buildin added successfully', null);
            return response()->json($response);
        }else{
            $response = APIHelpers::createAPIResponse(true, 400, 'Buildin creation failed', null);
            return response()->json($response);
        }   
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        // We create the validation rules
        $rules = [
            'id' => 'required|exists:building,id'        
        ];
        $validator = \Validator::make(["id"=>$id], $rules);
         if ($validator->fails()) {
             //401 return array of errors
            $response = APIHelpers::createAPIResponse(true, 401, $validator->errors()->all(), null);
            return response()->json($response);
        }
        
        $building = Building::find($id);
        $response = APIHelpers::createAPIResponse(false, 200, '',$building);
        return response()->json($response, 200);
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

        // We create the validation rules
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'birth_date' => 'required'
        ];
        //  // Ejecutamos el validador, en caso de que falle devolvemos la respuesta
        $validator = \Validator::make($request->all(), $rules);
         if ($validator->fails()) {
             //401 return array of errors
            $response = APIHelpers::createAPIResponse(true, 401, $validator->errors()->all(), null);
            return response()->json($response);
        }


        $building = Building::find($id);
        $building->first_name = $request->first_name;
        $building->last_name = $request->last_name;
        $building->address = $request->address;
        $building->email = $request->email;
        $building->phone = $request->phone;
        $building->birth_date = $request->birth_date;
        $building_update = $building->save();

        if($building_update){
            $response = APIHelpers::createAPIResponse(false, 200, 'Buildin updated successfully', null);
            return response()->json($response, 200);
        }else{
            $response = APIHelpers::createAPIResponse(true, 400, 'Buildin update failed', null);
            return response()->json($response);
        }   
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        // We create the validation rules
        $rules = [
            'id' => 'required|exists:building,id'        
        ];
        $validator = \Validator::make(["id"=>$id], $rules);
         if ($validator->fails()) {
             //401 return array of errors
            $response = APIHelpers::createAPIResponse(true, 401, $validator->errors()->all(), null);
            return response()->json($response);
        }
        $building = Building::find($id);
        $building_delete = $building->delete();
        if($building_delete){
            $response = APIHelpers::createAPIResponse(false, 200, 'Buildin deleted successfully', null);
            return response()->json($response, 200);
        }else{
            $response = APIHelpers::createAPIResponse(true, 400, 'Buildin delete failed', null);
            return response()->json($response);
        }  
    }
}
