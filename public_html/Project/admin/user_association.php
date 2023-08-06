<?php
require(__DIR__ . "/../../../partials/nav.php");
if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: " . get_url("home.php")));
}
?>
<?php
// Function retrieves data from 'saved_quotes' database table
function getSavedQuotesData($user_id, $limit = 10)
{
    $limit = max(1, min(100, (int)$limit));
    $db = getDB();

    try {
        $query = "SELECT sq.id AS saved_id, sq.user_id, sq.quote_id, q.quotes, q.author FROM Saved_Quotes sq
                  INNER JOIN Quotes q ON sq.quote_id = q.id
                  WHERE sq.user_id = :user_id LIMIT :limit";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $savedQuotesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $savedQuotesData;
    } catch (PDOException $e) {
        flash("An error occurred while retrieving data from the database", "danger");
        return [];
    }
}

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

// Function to get the user's name based on user ID
function getUserName($user_id)
{
    $db = getDB();

    try {
        $query = "SELECT username FROM Users WHERE id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['username'];
    } catch (PDOException $e) {
        return "Unknown User";
    }
}

// Retrieves session user ID
$user_id = get_user_id();
// Retrieves user name of the specified user ID
//$user_name = getUserName($user_id);
// Sets list default limit
$defaultLimit = 10;

// Sets list index default limit
if (isset($_GET['limit'])) {
    $limit = max(1, min(100, (int)$_GET['limit']));
} else {
    $limit = $defaultLimit;
}

// Call the function to get the total number of records in the "saved_quotes" table
$totalSavedQuotes = getTotalSavedQuotes($user_id);

// Call the function to get saved quotes data for the user
$savedQuotesData = getSavedQuotesData($user_id, $limit);

// Get the user's input for quote search and author search
//$nameSearchTerm = isset($_GET['nameSearch']) ? trim($_GET['nameSearch']) : null;  --> (Feature causes error)
$quoteSearchTerm = isset($_GET['quoteSearch']) ? trim($_GET['quoteSearch']) : null;
$authorSearchTerm = isset($_GET['authorSearch']) ? trim($_GET['authorSearch']) : null;

// Call the function to get saved quotes data for the logged-in user with the filter criteria
$savedQuotesData = getSavedQuotesDataWithFilter($user_id, $quoteSearchTerm, $authorSearchTerm, $limit); // Removed $nameSearchTerm --> (Feature causes error)


// Loop through the saved quotes data and update them with the latest info from the Quotes table
foreach ($savedQuotesData as $quoteData) {
    $quote_id = $quoteData['quote_id'];
    $quoteInfo = getQuoteData($quote_id);

    if ($quoteInfo) {
        $newQuote = $quoteInfo['quotes'];
        $newAuthor = $quoteInfo['author'];

        $db = getDB();
        try {
            $updateQuery = "UPDATE Saved_Quotes SET quotes = :newQuote, author = :newAuthor WHERE quote_id = :quote_id";
            $stmt = $db->prepare($updateQuery);
            $stmt->bindParam(':newQuote', $newQuote, PDO::PARAM_STR);
            $stmt->bindParam(':newAuthor', $newAuthor, PDO::PARAM_STR);
            $stmt->bindParam(':quote_id', $quote_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            flash("An error occurred while updating the saved quotes", "danger");
        }
    }
}

// Filter/Sort function
function getSavedQuotesDataWithFilter($user_id, $quoteSearchTerm = null, $authorSearchTerm = null, $limit = 10)
{
    $limit = max(1, min(100, (int)$limit));
    $db = getDB();

    try {
        $query = "SELECT sq.id AS saved_id, sq.user_id, sq.quote_id, q.quotes, q.author FROM Saved_Quotes sq
                  INNER JOIN Quotes q ON sq.quote_id = q.id
                  WHERE sq.user_id = :user_id";

        /*// Search conditions if search terms are provided---> (Feature causes error)
        if ($nameSearchTerm !== null) {
            $query .= " AND u.username LIKE :nameSearchTerm";
        } */

        if ($quoteSearchTerm !== null) {
            $query .= " AND q.quotes LIKE :quoteSearchTerm";
        }

        if ($authorSearchTerm !== null) {
            $query .= " AND q.author LIKE :authorSearchTerm";
        }

        $query .= " LIMIT :limit";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

        /*if ($nameSearchTerm !== null) {   --> (Feature causes error)
            $nameSearchTerm = "%" . $nameSearchTerm . "%";
            $stmt->bindParam(':nameSearchTerm', $nameSearchTerm, PDO::PARAM_STR);
        }*/

        if ($quoteSearchTerm !== null) {
            $quoteSearchTerm = "%" . $quoteSearchTerm . "%";
            $stmt->bindParam(':quoteSearchTerm', $quoteSearchTerm, PDO::PARAM_STR);
        }

        if ($authorSearchTerm !== null) {
            $authorSearchTerm = "%" . $authorSearchTerm . "%";
            $stmt->bindParam(':authorSearchTerm', $authorSearchTerm, PDO::PARAM_STR);
        }

        $stmt->execute();
        $savedQuotesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // If no matching records are found
        if (empty($savedQuotesData)) {
            flash("No matches found", "info");
        }

        return $savedQuotesData;
    } catch (PDOException $e) {
        flash("An error occurred while retrieving data from the database", "danger");
    }
}

// Function to get the total number of saved quotes for a user
function getTotalSavedQuotes($user_id)
{
    $db = getDB();

    try {
        $query = "SELECT COUNT(*) AS total_saved_quotes FROM Saved_Quotes WHERE user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)$result['total_saved_quotes'];
    } catch (PDOException $e) {
        flash("An error occurred while retrieving total saved quotes count", "danger");
        return 0;
    }
}

// Function to count the number of unique users associated with a quote
function countUniqueUsers($quote_id)
{
    $db = getDB();

    try {
        $query = "SELECT COUNT(DISTINCT user_id) AS unique_users FROM Saved_Quotes WHERE quote_id = :quote_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':quote_id', $quote_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)$result['unique_users'];
    } catch (PDOException $e) {
        return 0;
    }
}

// Function to count the number of non-API records
function countNonApiRecords($savedQuotesData)
{
    $nonApiCount = 0;
    foreach ($savedQuotesData as $savedQuoteData) {
        $quote_id = $savedQuoteData['quote_id'];
        $quoteInfo = getQuoteData($quote_id);
        $api_gen = $quoteInfo['API_Gen'];
        if ($api_gen !== 1) {
            $nonApiCount++;
        }
    }
    return $nonApiCount;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>All User Assoc.</title>
    <style>

    </style>
</head>

<body>
    <h2>All User Associations</h2>
    <style>
        /* Adjusts the margin for the total records header */
        h4 {
            margin-top: -6px;
            /* higher value = more gap. lower value = less gap */
        }

        /* Adjusts the margin on the bottom of the buttons container */
        .buttons-container {
            margin-bottom: -80px;
            /* higher value = more gap. lower value = less gap */
        }
    </style>
    <?php
    // Gets the total number of saved records for the user
    $totalSavedRecords = count($savedQuotesData);

    // Gets the total number of records not associated to an API
    $userAssociatedRecords = $totalSavedQuotes - countNonApiRecords($savedQuotesData) - 1; //"-1" because there is a number order issue in the database
    ?>

    <form method="get" action="">
        <div class="search-bars">
            <label for="nameSearch">Name Search:</label>
            <input type="text" name="nameSearch" id="nameSearch" placeholder="Enter name term">

            <div class="separator"></div> <!-- Vertical black line separator -->

            <label for="quoteSearch">Quote Search:</label>
            <input type="text" name="quoteSearch" id="quoteSearch" placeholder="Enter quote term">

            <div class="separator"></div> <!-- Vertical black line separator -->

            <label for="authorSearch">Author Search:</label>
            <input type="text" name="authorSearch" id="authorSearch" placeholder="Enter author term">

            <div class="separator"></div> <!-- Vertical black line separator -->

            <label for="limit">Records Limit (1-100):</label>
            <input type="number" name="limit" id="limit" min="1" max="100" value="<?php echo $limit; ?>">

            <div class="separator"></div> <!-- Vertical black line separator -->

            <button type="submit">Search</button>
        </div>
    </form>

    <div class="record-info">
        <!-- Display the total number of records associated with user -->
        <h4>Records associated with User: <?php echo $userAssociatedRecords; ?></h4>

        <!-- Display the total number of records in the use-associated database -->
        <h4>Total Records Shown: <?php echo count($savedQuotesData); ?></h4>
    </div>

    <div class="table-container">
        <table>
            <tr>
                <th>User</th>
                <th>Quotes</th>
                <th>Author</th>
                <th>User Count</th>
                <th>Details</th>
                <th>Delete</th>
            </tr>
            <?php foreach ($savedQuotesData as $savedQuoteData) : ?>
                <?php
                // Retrieve the user ID associated with the current saved quotes
                $quote_user_id = $savedQuoteData['user_id'];

                // Retrieve the API gen value from the quote data
                $quote_info = getQuoteData($quote_id);
                $api_gen = $quote_info['API_Gen'];

                // If the record was created by the API, use *API* for the user name
                if ($api_gen === 1) {
                    $quote_user_name = "*API*";
                } else {
                    // Retrieve the user name associated with the current saved quote user ID
                    $quote_user_name = getUserName($quote_user_id);
                }

                // Retrieve the total number of unique users associated with this quote
                $quote_id = $savedQuoteData['quote_id'];
                $unique_users_count = countUniqueUsers($quote_id);
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($quote_user_name); ?></td>
                    <td><?php echo htmlspecialchars($savedQuoteData['quotes']); ?></td>
                    <td><?php echo htmlspecialchars($savedQuoteData['author']); ?></td>
                    <td><?php echo $unique_users_count; ?></td>
                    <td>
                        <!-- Redirects user to view_details.php -->
                        <a href="<?php echo get_url("view_details.php?quote_id=" . $savedQuoteData['saved_id']); ?>">
                            <button>Details</button>
                        </a>
                    </td>
                    <td>
                        <a href="delete_assoc.php?saved_id=<?php echo $savedQuoteData['saved_id']; ?>">
                            <button>Delete</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="buttons-container">
        <!-- Button to refresh the page -->
        <button type="button" onclick="window.location.href = 'user_association.php';">Refresh List</button>
        <!-- Button to delete all saved quotes -->
        <button type="button" id="delete-all" onclick="deleteAllSavedQuotes();">Delete All Saved Quotes</button>
    </div>
</body>
<script>
    // Function that calls a different php page (Change the SQL statement for deletion process)
    function deleteAllSavedQuotes() {
        if (confirm("Are you sure you want to delete all saved quotes?")) {
            window.location.href = 'admin/delete_user_quotes_data.php';
        }
    }
    // Function to go back to previous page
    function goBack() {
        window.history.back();
    }
</script>

</html>
<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>