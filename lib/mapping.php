<?php

function map_data($api_data){
    $records = [];
    foreach($api_data as $data){
        // Gets the city, state code, and country
        $record["city"] = $data["city_name"];                   
        $record["state"] = $data["state_code"];                  
        $record["country"] = $data["country_code"];

        // Gets the date and time (example format: "2023-07-18 22:52")
        $record["date_time"] = $data["ob_time"];
        
        // Gets the temperature in Farenheit (Imperial measurement)
        $record["temp"] = $data["temp"];
        
        // Gets the longitude and latitude of the location
        $record["longit"] = $data["lon"];                      
        $record["latit"] = $data["lat"];
        
        // Gets the air quality index
        $record["airqual"] = $data["aqi"];

        array_push($records, $record);
    }
    return $records;
}