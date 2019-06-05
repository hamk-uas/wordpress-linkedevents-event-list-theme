<?php
  $result = "";

  $result .= '<article>';
  $result .= '<div>';
  
  $eventName = $event["name"]["fi"];
  $eventLink = $event["externalLinks"][0]["link"];
  $eventDescription = $event["description"]["fi"];
  $eventTime = $event["startTime"]->format("l jS F Y G:ia");

  $result .= sprintf('<a href="%s">%s</a>', $eventLink, $eventName);
  $result .= sprintf('<p>%s</p>', $eventTime);
  $result .= sprintf('<p style="color: red">%s</p>', html_entity_decode($eventDescription));
  
  $result .= '</div>';
  $result .= '</article>';

  echo $result;
?>