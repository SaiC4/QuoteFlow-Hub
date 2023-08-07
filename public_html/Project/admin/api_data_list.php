<?php
require(__DIR__ . "/../../../partials/nav.php");
if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: " . get_url("home.php")));
}
?>
<?php

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
    <?php
    // Gets the total number of saved records for the user
    $totalSavedRecords = count($savedQuotesData);
    ?>

    <form method="get" action="">
        <div class="search-bars">

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
        <h4>Records not associated with Users:  </h4>

        <!-- Display the total number of records in the use-associated database -->
        <h4>Total Records Shown: <?php echo count($savedQuotesData); ?></h4>
    </div>

    <div class="table-container">
        <table>
            <tr>
                <th>Quotes</th>
                <th>Author</th>
                <th>Details</th>
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
                }
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($savedQuoteData['quotes']); ?></td>
                    <td><?php echo htmlspecialchars($savedQuoteData['author']); ?></td>
                    <td>
                        <!-- Redirects user to view_details.php -->
                        <a href="<?php echo get_url("view_details.php?quote_id=" . $savedQuoteData['saved_id']); ?>">
                            <button>Details</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="buttons-container">
        <!-- Button to refresh the page -->
        <button type="button" onclick="window.location.href = 'api_data_list.php';">Refresh List</button>
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