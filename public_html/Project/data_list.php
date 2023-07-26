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
        $query = "SELECT quotes, author, API_Gen, created FROM Quotes WHERE 1";

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
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

    // Call the function with the search terms and limit to get filtered data
    $quotesData = getQuotesData($quoteSearchTerm, $authorSearchTerm, $limit);

    // Check if the search resulted in no matches and show flash message
    if (empty($quotesData)) {
        flash("No matches found");
    }
} else {
    // Call the function without search terms to get default data
    $quotesData = getQuotesData();
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
            width: 1600px; /* Set the width to 150 pixels */
            height: 500px; /* Set the height to 100 pixels */
            overflow-y: scroll; /* Add vertical scrollbar */
            border: 2px solid black; /* Black border for the container */
            margin: 0 auto; /* Center the container on the page */
        }

        /* CSS styling for the table */
        table {
            border-collapse: collapse;
            width: 100%; /* Set the table width to 100% of the container */
        }

        th, td {
            padding: 10px;
            border: 2px solid black; /* Black lines separating each cell */
            text-align: center; /* Center the list items under each column */
        }

        th {
            background-color: rgb(81, 81, 81); /* Black background for table headers */
            color: white; /* White font color for table headers */
            font-family: "Lucida Console", "Courier New", monospace;
            width: 80px; /* Shrink the "API?" column width to 80 pixels */
        }

        /* Set column sizes */
        th:first-child,
        td:first-child {
            width: 20px; /* "API?" column size (limited to 3 characters width) */
            max-width: 3ch; /* Limit the column to 3 characters width */
            white-space: nowrap; /* Prevent the text from wrapping */
            overflow: hidden; /* Hide any overflow */
            text-overflow: ellipsis; /* Show ellipsis for truncated text */
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 300px; /* "Quotes" column size (100px wider) */
        }

        th:nth-child(3),
        td:nth-child(3),
        th:nth-child(4),
        td:nth-child(4) {
            width: 80px; /* "Author" and "Created" column size (remains the same) */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Gray background for even rows */
        }

        .api-cell {
        font-size: 20px; /* Increase font size to 16px */
        }

        .checkmark {
            font-weight: bold; /* Make the checkmark bolder */
        }
    </style>
    <!-------------------------------------------------------------------------->
    </head>
    <body>
    <h1>Quotes List</h1>
    <h2>Filter Quotes</h2>
    <form method="get" action="">
        <label for="quoteSearch">Quote Search:</label>
        <input type="text" name="quoteSearch" id="quoteSearch" placeholder="Enter search term">
        <label for="authorSearch">Author Search:</label>
        <input type="text" name="authorSearch" id="authorSearch" placeholder="Enter author name">
        <label for="limit">Records Limit (1-100):</label>
        <input type="number" name="limit" id="limit" min="1" max="100" value="10">
        <button type="submit">Search</button>
    </form>

    <div class="table-container">
        <table>
            <tr>
                <th>API?</th> 
                <th>Quotes</th>
                <th>Author</th>
                <th>Created</th>
            </tr>
            <?php foreach ($quotesData as $quoteData): ?>
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
                    <td><?php echo htmlspecialchars($quoteData['created']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>