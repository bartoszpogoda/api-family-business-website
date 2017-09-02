<?php
  include '../global.php';

  /**
  *   Handles GET request to return album items
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

  $albums = getAlbums($start, $length);
  echo json_encode($albums);
?>

<?php
 function getAlbums($start, $length) {
   $albums = array();

   if(!$albumsDirectory = opendir(getBasePath() . getAlbumsPath())) {
       throwErrorJSON(400, "There is no albums directory");
   }

   while($albumFile = readdir($albumsDirectory)) {
     if(!is_dir($albumFile)) {
       $metadata = getXMLMetadata(getBasePath() . getAlbumsPath() . '/' . $albumFile);
       if($metadata != NULL) {
         $descUp = $metadata->{"desc_up"}->saveXML();
         $descBottom = $metadata->{"desc_bottom"}->saveXML();

         $album = array(
           'id' => "$albumFile",
           'title' => "$metadata->title",
           'descUp' => "$descUp",
           'icon' => '/' . getAlbumsPath() . '/' . $albumFile . '/thumb/' . "$metadata->cover"
         );
         $albums["$metadata->id"] = $album;
       }
     }
   }

   krsort($albums);

   if(is_null($length)) {
      return array_slice(array_values($albums), $start);
   } else {
      return array_slice(array_values($albums), $start, $length);
   }

 }
?>
