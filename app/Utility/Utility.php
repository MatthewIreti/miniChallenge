<?php
/**
 * Created by PhpStorm.
 * User: Matthew Odedoyin
 * Date: 2/24/2018
 * Time: 12:21 PM
 */

namespace App\Utility;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;


class Utility
{
    protected static $baseUrl = "http://one.nhtsa.gov/webapi/api/SafetyRatings/";

    /**
     * @return ResponseInterface
     */
    public static function test()
    {

        $client = new GuzzleClient([
                'verify'=>false
        ]);

         return $client->request("GET", self::getSafetyRatings(2015, 'Audi', 'A3'));
    }

    private static function getSafetyRatings($modelYear, $manufacturer, $model)
    {
        return self::$baseUrl.'modelyear/'.$modelYear.'/make/'.$manufacturer.'/model/'.$model.'?format=json';
    }

}