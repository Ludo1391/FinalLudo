<?php

function getQuotes($authorID, $categoryID, $limit)
{
    // Open Database
    global $db;
    // Array to store bind values
    $bindValues = [];
    $query = 'SELECT q.quoteID, q.text, a.authorName as authorName, c.categoryName as categoryName
                FROM quotes q
                LEFT JOIN authors a on q.authorID = a.authorID
                LEFT JOIN categories c on q.categoryID = c.categoryID
                WHERE q.approved = 1';
    // Add author conditional to query
    if ($authorID >= 1) {
        $query .= ' AND q.authorID = :authorID';
        array_push($bindValues, [':authorID', $authorID]);
    }
    // Add category conditional to query
    if ($categoryID >= 1) {
        $query .= ' AND q.categoryID = :categoryID';
        array_push($bindValues, [':categoryID', $categoryID]);
    }
    // Set limit if more than 0
    $query .= $limit > 0 ? ' LIMIT ' . $limit : "";
    $statement = $db->prepare($query);
    // Loop through bind array
    for ($i = 0; $i < count($bindValues); $i++) {
        $statement->bindValue($bindValues[$i][0], $bindValues[$i][1]);
    }
    $statement->execute();
    $quotes = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    // Return queried quotes
    return $quotes;
}

function getApprovals()
{
    // Open Database
    global $db;
    // Query all quotes which require approval
    $query = 'SELECT q.quoteID, q.text, a.authorName as authorName, c.categoryName as categoryName
                FROM quotes q
                LEFT JOIN authors a on q.authorID = a.authorID
                LEFT JOIN categories c on q.categoryID = c.categoryID
                WHERE q.approved = 0';

    $statement = $db->prepare($query);
    $statement->execute();
    $quotes = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    // Return akk quotes requiring approval
    return $quotes;
}

// Delete quote from database
function deleteQuote($quoteID)
{
    // Open database
    global $db;
    // Delete quote based on quote ID
    $query = 'DELETE FROM quotes
                WHERE quoteID = :quoteID';
    // PDO delete quote from database
    $statement = $db->prepare($query);
    $statement->bindValue(':quoteID', $quoteID);
    $statement->execute();
    $statement->closeCursor();
}

// Update quote with approval
function approveQuote($quoteID)
{
    // Open database
    global $db;
    // Get quote based on quote ID
    $query = 'UPDATE quotes
                SET approved = 1
                WHERE quoteID = :quoteID';
    // PDO delete quote from database
    $statement = $db->prepare($query);
    $statement->bindValue(':quoteID', $quoteID);
    $statement->execute();
    $statement->closeCursor();
}

// // Add to do quote to database
function addQuote($text, $authorID, $categoryID, $approved)
{
    // Open database
    global $db;
    // Set query for quote to be added
    $query = 'INSERT INTO quotes
                 (text, authorID, categoryID, approved)
              VALUES
                 (:text, :authorID, :categoryID, :approved)';
    // PDO insert quote into database
    $statement = $db->prepare($query);
    $statement->bindValue(':text', $text);
    $statement->bindValue(':authorID', $authorID);
    $statement->bindValue(':categoryID', $categoryID);
    $statement->bindValue(':approved', $approved);
    $statement->execute();
    $statement->closeCursor();
}
