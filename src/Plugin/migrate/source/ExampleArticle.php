<?php

namespace Drupal\migrate_728\Plugin\migrate\source;

use Drupal\node\Plugin\migrate\source\d7\Node;
use Drupal\migrate\Row;

/**
 * Class ExampleArticle.
 *
 * @MigrateSource(
 *   id = "example_article",
 * )
 */
class ExampleArticle extends Node {

  /**
   * {@inheritdoc}
   */
  public function query() {

    $query = parent::query();
    $query->join('field_data_body', 'b', 'b.entity_id = n.nid AND b.revision_id = n.vid');
    $query
      ->fields('b', [
        'body_value',
        'body_summary',
        'body_format',
      ]);

    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {

    $query = $this->select('field_data_field_tags', 't');
    $query
      ->fields('t', ['field_tags_tid'])
      ->condition('t.entity_id', $row->getSourceProperty('nid'))
      ->condition('t.revision_id', $row->getSourceProperty('vid'));

    if (isset($this->configuration['node_type'])) {
      $query->condition('t.bundle', $this->configuration['node_type']);
    }

    $row->setSourceProperty('tags', $query->execute()->fetchCol());

    return parent::prepareRow($row);
  }

}
