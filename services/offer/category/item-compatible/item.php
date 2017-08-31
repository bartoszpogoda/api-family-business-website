<?php
  include '../../../global.php';

  /**
  *   Handles GET request to return detailed information on requested item
  */

  /* REQUEST PARAMS */
  $paramItemId = 'itemId';

  $paramsArray = array($paramItemId);

  if(validateRequestParams($paramsArray)) {
    $itemId = $_GET[$paramItemId];

    $item = getItem($itemId);
    echo json_encode($item);
  } else {
    throwErrorJSON();
  }
?>

<?php
  function getItem($itemId) {
    $categoryId = getCategoryId($itemId);
    $itemPath = getBasePath() . getCategoriesPath() . '/' . $categoryId . '/' . $itemId . '.xml';

    if(file_exists($itemPath)) {
      $item = simplexml_load_file($itemPath);

      $desc = $item->desc->saveXML();
      $richDesc = $item->richdesc->saveXML();

      return array(
        'name' => "$item->name",
        'category' => "$categoryId",
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

  function getCategoryId($itemId) {
    if(!$categoriesDirectory = opendir(getBasePath() . getCategoriesPath())) {
      // error
    }

    while($category = readdir($categoriesDirectory)) {
      if(file_exists(getBasePath() . getCategoriesPath() . '/' . $category . '/' . $itemId . '.xml' )) {
        closedir($categoriesDirectory);
        return $category;
      }
    }

    closedir($categoriesDirectory);
    throwErrorJSON(400, "There is no such an item");
  }
?>
