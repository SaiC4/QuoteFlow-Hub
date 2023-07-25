<?php

function map_data($api_data){
    $records = [];
    foreach($api_data as $data){
        // Gets the quote
        $record["quote"] = $data["quote"];      
        
        // Gets the author
        $record["author"] = $data["author"];

        array_push($records, $record);
    }
    return $records;
}