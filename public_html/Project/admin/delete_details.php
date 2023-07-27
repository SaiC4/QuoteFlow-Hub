<?php
require(__DIR__ . "/../../../partials/nav.php");

if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: " . get_url("home.php")));
}
?>
<!------------------------------Insert Your PHP Code below this:----------------------------------------->










<!------------------------------------------------------------------------------------------------------->
<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>
