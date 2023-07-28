<?php
require(__DIR__ . "/../../partials/nav.php");

function getRandomQuote() {
    $api_url = "https://andruxnet-random-famous-quotes.p.rapidapi.com/"; // Replace with the actual API endpoint for random quotes
    $api_key = "3385436b3cmshe026df045a06d12p1fa99fjsn35c89d10e353"; // Replace with your actual API key

    $headers = [
        "X-Api-Key: $api_key"
    ];

    $result = get($api_url, $api_key, [], false, $headers);
    error_log("Response: " . var_export($result, true));
    
    if (se($result, "status", 400, false) == 200 && isset($result["response"])) {
        $result = json_decode($result["response"], true);
        return $result;
    } else {
        return false;
    }
}

$quoteText = "Click the button below to retrieve a random quote.";
$quoteAuthor = "";

if (isset($_POST["getQuoteBtn"])) {
    $quoteData = getRandomQuote();
    if ($quoteData) {
        $quoteText = isset($quoteData["quote"]) ? $quoteData["quote"] : "Failed to retrieve quote.";
        $quoteAuthor = isset($quoteData["author"]) ? $quoteData["author"] : "";
    }
}

$quoteText = htmlspecialchars($quoteText, ENT_QUOTES, 'UTF-8');
$quoteAuthor = htmlspecialchars($quoteAuthor, ENT_QUOTES, 'UTF-8');
?>

<div class="container-fluid">
    <h1>Random Quotes - Demo</h1>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card" style="width: 30em;">
                <div class="card-body text-center">
                    <h5 class="card-title">Random Quote</h5>
                    <p class="card-text"><?php echo $quoteText; ?></p>
                    <p class="card-text">- <?php echo $quoteAuthor; ?></p>
                    <form method="post">
                        <button class="btn btn-primary" type="submit" name="getQuoteBtn">Get Random Quote</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>