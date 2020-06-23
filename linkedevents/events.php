<?php

$actionUrl = $_SERVER['REQUEST_URI'];
$page = strip_tags($_REQUEST['les-page']);
$page = $page ? trim($page) : null;
$baseUrl = $actionUrl . (empty($_REQUEST) ? '?' : '&') . (empty($page) ? 'les-page=' : '');
if ($page) {
  $baseUrl = substr($actionUrl, 0, -1 * (strlen($page)));
}
$previousPage = $baseUrl . (($page ?? 1) - 1);
$nextPage = $baseUrl . (($page ?? 1) + 1);

if (!function_exists("getLocalizedValue")) {

  /**
   * Returns localized value with given language
   * 
   * @param array values
   * @return string value in given language or in default language or empty string if neither is defined
   */
  function getLocalizedValue($values, $language)
  {
    $result = $values[$language];
    if (empty($result)) {
      $result = $values['fi'];
    }
    return $result ? $result : "";
  }
}

if (!function_exists("formatLocationAddress")) {

  /**
   * Formats location address 
   * 
   * @param \Metatavu\LinkedEvents\Model\Place $location location
   * @param string $language lanuage
   * @return string formated location address
   */
  function formatLocationAddress($location, $language)
  {
    // Address with venue
    $name = getLocalizedValue($location["name"], $language);
    return sprintf('%s', $name);

    // Address without venue
    // $streetAddress = getLocalizedValue($location["streetAddress"], $language);
    // $locality = getLocalizedValue($location["addressLocality"], $language);
    // return sprintf('%s, %s', $streetAddress, $locality);
  }
}

foreach ($data->events as $event) {
  include __DIR__ . "/event.php";
}

$result .= '<div class="linkedevents-page-navigation">';
if ($page > 1) {
  $result .= sprintf('<a href="%s" title="Edellinen sivu">&#10094; Edellinen</a>', $previousPage);
}
$result .= sprintf('<a href="%s" title="Seuraava sivu">Seuraava &#10095;</a>', $nextPage);
$result .= '</div>';
echo $result;
