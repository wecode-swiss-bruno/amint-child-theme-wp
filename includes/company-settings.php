<?php

// Company Settings and Menu Locations
// This file handles company information page options and footer menu locations

// Register menu locations
function snn_register_footer_menu_locations() {
    register_nav_menus(array(
        'footer_1' => __('Footer 1', 'snn'),
        'footer_2' => __('Footer 2', 'snn'), 
        'footer_legal_links' => __('Footer Legal Links', 'snn')
    ));
}
add_action('after_setup_theme', 'snn_register_footer_menu_locations');

// Add company information fields automatically
function snn_add_company_information_fields() {
    $existing_fields = get_option('snn_custom_fields', []);
    
    // Define company information fields
    $company_fields = [
        [
            'group_name' => 'Informations de l\'entreprise',
            'label' => 'Nom de l\'entreprise',
            'name' => 'company_name',
            'type' => 'text',
            'post_type' => [],
            'taxonomies' => [],
            'choices' => '',
            'repeater' => 0,
            'author' => 0,
            'options_page' => 1,
            'column_width' => 50,
            'return_full_url' => 0,
        ],
        [
            'group_name' => 'Informations de l\'entreprise',
            'label' => 'Adresse complète',
            'name' => 'company_address',
            'type' => 'textarea',
            'post_type' => [],
            'taxonomies' => [],
            'choices' => '',
            'repeater' => 0,
            'author' => 0,
            'options_page' => 1,
            'column_width' => 50,
            'return_full_url' => 0,
        ],
        [
            'group_name' => 'Informations de l\'entreprise',
            'label' => 'Téléphone',
            'name' => 'company_phone',
            'type' => 'text',
            'post_type' => [],
            'taxonomies' => [],
            'choices' => '',
            'repeater' => 0,
            'author' => 0,
            'options_page' => 1,
            'column_width' => 50,
            'return_full_url' => 0,
        ],
        [
            'group_name' => 'Informations de l\'entreprise',
            'label' => 'Email',
            'name' => 'company_email',
            'type' => 'email',
            'post_type' => [],
            'taxonomies' => [],
            'choices' => '',
            'repeater' => 0,
            'author' => 0,
            'options_page' => 1,
            'column_width' => 50,
            'return_full_url' => 0,
        ],
        [
            'group_name' => 'Informations de l\'entreprise',
            'label' => 'Site web',
            'name' => 'company_website',
            'type' => 'url',
            'post_type' => [],
            'taxonomies' => [],
            'choices' => '',
            'repeater' => 0,
            'author' => 0,
            'options_page' => 1,
            'column_width' => 50,
            'return_full_url' => 0,
        ],
        [
            'group_name' => 'Informations de l\'entreprise',
            'label' => 'Slogan',
            'name' => 'company_slogan',
            'type' => 'text',
            'post_type' => [],
            'taxonomies' => [],
            'choices' => '',
            'repeater' => 0,
            'author' => 0,
            'options_page' => 1,
            'column_width' => 100,
            'return_full_url' => 0,
        ],
        [
            'group_name' => 'Informations de l\'entreprise',
            'label' => 'Texte de copyright du footer',
            'name' => 'footer_copyright_text',
            'type' => 'textarea',
            'post_type' => [],
            'taxonomies' => [],
            'choices' => '',
            'repeater' => 0,
            'author' => 0,
            'options_page' => 1,
            'column_width' => 100,
            'return_full_url' => 0,
        ],
        [
            'group_name' => 'Informations de l\'entreprise',
            'label' => 'Logos du footer',
            'name' => 'footer_logos',
            'type' => 'media',
            'post_type' => [],
            'taxonomies' => [],
            'choices' => '',
            'repeater' => 1,
            'author' => 0,
            'options_page' => 1,
            'column_width' => 100,
            'return_full_url' => 0,
        ]
    ];

    // Social networks fields
    $social_networks = [
        'facebook' => 'Facebook',
        'twitter' => 'Twitter', 
        'instagram' => 'Instagram',
        'linkedin' => 'LinkedIn',
        'youtube' => 'YouTube',
        'tiktok' => 'TikTok'
    ];

    foreach ($social_networks as $network => $label) {
        $company_fields[] = [
            'group_name' => 'Réseaux sociaux',
            'label' => $label,
            'name' => 'social_' . $network,
            'type' => 'url',
            'post_type' => [],
            'taxonomies' => [],
            'choices' => '',
            'repeater' => 0,
            'author' => 0,
            'options_page' => 1,
            'column_width' => 50,
            'return_full_url' => 0,
        ];
    }

    // Check if fields already exist to avoid duplicates
    $existing_field_names = array_column($existing_fields, 'name');
    $new_fields = [];
    
    foreach ($company_fields as $field) {
        if (!in_array($field['name'], $existing_field_names)) {
            $new_fields[] = $field;
        }
    }

    // Add new fields to existing ones
    if (!empty($new_fields)) {
        $updated_fields = array_merge($existing_fields, $new_fields);
        update_option('snn_custom_fields', $updated_fields);
    }
}

// Run on theme activation or when this file is first included
add_action('after_setup_theme', 'snn_add_company_information_fields');

// Helper functions to get company information
function snn_get_company_info($field_name) {
    return get_option('snn_opt_' . $field_name, '');
}

function snn_get_social_network_url($network) {
    return get_option('snn_opt_social_' . $network, '');
}

function snn_get_footer_logos() {
    return get_option('snn_opt_footer_logos', []);
}

// Display footer menu helper function
function snn_display_footer_menu($location, $menu_class = '') {
    if (has_nav_menu($location)) {
        wp_nav_menu(array(
            'theme_location' => $location,
            'menu_class' => $menu_class,
            'container' => false,
            'fallback_cb' => false
        ));
    }
}

// Add admin notice to inform about the new options page
function snn_company_settings_admin_notice() {
    $screen = get_current_screen();
    if ($screen->id === 'themes') {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p><strong>SNN Theme:</strong> Les paramètres de l\'entreprise ont été ajoutés. ';
        echo 'Vous pouvez maintenant configurer les informations de votre entreprise dans ';
        echo '<a href="' . admin_url('admin.php?page=snn_options_informations_de_l_entreprise') . '">Informations de l\'entreprise</a> et ';
        echo '<a href="' . admin_url('admin.php?page=snn_options_reseaux_sociaux') . '">Réseaux sociaux</a>.</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'snn_company_settings_admin_notice');

?>
