<?php
    function getAuthors() {
        // Open Database
        global $db;
        // Get all authors
        $query = 'SELECT *
                FROM authors
                ORDER BY authorName';

        $statement = $db->prepare($query);
        $statement->execute();
        $authors = $statement->fetchAll();
        $statement->closeCursor();
        // Return authors
        return $authors;
    }
?>