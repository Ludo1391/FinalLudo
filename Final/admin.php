<?php
// Add database and table functions
require('./model/db.php');
require('./model/quotes_db.php');
require('./model/authors_db.php');
require('./model/categories_db.php');

// Validate if user is logged in to view admin functions
session_status() === PHP_SESSION_ACTIVE ? '' : session_start();
$loggedIn = isset($_SESSION['is_valid_admin']);

// Init variables
$display;
$approval = false;
$quotes = [];

// Check if POST is empty, if not set variables
if (!empty($_POST)) {
    $action = filter_input(INPUT_POST, 'action');
    $quoteID = filter_input(INPUT_POST, 'quoteID');
    // GET method, set action to get value
} else {
    $action = filter_input(INPUT_GET, 'action');
}

// If user is not logged in, display login
if (!$loggedIn) {
    $display = 'view/pages/login.php';
    // If approvals requested
} else if ($action == "approvals") {
    // Get quotes requiring approval
    $quotes = getApprovals();
    // Set variable to true to display approvals
    $approval = true;
    // Display quotes page
    $display = 'view/pages/quotes.php';
    // If action is delete
} else if ($action == 'delete') {
    // Delete selected quote
    deleteQuote($quoteID);
    // Redirect to admin
    header("Location: admin.php");
    // If action set to approve quote
} else if ($action == 'approve') {
    // Update quote to approved
    approveQuote($quoteID);
    // Redirect to admin with approvals action
    header("Location: admin.php?action=approvals");
    // If action is logout, log user out and remove cookies
} else if ($action == 'logout') {
    session_unset();
    // Destroy session
    session_destroy();
    // Set variables need to delete cookies
    $name = session_name();
    $expire = strtotime('-1 year');
    $params = session_get_cookie_params();
    $path = $params['path'];
    $domain = $params['domain'];
    $secure = $params['secure'];
    $httponly = $params['httponly'];
    // Delete cookies
    setcookie($name, '', $expire, $path, $domain, $secure, $httponly);
    header("Location: admin.php");
    // If action is submit, submit new quote with approval is true
} else if ($action == "submit") {
    // Set variables to input from form
    $authorIDSubmit = filter_input(INPUT_POST, 'authorIDSubmit', FILTER_VALIDATE_INT);
    $categoryIDSubmit = filter_input(INPUT_POST, 'categoryIDSubmit', FILTER_VALIDATE_INT);
    $textsubmit = htmlspecialchars(filter_input(INPUT_POST, 'textsubmit'));
    // Add quote to DB
    addQuote($textsubmit, $authorIDSubmit, $categoryIDSubmit, true);
    // Redirect to admin page
    header("Location: admin.php");
    // Default display if user is logged in
} else {
    // Set variables to filter inputs
    $authorID = filter_input(INPUT_GET, 'authorID', FILTER_VALIDATE_INT);
    $categoryID = filter_input(INPUT_GET, 'categoryID', FILTER_VALIDATE_INT);
    // Get quotes based on filter selections
    $quotes = getQuotes($authorID, $categoryID, 0);
    // Display quotes page
    $display = 'view/pages/quotes.php';
}

// Set array of results for filters
$authors = getAuthors();
$categories = getCategories();

// Include required files
include('view/pages/header.php');
include('view/pages/navigation_admin.php');
include($display);
include('view/pages/footer.php');
