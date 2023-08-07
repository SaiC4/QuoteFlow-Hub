<?php
require(__DIR__ . "/../../../partials/nav.php");
if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: " . get_url("home.php")));
}
?>
<?php
// Function retrieves Record ID, Quote, Author, and API_Gen data from 'Quotes' database table
function getQuoteData($quote_id)
{
    $db = getDB();

    try {
        $query = "SELECT id, quotes, author, API_Gen FROM Quotes WHERE id = :quote_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':quote_id', $quote_id, PDO::PARAM_INT);
        $stmt->execute();
        $quoteData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $quoteData;
    } catch (PDOException $e) {
        flash("An error occurred while retrieving quote data from the database", "danger");
        return null;
    }
}

// Function to get the user's name based on username
function getUsersByUsernamePartialMatch($searchTerm)
{
    $db = getDB();
    $stmt = $db->prepare("SELECT id, username, (SELECT GROUP_CONCAT(name, ' (' , IF(ur.is_active = 1,'active','inactive') , ')') from 
    UserRoles ur JOIN Roles on ur.role_id = Roles.id WHERE ur.user_id = Users.id) as roles
    from Users WHERE username like :username");
    try {
        $stmt->execute([":username" => "%$searchTerm%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } catch (PDOException $e) {
        flash(var_export($e->errorInfo, true), "danger");
        return [];
    }
}

function searchUsernames($searchTerm)
{
    $db = getDB();

    $db = getDB();

    try {
        $query = "SELECT username FROM Users WHERE username LIKE :searchTerm";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        $matchedUsernames = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $matchedUsernames;
    } catch (PDOException $e) {
        flash("An error occurred while searching for usernames", "danger");
        return [];
    }
}

// Search for users by username partial match
$users = [];
if (isset($_POST["username"])) {
    $username = se($_POST, "username", "", false);
    if (!empty($username)) {
        $users = getUsersByUsernamePartialMatch($username);
    } else {
        flash("Username must not be empty", "warning");
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Entity Assoc.</title>
</head>

<body>
    <form method="post" action="">
        <label for="entity">Entity Identifier (Quote ID):</label>
        <input type="number" id="entity" name="entity">
        <br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" list="usernames">
        <datalist id="usernames">
            <?php
            if (isset($matchedUsernames)) {
                foreach ($matchedUsernames as $username) {
                    echo "<option value='$username'>$username</option>";
                }
            }
            ?>
        </datalist>
        <br><br>

        <div class="buttons-container">
            <button type="submit">Search</button>
        </div>
    </form>

    <?php if (isset($quoteData)) : ?>
        <p>Quote ID: <?= $quoteData['id'] ?></p>
        <p>Quote: <?= $quoteData['quotes'] ?></p>
        <p>Author: <?= $quoteData['author'] ?></p>
        <p>API Gen: <?= $quoteData['API_Gen'] ?></p>
    <?php endif; ?>

    <?php foreach ($users as $user) : ?>
    <tr>
        <td>
            <label for="user_<?php se($user, 'id'); ?>"><?php se($user, "username"); ?></label>
            <input id="user_<?php se($user, 'id'); ?>" type="checkbox" name="users[]" value="<?php se($user, 'id'); ?>" />
        </td>
        <td><?php se($user, "roles", "No Roles"); ?></td>
    </tr>
<?php endforeach; ?>

</body>

</html>
<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>