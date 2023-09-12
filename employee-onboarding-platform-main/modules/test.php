<?php if (function_exists('acf_add_local_field_group')): ?>
  <?php acf_add_local_field_group(array(
    'key' => 'group_60f30e5ebd86a',
    'title' => 'Test',
    'fields' => array(
      array(
        'key' => 'field_60f30e6dbd86b',
        'label' => 'Test',
        'name' => 'test_editor',
        'type' => 'wysiwyg',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'post',
        ),
      ),
    ),
  )); ?>
<?php endif; ?>
