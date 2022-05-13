<?php

    // Set for local or production DB
    const PRODUCTION = true;

    // Check if production build, if so use Heroku DB
    if (PRODUCTION) {
        // DB variables set to required settings
        $dsn = 'mysql:host=bbj31ma8tye2kagi.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=ns05o8od4aqphelr';
        $username = 'hzcr7bqchttlxf8b';
        $password = 'v7s4ss0bhn3rsxlc';
        // Try PDO connection
        try {
            $db = new PDO($dsn, $username, $password);
            } catch (PDOException $e) {
                // Display error message
                $error_message = $e->getMessage();
                include('./view/header.php');
                include('./errors/database_error.php');
                include('./view/footer.php');
            exit();
        } 
    // Set DB to localhost
    } else {
        // DB variables set to required settings
        $dsn = 'mysql:host=localhost;dbname=quotes';
        $username = 'root';

        // Try PDO connection
        try {
            $db = new PDO($dsn, $username);
        } catch (PDOException $e) {
            // Display error message
            $error_message = $e->getMessage();
            include('./errors/database_error.php');
            exit();
        }
    }
    
?>