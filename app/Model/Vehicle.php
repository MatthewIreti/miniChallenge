<?php
/**
 * Created by PhpStorm.
 * User: BST-TECHNICAL
 * Date: 2/24/2018
 * Time: 3:47 PM
 */

namespace App\Model;


use App\Utility\ApiHelper;


class Vehicle extends ApiHelper
{


    /**
     * @return mixed
     */
    public static function allByModelYear($year)
    {
        return (new Vehicle)->getResponse('modelYear/' . $year);
    }

    public static function ratingsByProperties($year, $manufacturer, $model)
    {
        return (new Vehicle)->getResponse('modelYear/' . $year . '/make/' . $manufacturer . '/model/' . $model);

    }

    public static function createVehicle($params)
    {
        return (new Vehicle)->getResponse('modelYear/' . $params['modelYear'] . '/make/' . $params['manufacturer'] . '/model/' . $params['model'], false);
    }

    public static function ratingResults($modelYear, $manufacturer, $model)
    {
        $vehicles = (new Vehicle)->getResponse('modelYear/' . $modelYear . '/make/' . $manufacturer . '/model/' . $model);

        if ($vehicles['Count'] > 0) {
            $data = [];
            foreach ($vehicles["Results"] as $vehicle) {
                // Get the Crash rating
                $row = [];
                $row["Description"] = $vehicle["Description"];
                $row["VehicleId"] = $vehicle["VehicleId"];
                $row["CrashRating"] = (new Vehicle())->getCrashRating($vehicle["VehicleId"]);
                $data[] = $row;
            }
            $vehicles["Results"] = $data;
            return $vehicles;
        }
    }

    private function getCrashRating($vehicleId)
    {
        return (new Vehicle)->getResponse('VehicleId/' . $vehicleId, true);
    }


}