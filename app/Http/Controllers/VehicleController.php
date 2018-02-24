<?php

namespace App\Http\Controllers;

use App\Model\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{

    public function index()
    {
        //return Vehicle::allByModelYear(2015);
    }

    public function vehicleSafetyRatings($modelYear, $manufacturer, $model)
    {
        $param =\request('withRating');
        if ($param == "true"){
            return Vehicle::ratingResults($modelYear, $manufacturer, $model);
        }
        else if ($modelYear == "undefined")
        {
            return [
                "Result"=>[],
                "Count"=>0
            ];
        }
        else{
            return Vehicle::ratingsByProperties($modelYear, $manufacturer, $model);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'modelYear' => 'required|numeric',
            'manufacturer' => 'required',
            'model' => 'required'
        ]);
        if ($v->fails())
        {
            return [
              "Result"=>[],
              "Count"=>0
            ];
        }

        return Vehicle::createVehicle($request->all());
    }


    public function show($id)
    {

    }
}
