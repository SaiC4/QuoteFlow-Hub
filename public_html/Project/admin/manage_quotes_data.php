<?php
// Note we need to go up 1 more directory
require(__DIR__ . "/../../../partials/nav.php");

if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: " . get_url("home.php")));
}

function insert_quotes_into_db($db, $quote, $author)
{
    // Prepare SQL query
    $query = "INSERT INTO `quotes` (`quote`, `author`) VALUES (:quote, :author)";

    // Prepare the statement
    $stmt = $db->prepare($query);

    // Bind the parameters
    $stmt->bindValue(':quote', $quote, PDO::PARAM_STR);
    $stmt->bindValue(':author', $author, PDO::PARAM_STR);

    // Execute the statement
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        error_log(var_export($e, true));
    }
}

function process_single_quote($quote)
{
    // Extract quote data
    $quoteText = isset($quote["quote"]) ? $quote["quote"] : "";
    $author = isset($quote["author"]) ? $quote["author"] : "";

    // Prepare record
    $record = [];
    $record["quote"] = $quoteText;
    $record["author"] = $author;

    error_log("Quote Record: " . var_export($record, true));
    return $record;
}

function process_quotes($result)
{
    $status = se($result, "status", 400, false);
    if ($status != 200) {
        return;
    }

    // Extract data from result
    $quoteData = json_decode($result, true);

    // Process the quote
    $record = process_single_quote($quoteData);

    // Insert the quote into the database
    $db = getDB();
    insert_quotes_into_db($db, $record['quote'], $record['author']);
}

$action = se($_POST, "action", "", false);
if ($action) {
    switch ($action) {
        case "quotes":
            $result = get("https://andruxnet-random-famous-quotes.p.rapidapi.com/?cat=famous&count=1", "API_KEY", [], false);    //Insert correct endpoint link into the empty string ("")
            process_quotes($result);
            break;
    }
}
?>

<div class="container-fluid">
    <h1>Quote Data Management</h1>
    <div class="row">
        <div class="col">
            <!-- Quote refresh button -->
            <form method="POST">
                <input type="hidden" name="action" value="quotes" />
                <input type="submit" class="btn btn-primary" value="Refresh Quotes" />
            </form>
        </div>
    </div>
</div>