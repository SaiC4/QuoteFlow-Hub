<?php
require(__DIR__ . "/../../partials/nav.php");

if (is_logged_in(true)) {
    //comment this out if you don't want to see the session variables
    error_log("Session data: " . var_export($_SESSION, true));
}
?>
<?php
if (!isset($_GET['record_id']) || !ctype_digit($_GET['record_id'])) {
    flash("Invalid request. Record ID not specified", "danger");
    header("Location: " . get_url("favorites.php"));
    exit();
}

$recordId = (int)$_GET['record_id'];

$db = getDB();

// Handle the deletion process

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $savedId = (int)$_GET['id'];

    $db = getDB();
    try {
        $stmt = $db->prepare("DELETE FROM Saved_Quotes WHERE id = :savedId");
        $stmt->bindParam(":savedId", $savedId, PDO::PARAM_INT);
        $stmt->execute();

        flash("Quote record successfully deleted", "success");
    } catch (PDOException $e) {
        flash("An error occurred while deleting the quote record", "danger");
    }
}

header("Location: " . get_url("favorites.php"));
exit();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Record Details</title>
</head>

<body>
    <h2>Delete Record?</h2>

    <?php if ($recordId !== null) : ?>
        <p>Are you sure you want to delete this record?</p>

        <!-- Form to confirm the deletion -->
        <form method="post">
            <!-- Button to confirm deletion -->
            <button type="submit">Delete</button>
        </form>
    <?php endif; ?>
</body>

</html>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>