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
        // Retrieve data from the Quotes table, including the API_Gen column
        $query = "SELECT quotes, author, API_Gen, created FROM Quotes";
        $stmt = $db->query($query);
        $quotesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $quotesData;
    } catch (PDOException $e) {
        return [];
    }
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
            height: 600px; /* Set the height to 100 pixels */
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
    <div class="table-container">
    <table>
    <tr>
        <th>API?</th> 
        <th>Quotes</th>
        <th>Author</th>
        <th>Created</th>
    </tr>
    <?php
    $quotesData = getQuotesData();
    foreach ($quotesData as $quoteData):
    ?>
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
</body>
</html>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>