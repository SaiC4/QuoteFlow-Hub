<?php
require(__DIR__ . "/../../partials/nav.php");

if (is_logged_in(true)) {
    //comment this out if you don't want to see the session variables
    error_log("Session data: " . var_export($_SESSION, true));
}
?>
<?php
// Function to retrieve data from the Quotes table
function getQuotesData($quoteId)
{
    $db = getDB();
    
    try {
        $stmt = $db->prepare("SELECT id, quotes, author FROM Quotes WHERE id = :quoteId");
        $stmt->bindParam(':quoteId', $quoteId, PDO::PARAM_INT);
        $stmt->execute();
        $quoteData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $quoteData;
    } catch (PDOException $e) {
        flash("An error occurred while retrieving data from the database", "danger");
        return [];
    }
}

$quoteId = isset($_GET['quoteId']) ? (int)$_GET['quoteId'] : 1;
$quoteData = getQuotesData($quoteId);

$prevQuoteId = max(1, $quoteId - 1);
$nextQuoteId = $quoteId + 1; // Assuming it's the next sequential ID

// Retrieve the current logged-in user's user ID, email, and username
$userId = get_user_id();
$userEmail = get_user_email();
$username = get_username();

// Handle the Save Quote form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveQuote'])) {
    $savedQuoteId = (int)$_POST['saveQuote'];

    // Check if the user has already saved the same quote
    $db = getDB();
    try {
        $stmt = $db->prepare("SELECT COUNT(*) FROM Saved_Quotes WHERE user_id = :user_id AND quote_id = :quote_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':quote_id', $savedQuoteId, PDO::PARAM_INT);
        $stmt->execute();
        $quoteAlreadySaved = $stmt->fetchColumn();

        if ($quoteAlreadySaved) {
            flash("You have already saved this quote.");
        } else {
            // Insert the saved quote into the Saved_Quotes table
            $stmt = $db->prepare("INSERT INTO Saved_Quotes (user_id, quote_id, quotes, author) 
                                  SELECT :user_id, id, quotes, author FROM Quotes WHERE id = :quote_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':quote_id', $savedQuoteId, PDO::PARAM_INT);
            $stmt->execute();

            flash("Quote successfully saved!", "success");
        }
    } catch (PDOException $e) {
        flash("An error occurred while saving the quote", "danger");
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <h1>Home</h1>
    <title>Home</title>
    <style>
        body {
            text-align: center;
        }
        .quote-container {
            margin: 100px auto;
            max-width: 600px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
       
    .quote-buttons {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

    .quote-buttons form {
        margin: 0 10px;
    }
</style>
</head>

<body>
    <h2>Quote Viewer</h2>

    <div class="quote-container">
        <p><?php echo htmlspecialchars($quoteData['quotes']); ?></p>
        <p>- <?php echo htmlspecialchars($quoteData['author']); ?></p>
    </div>

    <div class="quote-buttons">
        <a href="home.php?quoteId=<?php echo $prevQuoteId; ?>"><button>Previous Quote</button></a>
        <form method="post" action="">
            <input type="hidden" name="saveQuote" value="<?php echo $quoteId; ?>">
            <button type="submit">Save Quote</button>
        </form>
        <a href="home.php?quoteId=<?php echo $nextQuoteId; ?>"><button>Next Quote</button></a>
    </div>
</body>

</html>

<?php
require(__DIR__ . "/../../partials/flash.php");
?>