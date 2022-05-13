<?php
// Required Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include database files
include_once '../model/db.php';
include_once '../model/quotes_db.php';

// Init gloabl db variable
global $db;
// If GET request, return quotes based on selections
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Init variables based on GET paramaters
    $authorID = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);
    $categoryID = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
    $limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT);
    // Check if random param used
    $random = htmlspecialchars(filter_input(INPUT_GET, 'random')) == 'true' ? true : false;
    // Get quotes based on filters
    $quotes = getQuotes($authorID, $categoryID, $limit);
    // If random is true, random select 1 quote from arra
    $quotes = $random ? ($quotes[mt_rand(0, count($quotes) - 1)]) : $quotes;
    // Return quotes in JSON form
    echo json_encode($quotes);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check is header has been set
    if (!isset($_SERVER["CONTENT_TYPE"])) {
        // Return error message
        $data = array("message" => "Required: Content-Type header.");
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        // Convert JSON to array
        $data = json_decode(file_get_contents("php://input"));
        $text = htmlspecialchars(strip_tags($data->text));
        $authorID = htmlspecialchars(strip_tags($data->authorId));
        $categoryID = htmlspecialchars(strip_tags($data->categoryId));
        // Submit quote to DB, unapproved
        addQuote($text, $authorID, $categoryID, false);
        $data = array("message" => "Quote submitted for approval.");
        echo json_encode($data);
    }
} else {
    // No data sent, return error message
    $data = array("message" => "You did not send a GET or POST Request");
    echo json_encode($data);
}
