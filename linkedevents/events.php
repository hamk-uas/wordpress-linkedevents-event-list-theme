<?php

  if (!function_exists("getLocalizedValue")) {

    /**
     * Returns localized value with given language
     * 
     * @param array values
     * @return string value or empty string if not defined
     */
    function getLocalizedValue($values, $language) {
      $result = $values[$language];
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
    function formatLocationAddress($location, $language) {
      $name = getLocalizedValue($location["name"], $language);
      $streetAddress = getLocalizedValue($location["streetAddress"], $language);
      $postalCode = $location["postalCode"];
      $locality = getLocalizedValue($location["addressLocality"], $language);
      return sprintf('<p>%s, %s %s %s</p>', $name, $streetAddress, $postalCode, $locality);
    }

  }

  foreach ($data->events as $event) {
    include __DIR__ . "/event.php";
  }
?>