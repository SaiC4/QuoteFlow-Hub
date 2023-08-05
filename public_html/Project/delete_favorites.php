<?php
require(__DIR__ . "/../../partials/nav.php");

if (is_logged_in(true)) {
    // Comment this out if you don't want to see the session variables
    error_log("Session data: " . var_export($_SESSION, true));
}
?>

<?php
if (!isset($_GET['saved_id']) || !ctype_digit($_GET['saved_id'])) {
    flash("Invalid request. Saved ID not specified", "danger");
    header("Location: " . get_url("favorites.php"));
    exit();
}

$savedId = (int)$_GET['saved_id'];

// Retrieve data from the Saved_Quotes table
$db = getDB();
try {
    $stmt = $db->prepare("SELECT sq.id AS saved_id, sq.user_id, sq.quote_id, q.quotes, q.author
                          FROM Saved_Quotes sq
                          INNER JOIN Quotes q ON sq.quote_id = q.id
                          WHERE sq.id = :savedId");
    $stmt->bindParam(":savedId", $savedId, PDO::PARAM_INT);
    $stmt->execute();
    $quoteData = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    flash("An error occurred while retrieving quote data", "danger");
}

// Handle the deletion process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDB();
    try {
        $stmt = $db->prepare("DELETE FROM Saved_Quotes WHERE id = :savedId");
        $stmt->bindParam(":savedId", $savedId, PDO::PARAM_INT);
        $stmt->execute();

        flash("Quote record successfully deleted", "success");
    } catch (PDOException $e) {
        flash("An error occurred while deleting the quote record", "danger");
    }

    header("Location: " . get_url("favorites.php"));
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Record Details</title>
</head>

<body>
    <h2>Delete Record?</h2>
    <h3>Are you sure you want to delete this record from favorites?</h3>

    <?php if ($savedId !== null) : ?>
        <!-- Form to confirm the deletion -->
        <form method="post">
            <!-- Hidden input to send the saved_id to the script -->
            <input type="hidden" name="saved_id" value="<?php echo $savedId; ?>">
            <!-- Button to confirm deletion -->
            <button type="submit">Delete</button>
        </form>
        <!-- Button to redirect back to favorites page -->
        <a href="<?php echo get_url('favorites.php'); ?>">
            <button type="button">Cancel</button>
        </a>
    <?php endif; ?>
</body>

</html>

<?php
require(__DIR__ . "/../../partials/flash.php");
?>