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

// Function to retrieve the data from Saved_Quotes table and insert data into the table
function saveQuote($userId, $savedQuoteId)
{
    $db = getDB();

    try {
        $stmt = $db->prepare("SELECT COUNT(*) FROM Saved_Quotes WHERE user_id = :user_id AND quote_id = :quote_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':quote_id', $savedQuoteId, PDO::PARAM_INT);
        $stmt->execute();
        $quoteAlreadySaved = $stmt->fetchColumn();

        if ($quoteAlreadySaved) {
            flash("You have already saved this quote.");
        } else {
            $stmt = $db->prepare("INSERT INTO Saved_Quotes (user_id, quote_id, quotes, author) 
                                  SELECT :user_id, id, quotes, author FROM Quotes WHERE id = :quote_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':quote_id', $savedQuoteId, PDO::PARAM_INT);
            $stmt->execute();

            flash("Quote successfully saved!", "success");
        }
    } catch (PDOException $e) {
        flash("An error occurred while saving the quote", "danger");
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

// Function searches names by the specified search term
function searchUsernames($searchTerm)
{
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

// Search for quotes by quote ID match
if (isset($_POST["quote_id"])) {
    $quoteId = se($_POST, "quote_id", "", false);
    if (!empty($quoteId)) {
        $quoteData = getQuoteData($quoteId);
    } else {
        flash("Quote ID must not be empty", "warning");
    }
}

// Handle the "Associate" button form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['associateQuotes'])) {
    $selectedUserIds = isset($_POST['users']) ? $_POST['users'] : [];
    $selectedQuoteIds = isset($_POST['quotes']) ? $_POST['quotes'] : [];

    if (empty($selectedUserIds) || empty($selectedQuoteIds)) {
        flash("Please select users and quotes to associate", "warning");
    } else {
        $db = getDB();

        try {
            foreach ($selectedUserIds as $userId) {
                foreach ($selectedQuoteIds as $quoteId) {
                    $stmt = $db->prepare("INSERT INTO Saved_Quotes (user_id, quote_id, quotes, author)
                                          SELECT :user_id, :quote_id, quotes, author FROM Quotes WHERE id = :quote_id");
                    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
                    $stmt->bindValue(':quote_id', $quoteId, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }

            flash("Quotes successfully associated with selected users!", "success");
        } catch (PDOException $e) {
            flash("An error occurred while associating the quotes", "danger");
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Entity Assoc.</title>
    <style>
        .quote-table {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Assign Roles</h1>
    <form method="POST">
        <label for="username">Username Search:</label>
        <input type="search" name="username" placeholder="Username search" />

        <label for="quote">Entity search (quote ID):</label>
        <input type="search" name="quote_id" placeholder="Quote ID search" />

        <input type="submit" value="Search" />
    </form>
    <form method="POST" action="">
        <?php if (isset($username) && !empty($username)) : ?>
            <input type="hidden" name="username" value="<?php se($username, false); ?>" />
        <?php endif; ?>
        <table style="width: 100%;">
            <colgroup>
                <col style="width: 100%;">
                <col style="width: 100%;">
            </colgroup>
            <thead>
                <thead>
                    <th class="col-users">Users</th>
                    <th class="col-quote">Quote</th>
                </thead>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <table class="inner-table">
                            <colgroup>
                                <col style="width: 70%;"> <!-- Adjust the width of the Users column -->
                                <col style="width: 80%;"> <!-- Adjust the width of the Quote column -->
                            </colgroup>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td>
                                        <input id="user_<?php se($user, 'id'); ?>" type="checkbox" name="users[]" value="<?php se($user, 'id'); ?>" />
                                        <label for="user_<?php se($user, 'id'); ?>"><?php se($user, "username"); ?></label>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                    <td>
                        <?php if (isset($quoteData)) : ?>
                            <table class="quote-table">
                                <tr>
                                    <td><input type="checkbox" name="quotes[]" value="<?= $quoteData['id'] ?>" /></td>
                                    <td><?= $quoteData['id'] ?></td>
                                    <td><?= $quoteData['quotes'] ?></td>
                                </tr>
                            </table>
                        <?php else : ?>
                            <!-- No quote data found or not searched yet -->
                            <p>No quote data found.</p>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="associateQuotes" value="Associate" />
    </form>
    <?php
    require_once(__DIR__ . "/../../../partials/flash.php");
    ?>