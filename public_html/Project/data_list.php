<?php
require_once(__DIR__ . "/../../partials/nav.php");
is_logged_in(true);
?>

<?php
// Function to retrieve data from the Quotes table
function getQuotesData($quoteSearchTerm = null, $authorSearchTerm = null, $limit = 10)
{
    // Validate the limit value to be within the range (1 to 100)
    $limit = max(1, min(100, (int)$limit));
    $db = getDB();

    try {
        // Build the SQL query
        $query = "SELECT quotes, author, API_Gen FROM Quotes WHERE 1";

        // Add search conditions if search terms are provided
        if ($quoteSearchTerm !== null) {
            // Use the LIKE keyword for partial string matching
            $query .= " AND quotes LIKE :quoteSearchTerm";
        }

        if ($authorSearchTerm !== null) {
            // Use the LIKE keyword for partial string matching
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

        // Bind the limit parameter
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();
        $quotesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $quotesData;
    } catch (PDOException $e) {
        return [];
    }
}

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
    <!---------------------------Add CSS styling here -------------------------->
    <style>
        /* CSS styling for the table container */
        .table-container {
            width: 1600px;
            /* Set the width to 150 pixels */
            height: 500px;
            /* Set the height to 100 pixels */
            overflow-y: scroll;
            /* Add vertical scrollbar */
            border: 2px solid black;
            /* Black border for the container */
            margin: 0 auto;
            /* Center the container on the page */
        }

        /* CSS styling for the table */
        table {
            border-collapse: collapse;
            width: 100%;
            /* Set the table width to 100% of the container */
        }

        th,
        td {
            padding: 10px;
            border: 2px solid black;
            /* Black lines separating each cell */
            text-align: center;
            /* Center the list items under each column */
        }

        th {
            background-color: rgb(81, 81, 81);
            /* Black background for table headers */
            color: white;
            /* White font color for table headers */
            font-family: "Lucida Console", "Courier New", monospace;
            width: 80px;
            /* Shrink the "API?" column width to 80 pixels */
        }

        /* Set column sizes */
        th:first-child,
        td:first-child {
            width: 20px;
            /* "API?" column size (limited to 3 characters width) */
            max-width: 3ch;
            /* Limit the column to 3 characters width */
            white-space: nowrap;
            /* Prevent the text from wrapping */
            overflow: hidden;
            /* Hide any overflow */
            text-overflow: ellipsis;
            /* Show ellipsis for truncated text */
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 300px;
            /* "Quotes" column size (100px wider) */
        }

        th:nth-child(3),
        td:nth-child(3),
        th:nth-child(4),
        td:nth-child(4) {
            width: 80px;
            /* "Author" and "Created" column size (remains the same) */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
            /* Gray background for even rows */
        }

        .api-cell {
            font-size: 20px;
            /* Increase font size to 16px */
        }

        .checkmark {
            font-weight: bold;
            /* Make the checkmark bolder */
        }

        /* --------------------------------------------------------------------------------------------- */
        button {
            background-color: rgb(81, 81, 81);
            color: rgb(208, 199, 199);
            margin-top: 10px;
            margin: 10px 10px 0 0;
        }

        button:hover {
            background-color: rgb(30, 31, 31);
        }

        .buttons-container {
            margin-top: 10px;
            text-align: center;
        }

        .buttons-container button {
            padding: 6px;
            margin: 5px 30px;
            /* Add 30px separation between buttons */
        }

        /* --------------------------------------------------------------------------------------------- */
        .search-bars {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        label {
            margin-right: 10px;
        }

        input[type="text"],
        input[type="number"] {
            padding: 5px;
            width: 200px;
            border: 1px solid #000;
        }

        input[type="number"] {
            width: 100px;
        }


        .separator {
            margin: 0 10px;
            border: none;
            /* Remove the border */
            height: 33px;
            width: 2px;
            background-color: #000;
        }
    </style>
    <!-------------------------------------------------------------------------->
    
    <body>
    <h2>Quotes List</h2>
    <form method="get" action="">
        <div class="search-bars">
            <label for="quoteSearch">Quote Search:</label>
            <input type="text" name="quoteSearch" id="quoteSearch" placeholder="Enter search term">
            <div class="separator"></div> <!-- A small black line separator -->
            <label for="authorSearch">Author Search:</label>
            <input type="text" name="authorSearch" id="authorSearch" placeholder="Enter author name">
            <div class="separator"></div> <!-- A small black line separator -->
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
                            // Display a black checkmark
                            echo '<span class="checkmark">&#x2713;</span>';
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($quoteData['quotes']); ?></td>
                    <td><?php echo htmlspecialchars($quoteData['author']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>