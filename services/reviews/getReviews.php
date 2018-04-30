<?php
  include '../global.php';

  /**
  *   Handles GET request to return existing reviews.
  */

  /* REQUEST PARAMS */
  $paramStart = 'start';
  $paramLength = 'length';

  if(hasOptionalParam($paramStart)) {
    $start = $_GET[$paramStart];
  } else {
    $start = 0;
  }

  if(hasOptionalParam($paramLength)) {
    $length = $_GET[$paramLength];
  } else {
    $length = NULL;
  }

  $reviews = getReviews($start, $length);
  echo json_encode($reviews);
?>

<?php
 function getReviews($start, $length) {
   $reviews = array();

   if(!$reviewsDirectory = opendir(getBasePath() . getReviewsPath())) {
       throwErrorJSON(500, "There is no reviews directory");
   }

   while($reviewFile = readdir($reviewsDirectory)) {
     if(!is_dir($reviewFile)) {

      $review = simplexml_load_file(getBasePath() . getReviewsPath() . '/' . $reviewFile);

         $album = array(
           'id' => "$reviewFile",
           'created' => "$review->created",
           'source' => "$review->source",
           'firstname' => "$review->firstname",
           'lastname' => "$review->lastname",
           'content' => "$review->content"
         );
         $reviews["$reviewFile"] = $album;
     }
   }

    //    krsort($albums);

   if(is_null($length)) {
      return array_slice(array_values($reviews), $start);
   } else {
      return array_slice(array_values($reviews), $start, $length);
   }

 }
?>
