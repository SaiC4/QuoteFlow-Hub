<?php
//Note: this is to resolve cookie issues with port numbers
$domain = $_SERVER["HTTP_HOST"];
if (strpos($domain, ":")) {
    $domain = explode(":", $domain)[0];
}
$localWorks = false; //some people have issues with localhost for the cookie params
//if you're one of those people make this false

//this is an extra condition added to "resolve" the localhost issue for the session cookie
if (($localWorks && $domain == "localhost") || $domain != "localhost") {
    session_set_cookie_params([
        "lifetime" => 60 * 60,
        "path" => "/Project",
        //"domain" => $_SERVER["HTTP_HOST"] || "localhost",
        "domain" => $domain,
        "secure" => true,
        "httponly" => true,
        "samesite" => "lax"
    ]);
}
session_start();
require_once(__DIR__ . "/../lib/functions.php");

?>
<!-- This is conditional HTML, it uses conditions that determine if something is displayed based on if-else statements-->
<nav>
    <ul>
        <?php if (is_logged_in()) : ?>      <!-- Checks if that function returns true or false. The ":" pauses for next line. -->
            <li><a href="home.php">Home</a></li>    <!-- Displays if the condition is true -->
        <?php endif; ?>     <!-- closes the if-statement -->
        <?php if (!is_logged_in()) : ?>     <!-- checks if the function returns true or false. The ":" pauses for next line -->
            <li><a href="login.php">Login</a></li>      <!-- displays the "login" and "register" links if user is not logged in -->
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>     <!-- closes the if-statement -->
        <?php if (is_logged_in()) : ?>      <!-- Checks if the function returns true -->
            <li><a href="logout.php">Logout</a></li>    <!-- Displays if condition is true -->
        <?php endif; ?>     <!-- closes the if-statement -->
    </ul>
</nav>