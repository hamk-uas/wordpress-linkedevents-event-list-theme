<?php

$actionUrl = $_SERVER['REQUEST_URI'];
$page = strip_tags($_REQUEST['les-page']);
$page = $page ? trim($page) : null;
$baseUrl = $actionUrl . (empty($_REQUEST) ? '?' : '&') . (empty($page) ? 'les-page=' : '');
if ($page) {
  $baseUrl = substr($actionUrl, 0, -1 * (strlen($page)));
}
$previousPageUrl = $baseUrl . (($page ?? 1) - 1);
$nextPageUrl = $baseUrl . (($page ?? 1) + 1);

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

if (!function_exists("getTranslation")) {
  /**
   * Returns translation for given key in given language
   * 
   * @param string translationKey
   * @return string language (fi/en/sv)
   */
  function getTranslation($translationKey, $language)
  {
    $translations = array(
      'organizer' => array(
        'fi' => 'Järjestäjä',
        'en' => 'Organizer',
        'sv' => 'Anordnare'
      ),
      'information' => array(
        'fi' => 'Lisätietoa',
        'en' => 'Information',
        'sv' => 'Information'
      ),
      'accessible' => array(
        'fi' => 'Esteetön',
        'en' => 'Accessible',
        'sv' => 'Åtkomlig'
      ),
      'startsAt' => array(
        'fi' => 'Alkaa',
        'en' => 'Starts at',
        'sv' => 'Start'
      ),
      'ends' => array(
        'fi' => 'Loppuu',
        'en' => 'Ends',
        'sv' => 'Slut'
      ),
      'free' => array(
        'fi' => 'Maksuton',
        'en' => 'Free of charge',
        'sv' => 'Kostnadsfri'
      ),
      'previous' => array(
        'fi' => 'Edellinen',
        'en' => 'Previous',
        'sv' => 'Förra'
      ),
      'next' => array(
        'fi' => 'Seuraava',
        'en' => 'Next',
        'sv' => 'Nästä'
      )
    );
    return $translations[$translationKey][empty($language) ? 'fi' : $language] ?? '';
  }
}

foreach ($data->events as $event) {
  include __DIR__ . "/event.php";
}

$result .= '<div class="linkedevents-page-navigation">';
if ($page > 1) {
  $previousPageLinkText = getTranslation('previous', $language);
  $result .= sprintf('<a href="%s" title="%s">&#10094; %s</a>', $previousPageUrl, $previousPageLinkText, $previousPageLinkText);
}
$nextPageLinkText = getTranslation('next', $language);
$result .= sprintf('<a href="%s" title="%s">%s &#10095;</a>', $nextPageUrl, $nextPageLinkText, $nextPageLinkText);
$result .= '</div>';
echo $result;
