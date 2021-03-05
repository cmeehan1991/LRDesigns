<?php
	
	if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_homepage-editor',
		'title' => 'Homepage Editor',
		'fields' => array (
			array (
				'key' => 'field_5938076e7ba16',
				'label' => 'Hero ',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_5938080f7ba17',
				'label' => 'Hero Type',
				'name' => 'carousel',
				'type' => 'radio',
				'choices' => array (
					'Carousel' => 'Carousel',
					'Single Image' => 'Single Image',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'Carousel',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_593808617ba18',
				'label' => 'Upload Image',
				'name' => 'upload_image',
				'type' => 'image',
				'instructions' => 'Select a single image to be uploaded here. Images must be a minimum of 2560px by 850px',
				'required' => 1,
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5938080f7ba17',
							'operator' => '==',
							'value' => 'Single Image',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_593808ab7ba19',
				'label' => 'Carousel Item 1',
				'name' => 'carousel-1',
				'type' => 'image',
				'instructions' => 'Upload the first image here for a scrolling carousel. Images must be 2560px by 850px.',
				'required' => 1,
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5938080f7ba17',
							'operator' => '==',
							'value' => 'Carousel',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_59380d8fd3e75',
				'label' => 'Settings Carousel Item 1',
				'name' => 'settings_carousel_item_1',
				'type' => 'select',
				'instructions' => 'Select a setting',
				'required' => 1,
				'choices' => array (
					'Full-Width' => 'Full-Width',
					'Caption Left' => 'Caption Left',
					'Caption Right' => 'Caption Right',
				),
				'default_value' => 'Full-Width',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_59380e2a38b62',
				'label' => 'Caption Text',
				'name' => 'caption_text_1',
				'type' => 'wysiwyg',
				'required' => 1,
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_59380d8fd3e75',
							'operator' => '==',
							'value' => 'Caption Left',
						),
						array (
							'field' => 'field_59380d8fd3e75',
							'operator' => '==',
							'value' => 'Caption Right',
						),
					),
					'allorany' => 'any',
				),
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_5938093b7ba1a',
				'label' => 'Carousel Item 2',
				'name' => 'carousel-2',
				'type' => 'image',
				'instructions' => 'Upload the first image here for a scrolling carousel. Images must be 2560px by 850px.',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5938080f7ba17',
							'operator' => '==',
							'value' => 'Carousel',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_59380df76dec9',
				'label' => 'Settings Carousel Item 2',
				'name' => 'settings_carousel_item_2',
				'type' => 'select',
				'instructions' => 'Select a setting',
				'required' => 1,
				'choices' => array (
					'Full-Width' => 'Full-Width',
					'Caption Left' => 'Caption Left',
					'Caption Right' => 'Caption Right',
				),
				'default_value' => 'Full-Width',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_59380e5938b65',
				'label' => 'Caption Text ',
				'name' => 'caption_text_2',
				'type' => 'wysiwyg',
				'required' => 1,
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_59380df76dec9',
							'operator' => '==',
							'value' => 'Caption Left',
						),
						array (
							'field' => 'field_59380df76dec9',
							'operator' => '==',
							'value' => 'Caption Right',
						),
					),
					'allorany' => 'any',
				),
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_593809947ba1b',
				'label' => 'Carousel Item 3',
				'name' => 'carousel-3',
				'type' => 'image',
				'instructions' => 'Upload the first image here for a scrolling carousel. Images must be 2560px by 850px.',
				'required' => 1,
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5938080f7ba17',
							'operator' => '==',
							'value' => 'Carousel',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_59380e046deca',
				'label' => 'Settings Carousel Item 3',
				'name' => 'settings_carousel_item_3',
				'type' => 'select',
				'instructions' => 'Select a setting',
				'required' => 1,
				'choices' => array (
					'Full-Width' => 'Full-Width',
					'Caption Left' => 'Caption Left',
					'Caption Right' => 'Caption Right',
				),
				'default_value' => 'Full-Width',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_59380e927c9b5',
				'label' => 'Caption Text	',
				'name' => 'caption_text_3',
				'type' => 'wysiwyg',
				'required' => 1,
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_59380e046deca',
							'operator' => '==',
							'value' => 'Caption Left',
						),
						array (
							'field' => 'field_59380e046deca',
							'operator' => '==',
							'value' => 'Caption Right',
						),
					),
					'allorany' => 'any',
				),
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_593809b57ba1c',
				'label' => 'Main Content',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_593809e97ba1d',
				'label' => 'Main Content',
				'name' => 'main_content',
				'type' => 'wysiwyg',
				'required' => 1,
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-templates/page-home.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
			),
		),
		'menu_order' => 0,
	));
}
