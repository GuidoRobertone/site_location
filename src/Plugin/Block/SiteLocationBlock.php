<?php

namespace Drupal\site_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\site_location\SiteLocationManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a site location block.
 *
 * @Block(
 *   id = "site_location",
 *   admin_label = @Translation("Site Location"),
 *   category = @Translation("Site Location")
 * )
 */
class SiteLocationBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The Site Location Manager.
   *
   * @var \Drupal\site_location\SiteLocationManager
   */
  protected $siteLocationManager;

  /**
   * Construct a new SiteLocationBlock object.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\site_location\SiteLocationManager $site_location_manager
   *   The Site Location Manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, SiteLocationManager $site_location_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->siteLocationManager = $site_location_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('site_location.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $data = $this->siteLocationManager->getConfigData();

    return [
      '#theme' => 'site_location_block',
      '#country' => $data['country'],
      '#city' => $data['city'],
      '#timezone' => $data['timezone'],
      '#time' => $data['time'],
      '#cache' => [
        'contexts' => [
          'user',
        ],
      ],
    ];
  }

}
