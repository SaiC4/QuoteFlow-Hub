/* 
    UCID: sjc65
    Date: 07/18/2023
    Explanation: Creating a table that stores the id, quote, author, created, and modified. The id column is for each entry, 
    the quotes column is for each quote that will be stored in the table, the author column is to store the author associated
    with each quote, and the created/modified columns are to track the time stamp of the created/modiefied entry.
*/
CREATE TABLE IF NOT EXISTS `Quotes`(
    `id`        int not null auto_increment,
    `quotes`    VARCHAR(255) NOT NULL,
    `author`    VARCHAR(50) NOT NULL,
    `created`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
)