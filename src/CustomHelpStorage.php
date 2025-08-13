<?php

namespace Drupal\custom_help;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Entity\EntityTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Cache\MemoryCache\MemoryCacheInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Path\PathMatcherInterface;

/**
 * Defines the storage handler class for custom help text.
 *
 * This extends the base storage class, adding required special handling for
 * custom help text.
 */
class CustomHelpStorage extends SqlContentEntityStorage implements CustomHelpStorageInterface {

  /**
   * Array of page paths indexed by their help text entity ID.
   *
   * @var string[]
   */
  protected $pageIndex = NULL;

  /**
   * The path matcher.
   *
   * @var \Drupal\Core\Path\PathMatcherInterface
   */
  protected $pathMatcher;

  /**
   * Constructs a SqlContentEntityStorage object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection to be used.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The entity field manager.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   The cache backend to be used.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   * @param \Drupal\Core\Cache\MemoryCache\MemoryCacheInterface $memory_cache
   *   The memory cache backend to be used.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_type_bundle_info
   *   The entity type bundle info.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Path\PathMatcherInterface $path_matcher
   *   The path matcher service.
   */
  public function __construct(EntityTypeInterface $entity_type, Connection $database, EntityFieldManagerInterface $entity_field_manager, CacheBackendInterface $cache, LanguageManagerInterface $language_manager, MemoryCacheInterface $memory_cache, EntityTypeBundleInfoInterface $entity_type_bundle_info, EntityTypeManagerInterface $entity_type_manager, PathMatcherInterface $path_matcher) {
    parent::__construct($entity_type, $database, $entity_field_manager, $cache, $language_manager, $memory_cache, $entity_type_bundle_info, $entity_type_manager);
    $this->pathMatcher = $path_matcher;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('database'),
      $container->get('entity_field.manager'),
      $container->get('cache.entity'),
      $container->get('language_manager'),
      $container->get('entity.memory_cache'),
      $container->get('entity_type.bundle.info'),
      $container->get('entity_type.manager'),
      $container->get('path.matcher')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function loadByPathMatch(string $path) {
    $entities = [];
    foreach ($this->getPageIndex() as $text_id => $patterns) {
      if ($this->pathMatcher->matchPath($path, $patterns)) {
        $entities[] = $text_id;
      }
    }

    return $entities ? $this->loadMultiple($entities) : [];
  }

  /**
   * Get all the custom help and their page patterns.
   *
   * @return string[]
   *   Custom help page patterns indexed by ID. Empty array if none found.
   */
  protected function getPageIndex() {
    if (!isset($this->pageIndex)) {
      $this->pageIndex = [];
      $query = $this->database->select($this->getDataTable(), 'c');
      $result = $query
        ->fields('c', ['id', 'pages'])
        ->condition('c.status', 1)
        ->isNotNull('c.pages')
        ->orderBy('c.title')
        ->execute();
      foreach ($result as $text) {
        $this->pageIndex[$text->id] = $text->pages;
      }
    }

    return $this->pageIndex;
  }

  /**
   * {@inheritdoc}
   */
  public function resetCache(array $ids = NULL) {
    $this->pageIndex = NULL;
    parent::resetCache($ids);
  }

  /**
   * {@inheritdoc}
   */
  public function __sleep(): array {
    $vars = parent::__sleep();
    // Do not serialize static cache.
    unset($vars['pageIndex']);
    return $vars;
  }

  /**
   * {@inheritdoc}
   */
  public function __wakeup(): array {
    parent::__wakeup();
    // Initialize static caches.
    $this->pageIndex = NULL;
  }

}
