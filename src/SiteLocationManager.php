<?php

namespace Drupal\site_location;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Service description.
 */
class SiteLocationManager {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a SiteLocationManager object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The Config Factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Get Site Location config data.
   *
   * @throws \Exception
   */
  public function getConfigData() {
    $config = $this->configFactory->getEditable('site_location.settings');

    $timezone = new \DateTimeZone($config->get('timezone'));
    $time = new \DateTime("now", $timezone);

    return [
      'country' => $config->get('country'),
      'city' => $config->get('city'),
      'timezone' => $config->get('timezone'),
      'time' => $time->format('jS M Y - h:i A'),
    ];
  }

}
