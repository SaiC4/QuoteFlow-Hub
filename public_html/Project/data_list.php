<?php
require_once(__DIR__ . "/../../partials/nav.php");
is_logged_in(true);
?>

<?php
// Function to retrieve data from the Quotes table
function getQuotesData()
{
    $db = getDB();

    try {
        // Retrieve data from the Quotes table
        $query = "SELECT quotes, author, created FROM Quotes";
        $stmt = $db->query($query);
        $quotesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $quotesData;
    } catch (PDOException $e) {
        // Handle any potential errors
        // You may log or display an error message here
        return [];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quotes List</title>
    <!-- Add CSS styling here -->

    <!-------------------------->
</head>
<body>
    <h1>Quotes List</h1>
    <table>
        <tr>
            <th>Quotes</th>
            <th>Author</th>
            <th>Created</th>
        </tr>
        <?php
        $quotesData = getQuotesData();
        foreach ($quotesData as $quoteData):
        ?>
        <tr>
            <td><?php echo htmlspecialchars($quoteData['quotes']); ?></td>
            <td><?php echo htmlspecialchars($quoteData['author']); ?></td>
            <td><?php echo htmlspecialchars($quoteData['created']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>