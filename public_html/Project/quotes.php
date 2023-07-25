<?php
require(__DIR__ . "/../../partials/nav.php");
$result = get("https://andruxnet-random-famous-quotes.p.rapidapi.com/", "API_KEY", ["cat" => "famous", "count" => 1], false);
error_log("Response: " . var_export($result, true));
if (se($result, "status", 400, false) == 200 && isset($result["response"])) {
    $result = json_decode($result["response"], true);
} else {
    $result = [];
}

$quoteText = isset($result["quote"]) ? $result["quote"] : "Failed to retrieve quote.";

$quoteText = htmlspecialchars($quoteText, ENT_QUOTES, 'UTF-8');
?>
<div class="container-fluid">
    <h1>Random Quote - Demo</h1>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card" style="width: 30em;">
                <div class="card-body text-center">
                    <h5 class="card-title">Random Quote</h5>
                    <p class="card-text"><?php echo $quoteText; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>