<?php

  $result = "";
  $result .= '<article>';
  $result .= '<div>';

  $eventLocation = $event["location"];
  $eventName = getLocalizedValue($event["name"], "fi");
  $eventLink = $event["externalLinks"][0]["link"];
  $eventDescription = getLocalizedValue($event["description"], "fi");
  $eventTime = $event["startTime"]->format("l jS F Y G:ia");
  $location = $data->locations[$eventLocation["id"]];

  $result .= '<div style="float: right">';
  foreach ($event["images"] as $image) {
    $result .= sprintf('<img style="max-width: 200px; margin-right: 5px;" src="%s"/>', $image["url"]);
  }
  $result .= '</div>';

  $result .= sprintf('<a href="%s">%s</a>', $eventLink, $eventName);
  $result .= '<div>';
  $result .= sprintf('<p>%s</p>', $eventTime);
  
  if ($location) {
    $address = formatLocationAddress($location, "fi");
    $result .= $address;
  }

  $result .= sprintf('<p style="font-style: italic">%s</p>', nl2br(html_entity_decode($eventDescription)));
  $result .= '</div>';

  $result .= '</div>';
  $result .= '</article>';

  echo $result;
?>