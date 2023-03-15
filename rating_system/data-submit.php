

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testing1";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['rating_value'])){

    $rating_value = mysqli_real_escape_string($conn, $_POST['rating_value']);
    $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    $p_id = mysqli_real_escape_string($conn, $_POST['p_id']);
    $userMessage = mysqli_real_escape_string($conn, $_POST['userMessage']);
    $now = time();
    
    $sql = "INSERT INTO review_table (user_name, user_rating, provider_id, user_review, datetime)
            VALUES ('$userName', '$rating_value','$p_id', '$userMessage', '$now')";

    if (mysqli_query($conn, $sql)) {
      echo "New Review Added Successfully";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

}

if(isset($_POST['action'])){

  $avgRatings = 0;
  $avgUserRatings = 0;
  $totalReviews = 0;
  $totalRatings5 = 0;
  $totalRatings4 = 0;
  $totalRatings3 = 0;
  $totalRatings2 = 0;
  $totalRatings1 = 0;
  $ratingsList = array();
  $totalRatings_avg = 0;

  if(!isset($_POST['p_id'])){
    echo "Error: Provider ID not specified.";
    exit;
  }

  $p_id = mysqli_real_escape_string($conn, $_POST['p_id']);

  $sql = "SELECT * FROM review_table WHERE provider_id = $p_id ORDER BY review_id DESC";
  $result = mysqli_query($conn, $sql);
 
  if(!$result){
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    exit;
  }

  while($row = mysqli_fetch_assoc($result)) {
    $ratingsList[] = array(
      'review_id' => $row['review_id'],
      'name' => $row['user_name'],
      'rating' => $row['user_rating'],
      'message' => $row['user_review'],
      'datetime' => date('l jS \of F Y h:i:s A',$row['datetime']) 
    );
    if($row['user_rating'] == '5'){
      $totalRatings5++;
    }
    if($row['user_rating'] == '4'){
      $totalRatings4++;
    }
    if($row['user_rating'] == '3'){
      $totalRatings3++;
    }
    if($row['user_rating'] == '2'){
      $totalRatings2++;
    }
    if($row['user_rating'] == '1'){
      $totalRatings1++;
    }
    $totalReviews++;
    $totalRatings_avg = $totalRatings_avg + intval($row['user_rating']);  
  }

  if($totalReviews > 0){
    $avgUserRatings = $totalRatings_avg / $totalReviews;
  }

  $output = array( 
    'avgUserRatings' => number_format($avgUserRatings, 1),
    'totalReviews' => $totalReviews,
    'totalRatings5' => $totalRatings5,
    'totalRatings4' => $totalRatings4,
    'totalRatings3' => $totalRatings3,
    'totalRatings2' => $totalRatings2,
    'totalRatings1' => $totalRatings1,
    'ratingsList' => $ratingsList
  );

  echo json_encode($output);
 





}



?>
