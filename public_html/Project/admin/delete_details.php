<?php
require(__DIR__ . "/../../../partials/nav.php");
?>
<?php
if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: " . get_url("data_list.php")));
}
/*
    UCID: sjc65
    Date: 07/27/2023
    Explanation: This block of code handles the details retrieval from the record ID. The code retrieves the ID from the URL, 
    retrieves the number of records in the database for record ID validation, and fetches the quote details from the database
    based on the record ID.
*/
// Check if the quote ID is provided in the URL
if (!isset($_GET['quote_id']) || !ctype_digit($_GET['quote_id'])) {
    // Invalid or missing quote_id in the URL
    flash("Invalid request. Quote ID not specified", "danger");
    header("Location: " . get_url("data_list.php"));
    exit();
}

$quoteId = (int)$_GET['quote_id'];

// Retrieve the total number of records in the database
$db = getDB();
$stmt = $db->prepare("SELECT COUNT(*) AS total_records FROM Quotes");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$totalRecords = (int)$result['total_records'];

if ($quoteId <= 0 || $quoteId > $totalRecords) {
    // Invalid quote ID, out of range
    flash("Invalid quote ID", "danger");
    echo '<script>window.location.href = "' . get_url("data_list.php") . '";</script>';
    exit();
}

// Fetch the quote details from the database
$stmt = $db->prepare("SELECT id, quotes, author, API_Gen, created, modified FROM Quotes WHERE id = :quoteId");
$stmt->bindParam(":quoteId", $quoteId, PDO::PARAM_INT);
$stmt->execute();
$quoteData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$quoteData) {
    // If the record with the given ID doesn't exist, redirect to data_list.php
    flash("Quote record not found", "warning");
    header("Location: " . get_url("data_list.php"));
    exit();
}
/*
    UCID: sjc65
    Date: 07/27/2023
    Explanation: This code block handles the deletion process, it performs the deletion using SQL statements and then after that
    is executed, it redirects the user back to the data_list.php page and prompts them with a success alert. If for some reason the
    deletion does not succeed, the user is prompted with a message stating that an error occurred preventing the record from
    being deleted.
*/
// Handle the deletion process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Perform the deletion query
        $stmt = $db->prepare("DELETE FROM Quotes WHERE id = :quoteId");
        $stmt->bindParam(":quoteId", $quoteId, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to data_list.php with a success message
        flash("Quote record successfully deleted", "success");
        header("Location: " . get_url("data_list.php"));
        exit();
    } catch (PDOException $e) {
        // If an error occurs during deletion, display an error message
        flash("An error occurred while deleting the quote record", "danger");
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Record Details</title>
</head>
<!--
    UCID: sjc65
    Date: 07/27/2023
    Explanation: This block of code shows the HTML form for the deletion process. The main deletion process is triggered by the
    "Confirm Delete" button but the information above it simply display all the details of the current record.
-->
<body>
    <h2>Delete Quote Record?</h2>

    <?php if ($quoteData !== null) : ?>
        <div class="details-box">
            <div class="details-row">
                <span class="details-label">Quote ID:</span>
                <span class="details-value"><?php echo $quoteData['id']; ?></span>
            </div>
            <div class="details-row">
                <span class="details-label">Quote:</span>
                <span class="details-value"><?php echo htmlspecialchars($quoteData['quotes']); ?></span>
            </div>
            <div class="details-row">
                <span class="details-label">Author:</span>
                <span class="details-value"><?php echo htmlspecialchars($quoteData['author']); ?></span>
            </div>
            <div class="details-row">
                <span class="details-label">API?:</span>
                <span class="details-value"><?php echo ($quoteData['API_Gen'] === 1) ? 'Yes' : 'No'; ?></span>
            </div>
            <div class="details-row">
                <span class="details-label">Created:</span>
                <span class="details-value"><?php echo $quoteData['created']; ?></span>
            </div>
            <div class="details-row-modified">
                <span class="details-label">Modified:</span>
                <span class="details-value"><?php echo $quoteData['modified']; ?></span>
            </div>
        </div>

        <!-- Form to confirm the deletion or cancel deletion -->
        <form method="post">
            <!-- Button to confirm deletion -->
            <button type="submit">Confirm Delete</button>

            <!-- Button to cancel deletion -->
            <a href="<?php echo get_url('data_list.php'); ?>"><button type="button">Cancel</button></a>
        </form>
    <?php endif; ?>
</body>

</html>
<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>
