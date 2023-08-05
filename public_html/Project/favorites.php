<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<?php
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

$user_id = get_user_id();
$defaultLimit = 10;

if (isset($_GET['limit'])) {
    $limit = max(1, min(100, (int)$_GET['limit']));
} else {
    $limit = $defaultLimit;
}

// Call the function to get saved quotes data for the logged-in user
$savedQuotesData = getSavedQuotesData($user_id, $limit);

// Loops through the retrieved data and assigns them to variables
foreach ($savedQuotesData as $quoteData) {
    $saved_id = $quoteData['saved_id'];
    $user_id = $quoteData['user_id'];
    $quote_id = $quoteData['quote_id'];
    $quote = $quoteData['quotes'];
    $author = $quoteData['author'];
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

    <form method="get" action="">
        <label for="limit">Records Limit (1-100):</label>
        <input type="number" name="limit" id="limit" min="1" max="100" value="<?php echo $limit; ?>">
        <button type="submit">Show</button>
    </form>

    <div class="table-container">
        <table>
            <tr>
                <th>Quotes</th>
                <th>Author</th>
                <th>Delete</th>
            </tr>
            <?php foreach ($savedQuotesData as $savedQuoteData) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($savedQuoteData['quotes']); ?></td>
                    <td><?php echo htmlspecialchars($savedQuoteData['author']); ?></td>
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
</body>

</html>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>