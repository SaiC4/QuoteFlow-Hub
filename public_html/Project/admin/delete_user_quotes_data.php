<?php
require(__DIR__ . "/../../../partials/nav.php");
if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: " . get_url("favorites.php")));
}
?>
<?php
// Call database
$db = getDB();

// Delete all data associated with current user ID
try {
    $truncateQuery = "TRUNCATE TABLE Saved_Quotes";
    $stmt = $db->prepare($truncateQuery);
    $stmt->execute();

    flash("All saved quotes have been deleted successfully.", "success");
} catch (PDOException $e) {
    flash("An error occurred while deleting saved quotes.", "danger");
}

// Redirect back to the main page
header("Location: " . get_url("favorites.php"));
exit();
?>
<?php
require(__DIR__ . "/../../../partials/flash.php");
?>