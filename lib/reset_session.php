<?php
function reset_session()
{
    session_unset();    // Clears out all the variables             /* Line 2 and 3 seem redundant but it's to make sure that the
    session_destroy();  // Destroys/cleans it up from the server       session is completely wiped. */
    session_start();    // Starts the session
}