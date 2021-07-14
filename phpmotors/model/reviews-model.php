<?php

//This is the reviews model

//This function inserts a review into the database
function insertReview($reviewText, $reviewDate, $invId, $clientId){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect(); 
    $sql = 'INSERT INTO reviews (reviewText, reviewDate, invId, clientId)
         VALUES (:reviewText, :reviewDate, :invId, :clientId)';
    $stmt = $db->prepare($sql);
    // Replace the placeholders in the SQL
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewDate', $reviewDate, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT); 
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT); 
    //Insert data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

//This function returns reviews from an specific inventory item
function getInvReviews($invId){
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM reviews WHERE invId = :invId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $reviewsArr = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $reviewsArr; 
}

//This function returns the reviews written by an specific client
function getClientReviews($clientId){
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM reviews WHERE clientId = :clientId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $clientReviews = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $clientReviews; 

}

//This function gets a specific review using Id
function getReviewById($reviewId){
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM reviews WHERE reviewId = :reviewId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $reviewInfo = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $reviewInfo; 
}

//This function updates a specific review by Id
function updateReviewById($reviewId, $reviewText){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

//This function deletes a specific review by Id
function deleteReviewById($reviewId){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next line replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

?>