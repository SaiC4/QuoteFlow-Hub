<?php
require(__DIR__ . "/../../../partials/nav.php");

if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: " . get_url("data_list.php")));
}
?>
<?php
// Check if the quote ID is provided in the URL
if (isset($_GET['quote_id'])) {
    $quoteId = (int)$_GET['quote_id'];

    // Get the total number of records in the database
    $db = getDB();
    $stmt = $db->query("SELECT COUNT(*) AS total_records FROM Quotes");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalRecords = (int)$result['total_records'];

    if ($quoteId > $totalRecords) {
        flash("Invalid quote ID", "warning");
        header("Location: " . get_url("data_list.php"));
        exit;
    }

    // Function to retrieve record details based on the ID
    function getRecordDetails($id)
    {
        $db = getDB();

        try {
            $stmt = $db->prepare("SELECT id, quotes, author FROM Quotes WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $recordDetails = $stmt->fetch(PDO::FETCH_ASSOC);

            return $recordDetails;
        } catch (PDOException $e) {
            flash("An error occurred while retrieving record details from the database", "danger");
            return null;
        }
    }

    // Get the record details based on the quote ID
    $recordDetails = getRecordDetails($quoteId);

    if ($recordDetails !== null) {
        $quote = $recordDetails['quotes'];
        $author = $recordDetails['author'];
    } else {
        flash("Record not found", "danger");
        // Redirect to the quotes list page if the record is not found
        header("Location: " . get_url("data_list.php"));
        exit;
    }
} else {
    flash("record ID not found", "warning");
    // Redirect to the quotes list page if the quote ID is not provided
    header("Location: " . get_url("data_list.php"));
    exit;
}

// Handle the form submission
if (isset($_POST['update'])) {
    $newQuote = trim($_POST['quote']);
    $newAuthor = trim($_POST['author']);

    // Validate the input fields
   // Validate the input fields
   $formErrors = validateForm($newQuote, $newAuthor);
   if (!empty($formErrors)) {
       foreach ($formErrors as $error) {
           flash($error, "warning");
       }
   } else {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Quotes SET quotes = :quote, author = :author WHERE id = :id");
        try {
            $stmt->execute([
                ":quote" => $newQuote,
                ":author" => $newAuthor,
                ":id" => $quoteId
            ]);
            // Redirects user back to edit page on successful update and flashes success message
            flash("Quote and Author successfully updated", "success");
            header("Location: " . $_SERVER['PHP_SELF'] . "?quote_id=" . $quoteId);
            exit;
        } catch (PDOException $e) {
            flash("An error occurred while updating the record", "danger");
        }
    }
}

function validateForm($quote, $author)
{
    $errors = [];

    // Checks if quote length is between 4 and 50 characters
    if (strlen($quote) > 0 && (strlen($quote) <= 3 || strlen($quote) > 255)) {
        $errors[] = "Quote must be between 4 and 255 characters";
    }

    // Checks if author length is between 4 and 50 characters
    if (strlen($author) > 0 && (strlen($author) <= 3 || strlen($author) > 50)) {
        $errors[] = "Author must be between 4 and 50 characters";
    }

    // Checks if the author field contains numbers
    if (strlen($author) > 0 && preg_match('/\d/', $author)) {
        $errors[] = "Author field must not contain numbers";
    }

    // Checks if quote field and/or author field is empty
    if ((empty($quote) || empty($author)) || (empty($quote) && empty($author))) {
        $errors[] = "Quote and/or Author fields must not be empty";
    }

    return $errors;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Details</title>
    <style>
/* -----------------------------------------------------CSS Styles------------------------------------------------------------------*/
/* CSS for the black double border around the form */
.form-container {
    border: 6px double black;
    padding: 20px; 
}

/* CSS to space out the labels and inputs */
form div {
    margin-bottom: 10px;
}

/* CSS to extend the height of the Quote label */
form label[for="quote"] {
    vertical-align: top; 
    display: inline-block;
}

/* CSS for the box around the Quote label */
.author-label-box, .quote-label-box {
    color: black;
    padding: 5px;
    display: inline-block;
    font-weight: bold;
}

/* CSS to make the input fields bigger and align them with labels */
form input[type="text"] {
    width: 100%;
    padding: 5px;
    box-sizing: border-box;
}

input[type="submit"][name="update"] {
    background-color: rgb(81, 81, 81);
    color: rgb(208, 199, 199);
    margin-top: 10px;
    margin: 10px 10px 0 0;
    padding: 8px;
}

/* CSS to change the hover color of the submit input button */
input[type="submit"][name="update"]:hover {
    background-color: rgb(30, 31, 31);
}

/* CSS to change the two button design */
button {
    background-color: rgb(81, 81, 81);
    color: rgb(208, 199, 199);
    margin-top: 10px;
    margin: 10px 10px 0 0;
    padding: 8px;
}

/* CSS to change the two button hover colors */
button:hover {
    background-color: rgb(30, 31, 31);
}
/* ---------------------------------------------------------------------------------------------------------------------------------*/
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Edit Record Details</h2>
        <form method="POST">
            <div>
                <div class="quote-label-box">
                    <label for="quote">Quote:</label>
                </div>
                <input type="text" name="quote" id="quote" value="<?php echo htmlspecialchars($quote); ?>" />
            </div>
            <div>
                <div class="author-label-box">
                    <label for="author">Author:</label>
                </div>
                <input type="text" name="author" id="author" value="<?php echo htmlspecialchars($author); ?>" />
            </div>
            <input type="submit" name="update" value="Update" />
        </form>
    </div>
    <!-- Redirects user back to data_list.php   ***ISSUE HERE***-->
    <!--<a href="../Project/data_list.php"><button>Back to Quotes List</button></a>-->
    <!-- Redirects user back to view_details.php -->
    <a href="<?php echo get_url("view_details.php?quote_id=" . $quoteId); ?>"><button>Back to Details</button></a>
</body>

</html>
<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>
