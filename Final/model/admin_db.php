<?php
    require('./model/db.php');
    
    function is_username_active($username) {
        // Open Database
        global $db;
        // Set query to get number of columns matching username
        $query = 'SELECT count(*)
                FROM administrators
                WHERE username = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        // Set result to number of matches found
        $result = $statement->fetchColumn();
        $statement->closeCursor();
        // If result has value, return true
        return $result == 1 ? true : false;
    }

    function is_valid_admin_login($username, $password) {
        // Open Database
        global $db;
        // Query to get user password
        $query = 'SELECT password 
                FROM administrators 
                WHERE username = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        // If row has password, set hash to value
        $hash = empty($row['password']) ? null : $row['password'];
        // Return result of password validation, true if match
        return password_verify($password, $hash);
    }

?>