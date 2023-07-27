<?php
require(__DIR__ . "/../../../partials/nav.php");

if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: " . get_url("data_list.php")));
}
?>
<?php
// Check if the quote ID is provided in the URL
if (isset($_GET['quote_id'])) {
    $quoteId = (int)$_GET['quote_id'];

    // Function to retrieve record details based on the ID
    function getRecordDetails($id)
    {
        $db = getDB();

        try {
            $stmt = $db->prepare("SELECT id, quotes, author FROM Quotes WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $recordDetails = $stmt->fetch(PDO::FETCH_ASSOC);

            return $recordDetails;
        } catch (PDOException $e) {
            flash("An error occurred while retrieving record details from the database", "danger");
            return null;
        }
    }

    // Get the record details based on the quote ID
    $recordDetails = getRecordDetails($quoteId);

    if ($recordDetails !== null) {
        $quote = $recordDetails['quotes'];
        $author = $recordDetails['author'];
    } else {
        flash("Record not found", "danger");
        // Redirect to the quotes list page if the record is not found
        header("Location: " . get_url("data_list.php"));
        exit;
    }
} else {
    flash("Record ID not found", "warning");
    // Redirect to the quotes list page if the quote ID is not provided
    header("Location: " . get_url("data_list.php"));
    exit;
}

// Handle the form submission
if (isset($_POST['update'])) {
    $newQuote = trim($_POST['quote']);
    $newAuthor = trim($_POST['author']);

    // Validate the input fields
    if (empty($newQuote) || empty($newAuthor)) {
        flash("Quote and Author fields cannot be empty", "danger");
    } else {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Quotes SET quotes = :quote, author = :author WHERE id = :id");
        try {
            $stmt->execute([
                ":quote" => $newQuote,
                ":author" => $newAuthor,
                ":id" => $quoteId
            ]);
            flash("Record successfully updated", "success");
        } catch (PDOException $e) {
            flash("An error occurred while updating the quote", "warning");
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Quote</title>
</head>

<body>
    <h2>Edit Quote</h2>
    <form method="POST">
        <div>
            <label for="quote">Quote:</label>
            <input type="text" name="quote" id="quote" value="<?php echo htmlspecialchars($quote); ?>" />
        </div>
        <div>
            <label for="author">Author:</label>
            <input type="text" name="author" id="author" value="<?php echo htmlspecialchars($author); ?>" />
        </div>
        <input type="submit" name="update" value="Update" />
    </form>
    <a href="<?php echo get_url("data_list.php"); ?>">Back to Quotes List</a>
</body>

</html>
<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>
