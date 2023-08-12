<?php
// This file contains a bridge between the view and the model and redirects
// back to the proper page with after processing whatever form this code 
// absorbs (we'll learn that command later when we have several pages.
// This is the C in MVC, the Controller.
//
// Authors: Rick Mercer and Brennan Mitchell
//  
session_start (); // <-- Not really needed until a future iteration

require_once './DatabaseAdaptor.php';

$theDBA = new DatabaseAdaptor();

if ( isset ( $_SESSION ['invalidInput'] )) {
    unset($_SESSION ['invalidInput']);
}

if ( isset ( $_SESSION ['regError'] )) {
    unset($_SESSION ['regError']);
}

if ( isset ( $_POST ['userReg'] ) && isset ( $_POST ['passReg'] )) {
    $userSpecial = htmlspecialchars($_POST ['userReg']); // htmlspecialchars() for userName
    $passSpecial = htmlspecialchars($_POST ['passReg']); // htmlspecialchars() for password
    if ($theDBA->usernameExists($userSpecial)) {
        $_SESSION['regError'] = $userSpecial;
        unset($_POST ['userReg']);
        unset($_POST ['passReg']);
        header ( "Location: register.php" );
    } else {
        $theDBA->addUser($userSpecial, $passSpecial);
        unset($_POST ['userReg']);
        unset($_POST ['passReg']);
        header ( "Location: view.php" );
    }
}

if ( isset ( $_POST ['userLog'] ) && isset ( $_POST ['passLog'] )) {
    $userSpecial = htmlspecialchars($_POST ['userLog']); // htmlspecialchars() for userName
    $passSpecial = htmlspecialchars($_POST ['passLog']); // htmlspecialchars() for password
    if ($theDBA->verifyCredentials($userSpecial, $passSpecial)) {
        $_SESSION['user'] = $userSpecial;
        unset($_POST ['userLog']);
        unset($_POST ['passLog']);
        header ( "Location: view.php" );
    } else {
        $_SESSION['invalidInput'] = $_POST ['userLog'];
        unset($_POST ['userLog']);
        unset($_POST ['passLog']);
        header ( "Location: login.php" );
    }
}

if ( isset ( $_POST ['quote'] )) {
    $theDBA->addQuote($_POST ['quote'], $_POST ['author']);
    unset($_POST ['quote']);
    header ( "Location: view.php" );
}

if ( isset ( $_POST ['deleteOrNot']) && $_POST ['deleteOrNot'] === 'delete') {
    $theDBA->deleteQuote($_POST ['ID']);
    unset($_POST ['delete']);
    header ( "Location: view.php ");
}

if ( isset ( $_POST ['minus'] ) && $_POST ['minus'] === '-') {
    $theDBA->lowerRating($_POST ['ID']);
    unset($_POST ['ID']);
    unset($_POST ['minus']);
    header ( "Location: view.php" );
}

if ( isset ( $_POST ['plus'] ) && $_POST ['plus'] === '+') {
    $theDBA->raiseRating($_POST ['ID']);
    unset($_POST ['ID']);
    unset($_POST ['plus']);
    header ( "Location: view.php" );
}

if (isset ( $_GET ['todo'] ) && $_GET ['todo'] === 'getQuotes') {
    $arr = $theDBA->getAllQuotations();
    unset($_GET ['todo']);
    echo json_encode(getQuotesAsHTML ( $arr ));
}

function getQuotesAsHTML($arr) {
    // TODO 6: Many things. You should have at least two quotes in table quotes. 
    // Layout each quote using a combo of PHP code and HTML strings that includes
    // HTML for buttons along with the actual quote and the author, ~15 PHP statements. 
    // You will need to add css rules to styles.css.  
    $result = '';
    foreach ($arr as $quote) {
        $result .= '<div class="container">';
        $result .= '"' . $quote ['quote'] . '"';
        $result .= '<p>--' . $quote ['author'] . '</p>';
        $result .= '<form action="controller.php" method="post">' .
            '<input type="hidden" name="ID" value="' . $quote ["id"] . '"</input>' . 
            '<input type="submit" value="+" name="plus"></button> &nbsp;&nbsp;' .  $quote ['rating'] . 
            '&nbsp;&nbsp;&nbsp;<input type="submit" value="-" name="minus"></input>' . 
            '&nbsp;&nbsp;';
        if (isset($_SESSION['user']))
            $result .= '<button name="deleteOrNot" value="delete">Delete</button>';
        $result .= '</form> </div>';
        // Add more code below. You will need to hold the buttons in an HTML <form>      
        // This is kind of like adding onclick in Best Reads Two
    }
    
    return $result;
}
?>