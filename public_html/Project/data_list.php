<?php
require_once(__DIR__ . "/../../partials/nav.php");
is_logged_in(true);
?>

<?php
/*
    UCID: sjc65
    Date: 07/26/2023
    Explanation: In this picture, it shows the function for retrieving data from the database and displaying it into the list,
    the code also has the search functionality so it can compare the user's filter keywords with what contains in the database.
*/
// Function to retrieve data from the Quotes table
function getQuotesData($quoteSearchTerm = null, $authorSearchTerm = null, $limit = 10)
{
    // Validate the limit value to be within the range (1 to 100)
    $limit = max(1, min(100, (int)$limit));
    $db = getDB();

    try {
        // Build the SQL query
        $query = "SELECT id, quotes, author, API_Gen FROM Quotes WHERE 1";

        // Add search conditions if search terms are provided
        if ($quoteSearchTerm !== null) {
            $query .= " AND quotes LIKE :quoteSearchTerm";
        }

        if ($authorSearchTerm !== null) {
            $query .= " AND author LIKE :authorSearchTerm";
        }

        // Add the limit to the SQL query
        $query .= " LIMIT :limit";

        $stmt = $db->prepare($query);

        if ($quoteSearchTerm !== null) {
            $quoteSearchTerm = "%" . $quoteSearchTerm . "%";
            $stmt->bindParam(':quoteSearchTerm', $quoteSearchTerm, PDO::PARAM_STR);
        }

        if ($authorSearchTerm !== null) {
            $authorSearchTerm = "%" . $authorSearchTerm . "%";
            $stmt->bindParam(':authorSearchTerm', $authorSearchTerm, PDO::PARAM_STR);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $quotesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $quotesData;

    } catch (PDOException $e) {
        flash("An error occured while retrieving data from the database", "danger");
        return [];
    }
}
/*
    UCID: sjc65
    Date: 07/26/2023
    Explanation: This is the code block that handles the form submission for the Search bar fields. The code first gets the user
    input from the text fields and compares it with the data in the database to see how many of the records contain the
    specified keywords and then the records that match are the only ones displayed. If no matches are found, the code
    prompts the user with an alert message.
*/
// Handle the form submission
if (isset($_GET['quoteSearch']) || isset($_GET['authorSearch']) || isset($_GET['limit'])) {
    
    // Get the search terms and limit from the user input
    $quoteSearchTerm = trim($_GET['quoteSearch']);
    $authorSearchTerm = trim($_GET['authorSearch']);
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : null; // Set limit to null by default

    // Call the function with the search terms and limit to get filtered data
    $quotesData = getQuotesData($quoteSearchTerm, $authorSearchTerm, $limit);

    // Check if the search resulted in no matches and show flash message
    if (empty($quotesData)) {
        flash("No matches found");
    }

} else {
    
    // Get the total number of records in the database
    $db = getDB();
    $stmt = $db->query("SELECT COUNT(*) AS total_records FROM Quotes");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalRecords = (int)$result['total_records'];

    // Set the default limit to the total number of records
    $defaultLimit = $totalRecords;

    // Call the function with the default limit to get default data
    $quotesData = getQuotesData(null, null, $defaultLimit);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Quotes List</title>

<body>
    <h2>Quotes List</h2>
    
    <form method="get" action="">
<!-- 
    UCID: sjc65
    Date: 07/26/2023
    Explanation: In this HTML code, it shows how the search bars are displayed. Each search bar is seperated by a div class
    object called "seperator" which seperates the bars with a thin, vertical black line. The part of the code that may particularly
    be of interest is the "<input type="number...". This is the code that prevents the user from filtering records higher than the
    total number of records in the list.
-->
        <div class="search-bars">
            <label for="quoteSearch">Quote Search:</label>
            <input type="text" name="quoteSearch" id="quoteSearch" placeholder="Enter search term">
            
            <div class="separator"></div> <!-- Vertical black line separator -->
            
            <label for="authorSearch">Author Search:</label>
            <input type="text" name="authorSearch" id="authorSearch" placeholder="Enter author name">
            
            <div class="separator"></div> <!-- Vertical black line separator -->
            
            <label for="limit">Records Limit (1-100):</label>
            <input type="number" name="limit" id="limit" min="1" max="<?php echo $totalRecords; ?>" 
                                      value="<?php echo isset($limit) ? $limit : $defaultLimit; ?>">
        </div>

        <div class="buttons-container">
            <button type="submit">Search</button>
            <button type="button" onclick="window.location.href = 'data_list.php';">Refresh List</button>
        </div>

    </form>

    <div class="table-container">
        <table>
            <tr>
                <th>API?</th>
                <th>Quotes</th>
                <th>Author</th>
                <th>Details</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php foreach ($quotesData as $quoteData) : ?>
                <tr>
                    <td>
                        <?php
                        // Check if API_Gen is null or 1
                        if ($quoteData['API_Gen'] === null) {
                            // Display a blank cell if it's null
                            echo '';
                        } elseif ($quoteData['API_Gen'] === 1) {
                            // Display a black checkmark if it's 1
                            echo '<span class="checkmark">&#x2713;</span>';
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($quoteData['quotes']); ?></td>
                    <td><?php echo htmlspecialchars($quoteData['author']); ?></td>
                <!--
                    UCID: sjc65
                    Date: 07/27/2023
                    Explanation: Each button is tied to a link that redirects the user to the button's associated link, such as 
                    details button to the details page. Each link is appended with the ID of the quote that is associated with
                    the record in the data list.
                -->
                    <!-- Button link to Data Details Page -->
                    <td>
                        <a href="view_details.php?quote_id=<?php echo $quoteData['id']; ?>">
                            <button>Details</button>
                        </a>
                    </td>
                    
                    <!-- Button link to Data Edit Page -->
                    <td>
                        <a href="admin/edit_details.php?quote_id=<?php echo $quoteData['id']; ?>">
                            <button>Edit</button>
                        </a>
                    </td>
                    
                    <!-- Button link to Data Delete Page -->
                    <td>
                        <a href="admin/delete_details.php?quote_id=<?php echo $quoteData['id']; ?>">
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
require_once(__DIR__ . "/../../partials/flash.php");
?>