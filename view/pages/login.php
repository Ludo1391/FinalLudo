<?php
// Set variables for error messages
$error_username = "";
$error_password = "";
// Check if post are empty
if (!empty($_POST)) {
    // Add in admin database
    require_once('./model/admin_db.php');
    // Set variables to POST input values
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    // Check if username or pasword is empty
    if (empty($username) || empty($password)) {
        // If username empty, add error message 
        if (empty($username)) {
            $error_username = "Please include username";
            // Display password error message
        } else {
            $error_password = "Please include password";
        }
        // No empty values, validate user password
    } else {
        // Check if password matches
        if (is_valid_admin_login($username, $password)) {
            // Start cookie session and set admin value to logged in 
            session_status() === PHP_SESSION_ACTIVE ? '' : session_start();
            $_SESSION["is_valid_admin"] = true;
            // Redirect to main page
            header("Location: ./admin.php");
            // Password is incorrect, add error message
        } else {
            $error_password = "Incorrect Password";
        }
    }
}

// Display core of html head and nav

?>

<!-- Main section of page -->
<section class="container" id="login">
    <h1 class="">Admin Login</h1>
    <div class="grid-form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="login-card">
                <div class="grid-form-group">
                    <input type="text" name="username" id="username" placeholder="Username" />
                    <p><?php echo $error_username ?></p>
                </div>
                <div class="grid-form-group">

                    <input type="password" name="password" id="password" placeholder="Password" />
                    <p><?php echo $error_password ?></p>
                </div>
                <div class="submit-button">
                    <button type="submit" class="btn btn-color">Login</button>
                </div>
        </form>
    </div>
</section>