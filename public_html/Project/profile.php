<?php
require_once(__DIR__ . "/../../partials/nav.php");
is_logged_in(true);
?>

<?php
// Function to fetch API data and upload to Quotes table
function generateAPIQuote()
{
    $url = "https://andruxnet-random-famous-quotes.p.rapidapi.com/"; // Replace with the actual API endpoint URL
    $key = "API_KEY";
    try {
        // Send a GET request to the API endpoint
        $response = get($url, $key, ["cat" => "famous", "count" => 1], true, "andruxnet-random-famous-quotes.p.rapidapi.com");

        // Parse the API response JSON data
        $apiData = json_decode($response["response"], true);

        // Check if the API response contains the required data (quote and author)
        if (isset($apiData[0]["quote"]) && isset($apiData[0]["author"])) {
            $quote = $apiData[0]["quote"];
            $author = $apiData[0]["author"];

            // Insert the API data into the Quotes table with API_gen set to true
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO Quotes (quotes, author, API_Gen) VALUES (:quote, :author, 1)");
            $stmt->execute([
                ":quote" => $quote,
                ":author" => $author
            ]);
            flash("API data added successfully", "success");
        } else {
            flash("API response format is invalid", "danger");
        }
    } catch (Exception $e) {
        flash("Error fetching data from API", "danger");
    }
}
?>


<?php
if (isset($_POST["generateAPIQuote"])) {
    generateAPIQuote(); // Call the function to retrieve API data and upload it to the database
} else if (isset($_POST["save"])) {
    $email = se($_POST, "email", null, false);
    $username = se($_POST, "username", null, false);
    $hasError = false;
    //sanitize
    $email = sanitize_email($email);
    //validate
    if (!is_valid_email($email)) {
        flash("Invalid email address", "danger");
        $hasError = true;
    }
    if (!is_valid_username($username)) {
        flash("Username must only contain 3-16 characters, a-z, 0-9, _, or -", "danger");
        $hasError = true;
    }
    if (!$hasError) {
        $params = [":email" => $email, ":username" => $username, ":id" => get_user_id()];
        $db = getDB();
        $stmt = $db->prepare("UPDATE Users set email = :email, username = :username where id = :id");
        try {
            $stmt->execute($params);
            flash("Profile saved", "success");
        } catch (PDOException $e) {
            users_check_duplicate($e->errorInfo);
        }
        //select fresh data from table
        $stmt = $db->prepare("SELECT id, email, username from Users where id = :id LIMIT 1");
        try {
            $stmt->execute([":id" => get_user_id()]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                //$_SESSION["user"] = $user;
                $_SESSION["user"]["email"] = $user["email"];
                $_SESSION["user"]["username"] = $user["username"];
            } else {
                flash("User doesn't exist", "danger");
            }
        } catch (Exception $e) {
            flash("An unexpected error occurred, please try again", "danger");
            //echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
        }
    }
//-------------------------------------------------------

 // Additional code for inserting quote and author into the Quotes table
 $quote = se($_POST, "quote", null, false);
 $author = se($_POST, "author", null, false);

if(empty($quote) || empty($author)) {
    flash("Quote or Author fields cannot be empty");
} else if(!empty($author) && strlen($quote) < 3) {
    flash("Quote field must contain at least 3 characters");
} else if (!empty($quote) && !empty($author) && strlen($quote) > 2) {
    // Insert the quote and author into the Quotes table
    $db = getDB();
    $stmt = $db->prepare("SELECT id, quotes, author FROM Quotes WHERE quotes = :quote AND author = :author");
    $stmt->execute([
        ":quote" => $quote,
        ":author" => $author
    ]);
    $existingQuote = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingQuote) {
        // Alert the user about the duplicate quote
        flash("This quote already exists in the database", "warning");
    } else {
        $stmt = $db->prepare("INSERT INTO Quotes (quotes, author) VALUES (:quote, :author)");
        try {
            $stmt->execute([
                ":quote" => $quote,
                ":author" => $author,
            ]);
            flash("Quote added successfully", "success");
        } catch (PDOException $e) {
            flash("An error occurred while adding the quote", "danger");
        }
    }
}
//-------------------------------------------------------
    //check/update password
    $current_password = se($_POST, "currentPassword", null, false);
    $new_password = se($_POST, "newPassword", null, false);
    $confirm_password = se($_POST, "confirmPassword", null, false);
    if (!empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
        $hasError = false;
        if (!is_valid_password($new_password)) {
            flash("Password too short", "danger");
            $hasError = true;
        }
        if (!$hasError) {
            if ($new_password === $confirm_password) {
                //TODO validate current
                $stmt = $db->prepare("SELECT password from Users where id = :id");
                try {
                    $stmt->execute([":id" => get_user_id()]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (isset($result["password"])) {
                        if (password_verify($current_password, $result["password"])) {
                            $query = "UPDATE Users set password = :password where id = :id";
                            $stmt = $db->prepare($query);
                            $stmt->execute([
                                ":id" => get_user_id(),
                                ":password" => password_hash($new_password, PASSWORD_BCRYPT)
                            ]);

                            flash("Password reset", "success");
                        } else {
                            flash("Current password is invalid", "warning");
                        }
                    }
                } catch (PDOException $e) {
                    echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
                }
            } else {
                flash("New passwords don't match", "warning");
            }
        }
    }
}
?>

<?php
$email = get_user_email();
$username = get_username();
?>
<form method="POST" onsubmit="return validate(this);">
    <div class="mb-3">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php se($email); ?>" />
    </div>
    <div class="mb-3">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php se($username); ?>" />
    </div>
    <!-- DO NOT PRELOAD PASSWORD -->
    <div>Password Reset</div>
    <div class="mb-3">
        <label for="cp">Current Password</label>
        <input type="password" name="currentPassword" id="cp" />
    </div>
    <div class="mb-3">
        <label for="np">New Password</label>
        <input type="password" name="newPassword" id="np" />
    </div>
    <div class="mb-3">
        <label for="conp">Confirm Password</label>
        <input type="password" name="confirmPassword" id="conp" />
    </div>
<!-- fields for quote and author -->
<div class="mb-3">
        <label for="quote">Quote</label>
        <input type="text" name="quote" id="quote"/>
    </div>
    <div class="mb-3">
        <label for="author">Author</label>
        <input type="text" name="author" id="author" />
    </div>
    <!-- <input type="hidden" name="generateAPIQuote" value="1" /> -->
    <input type="submit" value = "API Gen" name="generateAPIQuote" />
    <input type="submit" value="Update Profile" name="save" />
</form>

<script>
    function validate(form) {
        let pw = form.newPassword.value;
        let con = form.confirmPassword.value;
        let isValid = true;
        //TODO add other client side validation....
        let email = form.email.value.trim();
        let username = form.username.value.trim();
        let password = form.password.value.trim();
        let quote = form.quote.value.trim();
        let author = form.author.value.trim();

        if (!/^[a-z0-9_-]{3,16}$/.test(username)) {
            flash("Invalid username format");
            isValid = false;
        }
        
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            flash("Invalid email format");
            isValid = false;
        }
        
        if (password.length < 8) {
            flash("Password must be at least 8 characters long");
            isValid = false;
        }

        if (quote.length < 3) {
            flash("Quote must be at least 3 characters long", "danger");
            isValid = false;
        }

        if (quote.length > 3 && author === "") {
            flash("Author field cannot be empty", "danger");
            isValid = false;
        }

        //example of using flash via javascript
        //find the flash container, create a new element, appendChild
        if (pw !== con) {
            flash("Password and Confrim password must match", "warning");
            isValid = false;
        }
        return isValid;
    }
</script>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>