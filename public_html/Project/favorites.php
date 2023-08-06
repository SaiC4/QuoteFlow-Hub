<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<?php
/*
    UCID: sjc65
    Date: 08/05/2023
    Explanation: The purpose of the code is to display all the quotes the user has saved. The code creates a list, similar
    to the list in data_list.php, delete buttons for each record, and a refresh list button. First, a function is created
    to retrieve the ID, userID, quote, and author values from the "Saved_Quotes" table. Then another function is created
    to retrieve the ID, userID, quote, and author values from the "Quotes" table. Then, the records from the "Saved_Quotes" 
    table are displayed in a list with a delete button in each record to redirect the user to the delete page for the button's
    associated record. Lastly, the values from the "Quotes" table and "Saved_Quotes" table are compared to ensure that
    the values in "Saved_Quotes" table are updated to the latest information.
*/
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

// Function retrieves data from 'Quotes' database table
function getQuoteData($quote_id)
{
    $db = getDB();

    try {
        $query = "SELECT id, quotes, author FROM Quotes WHERE id = :quote_id";
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

$user_id = get_user_id();
$defaultLimit = 10;

if (isset($_GET['limit'])) {
    $limit = max(1, min(100, (int)$_GET['limit']));
} else {
    $limit = $defaultLimit;
}

// Call the function to get the total number of records in the "saved_quotes" table
$totalSavedQuotes = getTotalSavedQuotes($user_id);

// Call the function to get saved quotes data for the logged-in user
$savedQuotesData = getSavedQuotesData($user_id, $limit);

// Get the user's input for quote search and author search
$quoteSearchTerm = isset($_GET['quoteSearch']) ? trim($_GET['quoteSearch']) : null;
$authorSearchTerm = isset($_GET['authorSearch']) ? trim($_GET['authorSearch']) : null;

// Call the function to get saved quotes data for the logged-in user with the filter criteria
$savedQuotesData = getSavedQuotesDataWithFilter($user_id, $quoteSearchTerm, $authorSearchTerm, $limit);


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
            // Handle the update error if necessary
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

        // Add search conditions if search terms are provided
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
?>

<!DOCTYPE html>
<html>

<head>
    <title>Saved Quotes List</title>
    <style>

    </style>
</head>

<body>
    <h2>Saved Quotes List</h2>
    <style>
        /* Adjusts the margin for the total records header */
        h4 {
            margin-top: -6px; /* higher value = more gap. lower value = less gap */
        }
        /* Adjusts the margin on the bottom of the buttons container */
        .buttons-container {
            margin-bottom: -80px; /* higher value = more gap. lower value = less gap */
        }
    </style>
    <?php
    // Get the total number of saved records for the user
    $totalSavedRecords = count($savedQuotesData);
    ?>

    <form method="get" action="">
        <!-- Add input fields for quote search and author search -->
        <div class="search-bars">
            <label for="limit">Records Limit (1-100):</label>
            <input type="number" name="limit" id="limit" min="1" max="100" value="<?php echo $limit; ?>">
            
            <div class="separator"></div>
            
            <label for="quoteSearch">Quote Search:</label>
            <input type="text" name="quoteSearch" id="quoteSearch" placeholder="Enter search term">

            <div class="separator"></div>

            <label for="authorSearch">Author Search:</label>
            <input type="text" name="authorSearch" id="authorSearch" placeholder="Enter author name">

            <div class="separator"></div>

            <button type="submit">Search</button>
        </div>
    </form>

    <div class="record-info">
        <!-- Display the total number of records associated with logged-in user -->
        <h4>Records associated with User: <?php echo $totalSavedQuotes; ?></h4>

        <!-- Display the total number of records in the use-associated database -->
        <h4>Total Records Shown: <?php echo count($savedQuotesData); ?></h4>
    </div>
    
    <div class="table-container">
        <table>
            <tr>
                <th>Author</th>
                <th>Quotes</th>
                <th>Details</th>
                <th>Delete</th>
            </tr>
            <?php foreach ($savedQuotesData as $savedQuoteData) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($savedQuoteData['author']); ?></td>
                    <td><?php echo htmlspecialchars($savedQuoteData['quotes']); ?></td>
                    <td>
                        <!-- Button to redirect to this record's details page -->
                        <a href="view_details.php?quote_id=<?php echo $savedQuoteData['saved_id']; ?>">
                            <button>Details</button>
                        </a>
                    </td>
                    <td>
                        <!-- Button to redirect to this record's delete page -->
                        <a href="delete_favorites.php?saved_id=<?php echo $savedQuoteData['saved_id']; ?>">
                            <button>Delete</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class = "buttons-container">
        <!-- Button to refresh the page -->
        <button type="button" onclick="window.location.href = 'favorites.php';">Refresh List</button>
        <!-- Add a button to delete all saved quotes -->
        <button type="button" id="delete-all" onclick="deleteAllSavedQuotes();">Delete All Saved Quotes</button>
    </div>
</body>
<script>
function deleteAllSavedQuotes() {
    if (confirm("Are you sure you want to delete all saved quotes?")) {
        // Redirect to a PHP script to handle the deletion
        window.location.href = 'admin/delete_user_quotes_data.php';
    }
}
</script>
</html>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>