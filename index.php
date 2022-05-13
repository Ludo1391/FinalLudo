<?php
// Add database and table functions
require('./model/db.php');
require('./model/quotes_db.php');
require('./model/authors_db.php');
require('./model/categories_db.php');

// Set variables for filters
$authorID = filter_input(INPUT_GET, 'authorID', FILTER_VALIDATE_INT);
$categoryID = filter_input(INPUT_GET, 'categoryID', FILTER_VALIDATE_INT);
$random = filter_input(INPUT_GET, 'random', FILTER_VALIDATE_INT);
$sortDirection = filter_input(INPUT_GET, 'sortDirection', FILTER_VALIDATE_INT);

// Set array of results for filters
$authors = getAuthors();
$categories = getCategories();

// Set array of all quotes matching filter selections
$quotes = getQuotes($authorID, $categoryID, 0);
$quotes = $random == 'true' ? ($quotes[mt_rand(0, count($quotes) - 1)]) : $quotes;

// Check if POST request, add submitted quote without approval
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authorIDSubmit = filter_input(INPUT_POST, 'authorIDSubmit', FILTER_VALIDATE_INT);
    $categoryIDSubmit = filter_input(INPUT_POST, 'categoryIDSubmit', FILTER_VALIDATE_INT);
    $textsubmit = htmlspecialchars(filter_input(INPUT_POST, 'textsubmit'));
    addQuote($textsubmit, $authorIDSubmit, $categoryIDSubmit, false);
}

// Set admin/approval status 
$loggedIn = false;
$approval = false;

// Views to display
include('view/pages/header.php');
include('view/pages/navigation.php');
include('view/pages/quotes.php');
include('view/pages/footer.php');
