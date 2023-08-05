<?php
require_once(__DIR__ . "/../../partials/nav.php");
is_logged_in(true);
?>

<?php
function generateAPIQuote()
{
    $url = "https://andruxnet-random-famous-quotes.p.rapidapi.com/";
    $key = "API_KEY"; 
    try {
        $response = get($url, $key, ["cat" => "famous", "count" => 1], true, "andruxnet-random-famous-quotes.p.rapidapi.com");

        $apiData = json_decode($response["response"], true);

        if (isset($apiData[0]["quote"]) && isset($apiData[0]["author"])) {
            $quote = $apiData[0]["quote"];
            $author = $apiData[0]["author"];
            $db = getDB();

            $stmt = $db->prepare("INSERT INTO Quotes (quotes, author, API_Gen) VALUES (:quote, :author, 1)");
            $stmt->execute([
                ":quote" => $quote,
                ":author" => $author
            ]);
            flash("API data added successfully", "success");
        } else {
            flash("API response format is invalid", "danger");
        }
    } catch (Exception $e) {
        flash("Error fetching data from API", "danger");
    }

    // Redirects to the current page after adding the API quote
    header("Location: $_SERVER[PHP_SELF]");
    exit;
}

// Checks if the API Gen button is clicked
if (isset($_POST["generateAPIQuote"])) {
    generateAPIQuote();
}

// Retrieves the last API-generated entry from the database
$db = getDB();
$stmt = $db->prepare("SELECT id, quotes, author, API_Gen, created, modified FROM Quotes WHERE API_Gen = 1 ORDER BY id DESC LIMIT 1");
$stmt->execute();
$apiQuote = $stmt->fetch(PDO::FETCH_ASSOC);

if ($apiQuote !== false) {
    $quoteId = $apiQuote['id'];
    $quote = $apiQuote['quotes'];
    $author = $apiQuote['author'];
    $apiGen = $apiQuote['API_Gen'];
    $created = $apiQuote['created'];
    $modified = $apiQuote['modified'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>API-Gen Details</title>
    <style>
        input[type="submit"][name="generateAPIQuote"] {
            padding: 10px 20px; /* Extra button padding */
        }
    </style>
</head>

<body>
    <h2>API-Generated Quote Details</h2>
    <div class="details-box">
        <!-- Display API-generated quote details -->
        <div class="details-row">
            <span class="details-label">Quote ID:</span>
            <span class="details-value"><?php echo $quoteId; ?></span>
        </div>
        <div class="details-row">
            <span class="details-label">Quote:</span>
            <span class="details-value"><?php echo htmlspecialchars($quote); ?></span>
        </div>
        <div class="details-row">
            <span class="details-label">Author:</span>
            <span class="details-value"><?php echo htmlspecialchars($author); ?></span>
        </div>
        <div class="details-row">
            <span class="details-label">API?:</span>
            <span class="details-value"><?php echo ($apiGen === 1) ? 'Yes' : 'No'; ?></span>
        </div>
        <div class="details-row">
            <span class="details-label">Created:</span>
            <span class="details-value"><?php echo $created; ?></span>
        </div>
        <div class="details-row-modified">
            <span class="details-label">Modified:</span>
            <span class="details-value"><?php echo $modified; ?></span>
        </div>
    </div>
    <!-- Form to generate API quote -->
    <form method="POST">
        <input type="hidden" name="generateAPIQuote" value="1" />
        <input type="submit" value="API Gen" name="generateAPIQuote" />
    </form>
</body>

</html>

<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>