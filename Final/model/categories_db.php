<?php
    function getCategories() {
        // Open Database
        global $db;
        // Return all categories
        $query = 'SELECT *
                FROM categories
                ORDER BY categoryName';

        $statement = $db->prepare($query);
        $statement->execute();
        $categories = $statement->fetchAll();
        $statement->closeCursor();
        // Return queried to do vehicles
        return $categories;
    }
?>