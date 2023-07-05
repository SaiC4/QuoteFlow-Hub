<?php
require(__DIR__ . "/../../lib/functions.php");
?>
<form onsubmit="return validate(this)" method="POST">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" required />
    </div>
    <div>
        <label for="pw">Password</label>
        <input type="password" id="pw" name="password" required minlength="8" />
    </div>
    <div>
        <label for="confirm">Confirm</label>
        <input type="password" name="confirm" required minlength="8" />
    </div>
    <input type="submit" value="Register" />
</form>
<script>
    function validate(form) {
        //TODO 1: implement JavaScript validation
        //ensure it returns false for an error and true for success

        return true;
    }
</script>
<?php
//TODO 2: add PHP Code
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm"])) {
    $email = se($_POST, "email", "", false);
    $password = se($_POST, "password", "", false);
    $confirm = se($_POST, "confirm", "", false);
    $hasError = false;
    if (empty($email)) {
        echo "Email must not be empty";
        $hasError = true;
    }
    //Sanitize
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    //Validate
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email";
        $hasError = true;
    }
    if (empty($password)) {
        echo "Password must not be empty";
        $hasError = true;
    }
    if (empty($confirm)) {
        echo "Confirm Password must not be empty";
        $hasError = true;
    }
    if (strlen($password) < 8) {
        echo "Password must be >8 characters";
        $hasError = true;
    }
    if (strlen($password) > 0 && $password !== $confirm) {
        echo "Passwords must match";
        $hasError = true;
    }
    if (!$hasError) {
        //TODO 4
        //echo "Welcome, $email";
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Users (email, password) VALUES(:email, :password)");
        try {
            $stmt->execute([":email" => $email, ":password" => $hash]);
            echo "Successfully registered!";
        } catch (Exception $e) {
            echo "There was a problem registering";
            echo "<pre>" . var_export($e, true) . "</pre>";
        }
    }
}
?>

<!-- Data sanitization is a built-in feature for PHP and is used to remove illegal characters from the usual data types in the input,
like characters from number input, to validate the inputs better. This makes data validation easier without having to create a bunch
of if-else statements for validation instead. 

This W3Schools link shows the various sanitization commands and their purpose:
https://www.w3schools.com/php/php_ref_filter.asp -->