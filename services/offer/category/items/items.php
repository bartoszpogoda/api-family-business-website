<?php
  include '../../../global.php';

  /**
  *   Handles GET request to return detailed information on requested item
  */
  
  /* REQUEST PARAMS */
  $paramCategoryId = 'categoryId';

  $paramsArray = array($paramCategoryId);

  if(validateRequestParams($paramsArray)) {
    $categoryId = $_GET[$paramCategoryId];

    $items = getItems($categoryId);
    echo json_encode($items);
  } else {
    throwErrorJSON();
  }
?>

<?php
  function getItems($categoryId) {
    $items = array();
    $categoryPath = getBasePath() . getCategoriesPath() . '/' . $categoryId;

    if(!$categoryDirectory = opendir($categoryPath)) {
        throwErrorJSON(400, "There is no such a category");
    } else {
      while($item = readdir($categoryDirectory)) {
        if(!is_dir($item) && $item != 'metadata.xml') {
          $itemXML = simplexml_load_file($categoryPath . '/' . $item);

          array_push($items, array(
            'id' => omitXMLExt($item),
            'orderId' => "$itemXML->order",
            'name' => "$itemXML->name",
            'icon' => getResPath() . '/' . getIconsPath() . '/' . "$itemXML->icon"
          ));
        }
      }
      return $items;
    }
  }
?>
