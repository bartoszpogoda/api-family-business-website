<?php
// PROD
error_reporting(0);

// CONFIG
$CFG_BASE_WWW_PATH = $_SERVER['DOCUMENT_ROOT'] . '/';

$CFG_RESOURCE_PATH = '/res';

$CFG_CATEGORIES_PATH = 'res/oferta-items';
$CFG_ALBUMS_PATH = 'res/photos';
$CFG_USERS_PATH = 'res/users';
$CFG_SESSIONS_PATH = 'res/sessions';
$CFG_REVIEWS_PATH = 'res/reviews';
$CFG_ICONS_PATH = 'thumbs';


// UTIL FUNCTIONS
function getXMLMetadata($itemPath) {
  $metadataPath = $itemPath . '/metadata.xml';
  if(file_exists($metadataPath)) {
    return simplexml_load_file($metadataPath);
  } else {
    return NULL;
  }
}

function validateRequestParams($paramsArray) {
  foreach ($paramsArray as $param) {
    if(!isset($_GET[$param])) {
      return false;
    }
  }

  return true;
}

function hasOptionalParam($param) {
  if(!isset($_GET[$param])) {
    return false;
  }

  return true;
}

function throwErrorJSON($code = 400, $message = "") {
  $jsonError = array(
    'message' => "$message"
  );

  http_response_code($code);
  echo json_encode($jsonError);
  die();
}

function setJsonResponseTypeHeader() {
  header('Content-Type: application/json');
}

function omitXMLExt($path) {
  return str_replace (".xml" , "" , $path);
}

function getBasePath() {
  global $CFG_BASE_WWW_PATH;
  return $CFG_BASE_WWW_PATH;
}

function getResPath() {
  global $CFG_RESOURCE_PATH;
  return $CFG_RESOURCE_PATH;
}

function getCategoriesPath() {
  global $CFG_CATEGORIES_PATH;
  return $CFG_CATEGORIES_PATH;
}

function getAlbumsPath() {
  global $CFG_ALBUMS_PATH;
  return $CFG_ALBUMS_PATH;
}

function getReviewsPath() {
  global $CFG_REVIEWS_PATH;
  return $CFG_REVIEWS_PATH;
}

function getIconsPath() {
  global $CFG_ICONS_PATH;
  return $CFG_ICONS_PATH;
}

function getUsersPath() {
  global $CFG_USERS_PATH;
  return $CFG_USERS_PATH;
}

function getSessionsPath() {
  global $CFG_SESSIONS_PATH;
  return $CFG_SESSIONS_PATH;
}

?>
