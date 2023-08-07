<?php
require(__DIR__ . "/../../../partials/nav.php");
if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: " . get_url("home.php")));
}
?>
<?php
/*
    UCID: sjc65
    Date: 08/06/2023
    Explanation: The purpose of the page is to display all the non-user associated data. The function below
    retrieves the ID, Quotes, Author, and API_Gen data from the Quotes table. This function also contains the
    filter/sort feature. The code first gets the data from the Quotes table, then matches the search
    terms with the results in the database.
*/
// Function retrieves the ID, Quote, Author, and API_Gen columns from the Quotes table
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
    Date: 08/06/2023
    Explanation: This block of code shows how the search form is submitted when the search button is clicked.
    First the code gets the search terms and limit, then the code filters the results and assigns the
    filtered results to the $quotesData variable to be used in the HTML code.
*/
// Handle the form submission
if (isset($_GET['quoteSearch']) || isset($_GET['authorSearch']) || isset($_GET['limit'])) {

    // Get the search terms and limit from the user input
    $quoteSearchTerm = trim($_GET['quoteSearch']);
    $authorSearchTerm = trim($_GET['authorSearch']);
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : null;

    // Call the function with the search terms and limit to get filtered data
    $quotesData = getQuotesData($quoteSearchTerm, $authorSearchTerm, $limit, 1);

    // Call the function with the search terms and limit to get filtered data
    $quotesData = getQuotesData($quoteSearchTerm, $authorSearchTerm, $limit);

    // Get the count of API-generated records
    $apiGeneratedQuotes = array_filter($quotesData, function ($quoteData) {
        return $quoteData['API_Gen'] === 1;
    });

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
    $quotesData = getQuotesData(null, null, $defaultLimit, 1);

    // Get the count of API-generated records
    $apiGeneratedQuotes = array_filter($quotesData, function ($quoteData) {
        return $quoteData['API_Gen'] === 1;
    });
}
// Get the total number of API quotes
$db = getDB();
$stmt = $db->query("SELECT COUNT(*) AS total_quotes FROM Quotes WHERE API_Gen = 1");
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$totalQuotes = (int)$result['total_quotes'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Non-User Assoc.</title>
    <style>

    </style>
</head>

<body>
    <h2>All Non-User Associations</h2>
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
    <!--
        UCID: sjc65
        Date: 08/06/2023
        Explanation: This code shows the HTML code for the page. The HTML code shows how the search form is set up,
        with the record limit set to the total number of records in the table (unaffected by filter/sort). Below the
        form is the labels that display the stats of the database. Below that is the code for how the records list
        is arranged, with a details link in each record that displays the data from the Quotes table. At the end 
        of the script is the refresh button the refreshes the list back to the default view.
    -->
    <form method="get" action="">
        <div class="search-bars">

            <label for="quoteSearch">Quote Search:</label>
            <input type="text" name="quoteSearch" id="quoteSearch" placeholder="Enter quote term">

            <div class="separator"></div> <!-- Vertical black line separator -->

            <label for="authorSearch">Author Search:</label>
            <input type="text" name="authorSearch" id="authorSearch" placeholder="Enter author term">

            <div class="separator"></div> <!-- Vertical black line separator -->

            <label for="limit">Records Limit (1-100):</label>
            <input type="number" name="limit" id="limit" min="1" max="<?php echo $totalQuotes; ?>" value="<?php echo count($apiGeneratedQuotes); ?>">

            <div class="separator"></div> <!-- Vertical black line separator -->

            <button type="submit">Search</button>
        </div>
    </form>

    <div class="record-info">
        <!-- Display the total number of records not associated with any user -->
        <h4>Non-User Associated Records: <?php echo $totalQuotes; ?></h4>

        <!-- Display the total number of records in the list -->
        <h4>Total Records Shown: <?php echo count($apiGeneratedQuotes); ?></h4>
    </div>

    <div class="table-container">
        <table>
            <tr>
                <th>API</th>
                <th>Quotes</th>
                <th>Author</th>
                <th>Details</th>
            </tr>
            <?php foreach ($quotesData as $quoteData) : ?>
                <?php if ($quoteData['API_Gen'] === 1) : ?> <!-- Check if API_Gen equals 1 -->
                    <tr>
                        <td>
                            <!-- Display a black checkmark -->
                            <span class="checkmark">&#x2713;</span>
                        </td>
                        <td><?php echo htmlspecialchars($quoteData['quotes']); ?></td>
                        <td><?php echo htmlspecialchars($quoteData['author']); ?></td>
                        <td>
                            <!-- Redirects user to view_details.php -->
                            <a href="<?php echo get_url("view_details.php?quote_id=" . $quoteData['id']); ?>">
                                <button>Details</button>
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="buttons-container">
        <!-- Button to refresh the page -->
        <button type="button" onclick="window.location.href = 'api_data_list.php';">Refresh List</button>
    </div>
</body>
<script>
    // Function to go back to previous page
    function goBack() {
        window.history.back();
    }
</script>

</html>

<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>