<?php
session_start();    // Starts the session
session_unset();    // Clears out all the variables             /* Line 2 and 3 seem redundant but it's to make sure that the
session_destroy();  // Destroys/cleans it up from the server       session is completely wiped. */
session_start();
//don't require flash.php, this will cause messages
//to not appear on login and be hidden by the logout transition
require(__DIR__ . "/../../lib/functions.php");
flash("Successfully logged out", "success");
header("Location: login.php");  // Redirects user to the login page
