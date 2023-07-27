<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<?php
/*
    UCID: sjc65
    Date: 07/27/2023
    Explanation: This block of code is what retrieves the data from the database and displays the information in a list based on 
    the ID of the record. (The ID of the record is determined by the page redirection logic of the HTML code in data_list.php).
*/
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

/*
    UCID: sjc65
    Date: 07/27/2023
    Explanation: In the block of code, if a quote ID is not retrieved, the code redirects them back to the data list page and alerts
    them of the issue. If a record is not found, the code redirects them back to the data list and alerts them that the record was
    not found. If the ID number exceeds the number of records in the database, the user is redirected back to the data list page
    and alerted that the record was not found.
*/
// Check if the quote ID is provided in the URL
if (isset($_GET['quote_id'])) {
    $quoteId = (int)$_GET['quote_id'];

    // Get the total number of records in the database
    $db = getDB();
    $stmt = $db->prepare("SELECT COUNT(*) AS total FROM Quotes");
    $stmt->execute();
    $totalRecords = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Check if the provided ID exceeds the total number of records
    if ($quoteId < 1 || $quoteId > $totalRecords) {
        flash("Record not found", "danger");
        // Redirect to the quotes list page if the record is not found
        header("Location: data_list.php");
        exit;
    }

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
    flash("Record ID not found", "warning");
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

    <?php if ($recordDetails !== null) : ?>
        <div class="details-box">
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
        <!-- Button to go back to the Quotes list -->
        <a href="data_list.php"><button>Back to Quotes List</button></a>

        <!-- Button to go to record edit page -->
        <a href="admin/edit_details.php?quote_id=<?php echo $quoteId; ?>"><button>Edit</button></a>

        <!-- Button to go to record delete page -->
        <a href="admin/delete_details.php?quote_id=<?php echo $quoteId; ?>"><button>Delete</button></a>
    <?php endif; ?>
</body>

</html>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>