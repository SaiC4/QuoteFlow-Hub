<?php
session_start();    // Starts the session
session_unset();    // Clears out all the variables             /* Line 2 and 3 seem redundant but it's to make sure that the
session_destroy();  // Destroys/cleans it up from the server       session is completely wiped. */
header("Location: login.php");  // Redirects user to the login page
