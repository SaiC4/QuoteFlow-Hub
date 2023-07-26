<?php
    require(__DIR__ . "/../lib/functions.php");

    $url = "https://andruxnet-random-famous-quotes.p.rapidapi.com/";

    $response = get($url, "API_KEY", ["cat" => "famous", "count" => 1], true, "andruxnet-random-famous-quotes.p.rapidapi.com");
    error_log("Response: " . var_export($response, true));
