<?php
// this is the reviews controller for the site

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/reviews-model.php';
// Get the functions library
require_once '../library/functions.php';

$classifications = getClassifications();
$navList = buildNav($classifications);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'addReview':
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING));
        $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));

        if (empty($reviewText)) {
            $messageReview = '<p id="review-message">Please provide information for all empty form fields.</p>';
            header("Location: /phpmotors/vehicles?action=viewVehicle&invId=" . $invId . "&messageReview=" . $messageReview);
            exit; 
        }

        $reviewOutcome = addReview($reviewText, $invId, $clientId);

        if($reviewOutcome === 1) {
            $messageReview = "<p id='review-message'>Thanks for the review, it displayed below.</p>";
            header("Location: /phpmotors/vehicles?action=viewVehicle&invId=" . $invId . "&messageReview=" . $messageReview);
            exit;
        } 
        else {
            $messageReview = "<p id='review-message'>Sorry, your review was not added.</p>";
            header("Location: /phpmotors/vehicles?action=viewVehicle&invId=" . $invId . "&messageReview=" . $messageReview);
            exit;
        }

        break;
    case 'editReview':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $review = getReviewById($reviewId);
        include '../view/edit-review.php';
        break;
    case 'updateReview':
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        if (empty($reviewText) || empty($reviewId)) {
            $message = '<p id="review-message">Please complete all information for the review.</p>';
            header('location: /phpmotors/accounts'. "?message=" . $message);
            exit;
        }
        $review = getReviewById($reviewId);
        $updateResult = updateReview($reviewId, $reviewText);
        if ($updateResult) {
            $message = "<p id='review-message'>Congratulations, the review was successfully updated.</p>";
            header('location: /phpmotors/accounts'. "?message=" . $message);
            exit;
        } else {
            $message = "<p id='review-message'>Error. The review was not updated.</p>";
            include '../view/edit-review.php';
            exit;
        }
        break;

    case 'deleteReview':
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        if (empty($reviewId)) {
            $message = '<p id="review-message">Please complete all information for the review.</p>';
            include '../view/delete-review.php';
            exit;
        }
        $review = getReviewById($reviewId);
        $deleteResult = deleteReview($reviewId);
        if ($deleteResult) {
            $message = "<p id='review-message'>The review was deleted successfully.</p>";
            header('location: /phpmotors/accounts'. "?message=" . $message);
            exit;
        } else {
            $message = "<p id='review-message'>Error. the review was not deleted.</p>";
            include '../view/delete-review.php';
            exit;
        }

    case 'confirmDeleteReview':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $review = getReviewById($reviewId);
        include '../view/delete-review.php';        
        break;

    default:
        include '../view/admin.php';
        break;
}
