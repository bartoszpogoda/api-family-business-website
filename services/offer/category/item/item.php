<?php
  include '../../../global.php';

  /**
  *   Handles GET request to return detailed information on requested item
  */

  /* REQUEST PARAMS */
  $paramCategoryId = 'categoryId';
  $paramItemId = 'itemId';

  $paramsArray = array($paramCategoryId, $paramItemId);

  if(validateRequestParams($paramsArray)) {
    $categoryId = $_GET[$paramCategoryId];
    $itemId = $_GET[$paramItemId];

    $item = getItem($categoryId, $itemId);
    echo json_encode($item);
  } else {
    throwErrorJSON();
  }
?>

<?php
  function getItem($categoryId, $itemId) {
    $itemPath = getBasePath() . getCategoriesPath() . '/' . $categoryId . '/' . $itemId . '.xml';

    if(file_exists($itemPath)) {
      $item = simplexml_load_file($itemPath);

      $desc = $item->desc->saveXML();
      $richDesc = $item->richdesc->saveXML();

      return array(
        'name' => "$item->name",
        'icon' => getResPath() . '/' . getIconsPath() . '/' . "$item->icon",
        'desc' => "$desc",
        'richDesc' => "$richDesc",
        'price' => "$item->price",
        'priceInfo' => "$item->price_info"
      );
    } else {
      throwErrorJSON(400, "There is no such an item");
    }
  }
?>
