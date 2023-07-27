<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<?php
// Function to retrieve record details based on the ID
function getRecordDetails($id)
{
    $db = getDB();

    try {
        $stmt = $db->prepare("SELECT id, quotes, author, API_Gen, created, modified FROM Quotes WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $recordDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        return $recordDetails;
    } catch (PDOException $e) {
        flash("An error occurred while retrieving record details from the database", "danger");
        return null;
    }
}

// Check if the quote ID is provided in the URL
if (isset($_GET['quote_id'])) {
    $quoteId = (int)$_GET['quote_id'];

    // Get the record details based on the quote ID
    $recordDetails = getRecordDetails($quoteId);

    if ($recordDetails !== null) {
        $quote = $recordDetails['quotes'];
        $author = $recordDetails['author'];
        $apiGen = $recordDetails['API_Gen'];
        $created = $recordDetails['created'];
        $modified = $recordDetails['modified'];
    } else {
        flash("Record not found", "danger");
        // Redirect to the quotes list page if the record is not found
        header("Location: data_list.php");
        exit;
    }
} else {
    // Redirect to the quotes list page if the quote ID is not provided
    header("Location: data_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Record Details</title>
</head>

<body>
    <h2>Record Details</h2>

    <div>
        <p><strong>Quote ID:</strong> <?php echo $quoteId; ?></p>
        <p><strong>Quote:</strong> <?php echo htmlspecialchars($quote); ?></p>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($author); ?></p>
        <p><strong>API?:</strong> <?php echo ($apiGen === 1) ? 'Yes' : 'No'; ?></p>
        <p><strong>Created:</strong> <?php echo $created; ?></p>
        <p><strong>Modified:</strong> <?php echo $modified; ?></p>
    </div>

    <a href="data_list.php">Back to Quotes List</a>
</body>

</html>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>