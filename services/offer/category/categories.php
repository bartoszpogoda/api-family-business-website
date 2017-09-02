 <?php
  include '../../global.php';

  /**
  *   Handles GET request to return item categories with their metadata names
  */
  $categoryList = getCategoryList();
  echo json_encode($categoryList);
?>

<?php
  function getCategoryList() {
    $categoryList = array();

    if(!$categoriesDirectory = opendir(getBasePath() . getCategoriesPath())) {
        throwErrorJSON(400, "There is no such category");
    }

    while($category = readdir($categoriesDirectory)) {
      if(!is_dir($category)) {
        $metadata = getXMLMetadata(getBasePath() . getCategoriesPath() . '/' . $category);
        if($metadata != NULL) {
          $categoryItem = array(
            'id' => "$category",
            'orderId' => "$metadata->order",
            'name' => "$metadata->name",
            'icon' => getResPath() . '/' . getIconsPath() . '/' . "$metadata->icon"
          );
          array_push($categoryList, $categoryItem);
        }
      }
    }
    return $categoryList;
  }
 ?>
