<?php

if( function_exists('acf_add_options_page') ) 
    acf_add_options_page(array(
        'page_title' => 'Theme Options',
        'menu_title' => 'Theme Options',
        'menu_slug' => 'theme-options',
        'capability' => 'edit_posts',
        'redirect' => false
    ));

    acf_add_local_field_group(array(
        'key' => 'group_60f2ba6eaf26a',
        'title' => 'Site Settings',
        'fields' => array(
            array(
                'key' => 'field_60f2ay6b041d7',
                'label' => 'Site Name',
                'name' => 'site_name',
                'type' => 'text',
                'return_format' => 'text',
                'instructions' => 'Write down the site name',
            ),
            array(
                'key' => 'field_60f2ba7b044d7',
                'label' => 'Logo',
                'name' => 'site_logo',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
                'instructions' => 'Upload your site logo',
            ),
            array(
                'key' => 'field_10f2ao6b041d7',
                'label' => 'Site Descripton',
                'name' => 'site_description',
                'type' => 'textarea',
                'return_format' => 'text',
                'instructions' => 'Write down the site description',
            ),
            array(
                'key' => 'field_10f2ba7b022d7',
                'label' => 'Default Featured Image',
                'name' => 'site_default_featured_image',
                'type' => 'image',
                'return_format' => 'url',
                'instructions' => 'Upload Default Featured Image',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-options',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

    acf_add_local_field_group(array(
        'key' => 'group_20f2ba6gsf26a',
        'title' => 'Footer Settings',
        'fields' => array(
            array(
                'key' => 'field_10f2ay8b041d7',
                'label' => 'Footer Header',
                'name' => 'footer_header',
                'type' => 'text',
                'return_format' => 'text',
                'instructions' => 'Write down the footer header',
            ),
            array(
                'key' => 'field_50g2ba7a044d7',
                'label' => 'Footer Logo',
                'name' => 'site_footer_logo',
                'type' => 'image',
                'return_format' => 'url',
                'instructions' => 'Upload your site logo',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-options',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    