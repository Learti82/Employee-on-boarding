<?php 
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_page_icons',
            'title' => 'Page Icons',
            'fields' => array(
                array(
                    'key' => 'field_menu_icon',
                    'label' => 'Menu Icon',
                    'name' => 'menu_icon',
                    'type' => 'image',
                    'instructions' => 'Add your menu icon here (PNG format).',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'nav_menu_item',
                        'operator' => '==',
                        'value' => 'all',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
        ));
    }
?>
