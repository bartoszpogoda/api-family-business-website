<?php
  include '../global.php';
  include '../galleryService.php';


  /**
  *   Handles GET request to return photo items
  */

  /* REQUEST PARAMS */
  $paramAlbumId = 'albumId';

  $paramsArray = array($paramAlbumId);

  setJsonResponseTypeHeader();

    if(validateRequestParams($paramsArray)) {
        $albumId = $_GET[$paramAlbumId];
    } else {
        throwErrorJSON(400);
    }

    $album = getAlbum($albumId);
    echo json_encode($album);
?>

<?php

 function getAlbum($albumId) {
   $galleryService = new GalleryService();
     
   $THUMB_TARGET_HEIGHT = 800; 

   $photos = array();

   $albumDirectoryPath = getBasePath() . "/" . getAlbumsPath() . "/" . $albumId;

   if(!$albumDirectory = opendir($albumDirectoryPath)) {
       throwErrorJSON(400, "There is no such album.");
   }

   $metadata = getXMLMetadata($albumDirectoryPath);
    if($metadata != NULL) {
        $descUp = $metadata->{"desc_up"}->saveXML();
        $descBottom = $metadata->{"desc_bottom"}->saveXML();

        while($photoFile = readdir($albumDirectory)) {
         if($galleryService->isImage($photoFile)) {
     
             if(!$galleryService->doesThumbExist($albumDirectoryPath, $photoFile)){
                 $galleryService->generateThumb($albumDirectoryPath, $photoFile, $THUMB_TARGET_HEIGHT);
             }
     
             $photo = array(
                 'url' => "/" . getAlbumsPath() . "/" . $albumId . "/" . "$photoFile",
                 'thumbUrl' => "/" . getAlbumsPath() . "/" . $albumId . "/thumb/" . "$photoFile"
             );
     
             $photos["$photoFile"] = $photo;
         }
        }

        krsort($photos);

        $album = array(
            'id' => "$albumId",
            'title' => "$metadata->title",
            'descUp' => "$descUp",
            'descBottom' => "$descBottom",
            'icon' => '/' . getAlbumsPath() . '/' . $albumFile . '/thumb/' . "$metadata->cover",
            'photos' => array_values($photos)
        );
    }

    
   closedir($albumDirectory);

    return $album;

 }
?>
