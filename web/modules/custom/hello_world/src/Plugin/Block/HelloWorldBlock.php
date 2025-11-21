<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Hello World' Block.
 */
#[Block(
  id: 'hello_world_block',
  admin_label: new TranslatableMarkup('Hello World Block'),
  category: new TranslatableMarkup('Custom')
)]
class HelloWorldBlock extends BlockBase implements ContainerFactoryPluginInterface
{

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Constructs a new HelloWorldBlock instance.
   *
   * @param array                                        $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string                                       $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed                                        $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    DateFormatterInterface $date_formatter
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->dateFormatter = $date_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('date.formatter')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    // Get the current day of the week using the date formatter service.
    // Format 'l' returns the full textual representation of the day.
    $day_of_week = $this->dateFormatter->format(time(), 'custom', 'l');

    // Construct the message with translation support.
    $message = $this->t('Hello World, Welcome to @day', ['@day' => $day_of_week]);

    return [
      '#markup' => $message,
    ];
  }

}


