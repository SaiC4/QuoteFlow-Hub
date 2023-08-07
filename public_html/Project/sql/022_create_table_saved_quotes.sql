/*
    UCID: sjc65
    Date: 07/24/2023
    Explanation: The purpose of this table is to store the saved quotes the user saves on their account. The code retrieves the "id"
    from the "User" table and the "id" from the "Quotes" table and assigns it to "user_id" and "quotes_id" respectively. That way,
    each unique user's ID can be associated with the quote IDs from the quotes table.
*/

CREATE TABLE IF NOT EXISTS `Saved_Quotes` (
    `id`                    INT AUTO_INCREMENT NOT NULL,
    `user_id`               INT NOT NULL,
    `quote_id`              INT NOT NULL,
    `quotes`                VARCHAR(255) NOT NULL,
    `author`                VARCHAR(50) NOT NULL,
    `created`               TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified`              TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`),
    FOREIGN KEY (`quote_id`) REFERENCES `Quotes`(`id`)
)

/*
    SQL Query statement for INSERTING saved quotes:

        INSERT INTO Saved_Quotes (user_id, quote_id)
        VALUES (id, id);

    SQL Query statement for RETRIEVING saved quotes:

        SELECT Quotes.quote_text, Quotes.author, Quotes.category, Saved_Quotes.date_saved
        FROM Quotes
        JOIN Saved_Quotes ON Quotes.quote_id = Saved_Quotes.quote_id
        WHERE Saved_Quotes.user_id = id;
*/