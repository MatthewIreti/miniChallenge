<?php
/**
 * Created by PhpStorm.
 * User: Matthew Odedoyin
 * Date: 2/24/2018
 * Time: 12:21 PM
 */

namespace App\Utility;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

define('RESULT_OK', 200);


class ApiHelper
{
    protected $baseUrl = "https://one.nhtsa.gov/webapi/api/SafetyRatings/";
    private $format = "?format=json";

    /**
     * @var Client
     */
    private $client;


    /**
     * @param $endpoint
     * @param bool $withRating
     * @param array $params
     * @param string $method
     * @return mixed
     */
    function getResponse($endpoint, $withRating = false, $params = [], $method = "GET")
    {
        $this->client = new Client([
            'verify' => false
        ]);

        $url = $this->baseUrl . $endpoint . $this->format;

        $response = $this->client->request($method, $url, $params);
        return $this->toJson($response, $withRating);
    }


    /**
     * @param $data Response
     * @param $withRating
     * @return mixed
     */
    private function toJson($data, $withRating)
    {
        if ($data->getStatusCode() == RESULT_OK) {
            $item = (object)json_decode($data->getBody(), true);
            if ($withRating) {
                $rating = 0;
                foreach ($item->Results as $item) {
                    if ($item["OverallRating"] != "Not Rated")
                        $rating += $item["OverallRating"];
                }
                return $rating > 0 ? $rating : "Not Rated";
            } else {
                $resp = [
                    'Message' => $item->Message,
                    'Count' => $item->Count,
                    'Results' => $this->formatResult($item->Results)
                ];
            }


            return $resp;
        }

        return [
            'statusCode' => $data->getStatusCode(),
            'message' => $data->getReasonPhrase()
        ];
    }

    private function formatResult($results)
    {
        $data = [];
        foreach ($results as $item) {
            $row = [];
            $row["Description"] = $item['VehicleDescription'];
            $row["VehicleId"] = $item['VehicleId'];
            $data[] = $row;
        }
        return $data;
    }
}