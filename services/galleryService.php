
<?php
  abstract class FileType {
    const OTHER = 0;
    const FOLDER = 1;
    const XML = 2;
    const PNG = 3;
    const JPG = 4;
  }

  class GalleryService {

    // should be called only if thumbnail doesnt exist (for performance)
    function generateThumb($albumPath, $imageFile, $thumbTargetHeight) {
      $fileType = $this->getFileType($imageFile);
      $imagePath = $albumPath . '/' . $imageFile;
      $imageThumbnailPath = $albumPath . '/thumb/' . $imageFile;
      
      $image;
      $resizedImage;

      if($fileType == FileType::JPG) {
        $image = imagecreatefromjpeg($imagePath);
      } elseif($fileType == FileType::PNG) {
        $image = imagecreatefrompng($imagePath);
      } else{
        return;
      }

      $this->generateThumbFolder($albumPath);

      $imageSize = getimagesize($imagePath);
      $imageNewWidth = $thumbTargetHeight * $imageSize[0] / $imageSize[1];
      $resizedImage = imagescale($image, $imageNewWidth);

      if($fileType == FileType::JPG) {
        imagejpeg($resizedImage, $imageThumbnailPath);
      } else {
        imagepng($resizedImage, $imageThumbnailPath);
      }

      imagedestroy($image); imagedestroy($resizedImage);
    }

    function generateThumbFolder($albumPath) {
      if(!file_exists($albumPath . '/thumb')){
        mkdir($albumPath . '/thumb');
      }
    }

    function doesThumbExist($albumPath, $imageFile) {
      $thubnailPath = $albumPath . '/thumb/' . trim($imageFile);
      if(file_exists($thubnailPath)) {
        return true;
      } else {
        return false;
      }
    }

    function getFileType($file) {
      $extension = pathinfo(trim($file), PATHINFO_EXTENSION);

      if(strcasecmp($extension,"jpg") == 0) {
        return FileType::JPG;
      }
      elseif(strcasecmp($extension,"png") == 0) {
        return FileType::PNG;
      } elseif(strcasecmp($extension,"xml") == 0) {
        return FileType::XML;
      }
      return FileType::OTHER; 
    }

    function isImage($file) {
      return $this->getFileType($file) == FileType::JPG ||
      $this->getFileType($file) == FileType::PNG;

    }
  }
?>
