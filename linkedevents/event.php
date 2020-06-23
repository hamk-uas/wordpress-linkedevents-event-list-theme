<?php
$language = $data->language;
$fieldConfig = $data->fieldConfig;
$fieldsToShow = empty($fieldConfig) ? [] : explode(',', $fieldConfig);
$eventName = getLocalizedValue($event["name"], $language);
$eventShortDescription = getLocalizedValue($event["shortDescription"], $language);
?>
<article class="linkedevents-event">
  <div class="linkedevents-event-header">

    <?php
    if (!empty($event["images"]) && in_array('images', $fieldsToShow)) {
      echo sprintf('<div class="linkedevents-event-header-image"><img class="linkedevents-event-header-image-img" src="%s"/></div>', $event["images"][0]["url"]);
    }
    ?>

    <div class="linkedevents-event-header-text">
      <h2 class="linkedevents-event-header-text-name">
        <?php echo $eventName; ?>
      </h2>
      <p class="linkedevents-event-header-text-description">
        <?php echo $eventShortDescription; ?>
      </p>
    </div>
  </div>
  <div class="linkedevents-event-fields">
    <?php
    $fieldSectionContent = '';
    foreach ($fieldsToShow as $field) {
      switch ($field) {
        case 'externalLinks':
          if (!empty($event["externalLinks"])) {
            $eventLink = $event["externalLinks"][0]["link"];
            if (!empty($eventLink)) {
              $fieldSectionContent .= sprintf('<div class="linkedevents-event-fields-field"><a href="%s" target="_blank">Lisätietoa</a></div>', $eventLink);
            }
          }
          break;
        case 'infoUrl':
          $eventInfoUrl = getLocalizedValue($event['infoUrl'], $language);
          if (!empty($eventInfoUrl)) {
            $fieldSectionContent .= sprintf('<div class="linkedevents-event-fields-field"><a href="%s" target="_blank">WWW</a></div>', $eventInfoUrl);
          }
          break;
        case 'location':
          $eventLocation = $event["location"];
          $location = $data->locations[$eventLocation["id"]];
          if (!empty($location)) {
            $fieldSectionContent .= sprintf('<div class="linkedevents-event-fields-field">%s</div>', formatLocationAddress($location, $language));
          }
          break;
        case 'startTime':
          if (!empty($event[$field])) {
            $fieldSectionContent .= sprintf('<div class="linkedevents-event-fields-field">Alkaa: %s</div>', $event[$field]->format("d.m.Y H:i"));
          }
          break;
        case 'endTime':
          if (!empty($event[$field])) {
            $fieldSectionContent .= sprintf('<div class="linkedevents-event-fields-field">Loppuu: %s</div>', $event[$field]->format("d.m.Y H:i"));
          }
          break;
        case 'accessible':
          $isAccessible = !empty($event[$field]) && $event[$field] == true;
          if ($isAccessible) {
            $fieldSectionContent .= sprintf('<div class="linkedevents-event-fields-field">%s</div>', 'Esteetön');
          }
          break;
        case 'offers':
          $offers = $event['offers'];
          if (!empty($offers)) {
            if ($offers[0]['isFree']) {
              $fieldSectionContent .= sprintf('<div class="linkedevents-event-fields-field">%s</div>', 'Maksuton');
            } else {
              $fieldSectionContent .= sprintf('<div class="linkedevents-event-fields-field">%s</div>', getLocalizedValue($offers[0]['price'], $language));
            }
          }
          break;
        case 'provider':
          $provider = $event['provider'];
          if (!empty($provider)) {
            $fieldSectionContent .= sprintf('<div class="linkedevents-event-fields-field">Järjestäjä: %s</div>', getLocalizedValue($provider, $language));
          }
          break;
          // Start: Fields not to be shown as fields
        case 'name':
        case 'shortDescription':
        case 'images':
          break;
          // End: Fields not to be shown as fields
      }
    }
    echo $fieldSectionContent;
    ?>
  </div>
</article>