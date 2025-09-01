<?php

// Company Information Shortcodes
// These shortcodes allow easy access to company information without PHP code

// Company Information Shortcodes
function snn_company_name_shortcode($atts) {
    return esc_html(get_company_name());
}
add_shortcode('company_name', 'snn_company_name_shortcode');

function snn_company_address_shortcode($atts) {
    $atts = shortcode_atts([
        'br' => 'true' // Convert line breaks to <br> tags
    ], $atts);
    
    $address = get_company_address();
    if ($atts['br'] === 'true') {
        return nl2br(esc_html($address));
    }
    return esc_html($address);
}
add_shortcode('company_address', 'snn_company_address_shortcode');

function snn_company_phone_shortcode($atts) {
    $atts = shortcode_atts([
        'link' => 'false', // Wrap in tel: link
        'text' => '' // Custom text for link
    ], $atts);
    
    $phone = get_company_phone();
    if (empty($phone)) return '';
    
    if ($atts['link'] === 'true') {
        $link_text = !empty($atts['text']) ? esc_html($atts['text']) : esc_html($phone);
        return '<a href="tel:' . esc_attr($phone) . '">' . $link_text . '</a>';
    }
    
    return esc_html($phone);
}
add_shortcode('company_phone', 'snn_company_phone_shortcode');

function snn_company_email_shortcode($atts) {
    $atts = shortcode_atts([
        'link' => 'false', // Wrap in mailto: link
        'text' => '' // Custom text for link
    ], $atts);
    
    $email = get_company_email();
    if (empty($email)) return '';
    
    if ($atts['link'] === 'true') {
        $link_text = !empty($atts['text']) ? esc_html($atts['text']) : esc_html($email);
        return '<a href="mailto:' . esc_attr($email) . '">' . $link_text . '</a>';
    }
    
    return esc_html($email);
}
add_shortcode('company_email', 'snn_company_email_shortcode');

function snn_company_website_shortcode($atts) {
    $atts = shortcode_atts([
        'link' => 'false', // Wrap in link
        'text' => '', // Custom text for link
        'target' => '_self' // Link target
    ], $atts);
    
    $website = get_company_website();
    if (empty($website)) return '';
    
    if ($atts['link'] === 'true') {
        $link_text = !empty($atts['text']) ? esc_html($atts['text']) : esc_html($website);
        return '<a href="' . esc_url($website) . '" target="' . esc_attr($atts['target']) . '">' . $link_text . '</a>';
    }
    
    return esc_html($website);
}
add_shortcode('company_website', 'snn_company_website_shortcode');

function snn_company_slogan_shortcode($atts) {
    return get_company_slogan();
}
add_shortcode('company_slogan', 'snn_company_slogan_shortcode');

function snn_footer_copyright_shortcode($atts) {
    $atts = shortcode_atts([
        'year' => 'true' // Add current year
    ], $atts);
    
    $copyright = get_footer_copyright();
    
    if ($atts['year'] === 'true' && !empty($copyright)) {
        $current_year = date('Y');
        // Replace [year] placeholder if it exists, otherwise prepend year
        if (strpos($copyright, '[year]') !== false) {
            $copyright = str_replace('[year]', $current_year, $copyright);
        } else {
            $copyright = '© ' . $current_year . ' ' . $copyright;
        }
    }
    
    return esc_html($copyright);
}
add_shortcode('footer_copyright', 'snn_footer_copyright_shortcode');

function snn_footer_logos_shortcode($atts) {
    $atts = shortcode_atts([
        'size' => 'medium',
        'class' => 'footer-logos',
        'width' => '100px',
        'link' => 'false' // Link to company website
    ], $atts);
    
    $logos = get_footer_logos();
    if (empty($logos)) return '';
    
    $output = '<div class="' . esc_attr($atts['class']) . '">';
    
    foreach ($logos as $logo_id) {
        if (!is_numeric($logo_id)) continue;
        
        $image = wp_get_attachment_image($logo_id, $atts['size'], false, ['class' => 'footer-logo', 'style' => 'width: ' . $atts['width'] . ';']);
        
        if ($atts['link'] === 'true') {
            $website = get_company_website();
            if (!empty($website)) {
                $output .= '<a href="' . esc_url($website) . '">' . $image . '</a>';
            } else {
                $output .= $image;
            }
        } else {
            $output .= $image;
        }
    }
    
    $output .= '</div>';
    
    return $output;
}
add_shortcode('footer_logos', 'snn_footer_logos_shortcode');

// Social Network Shortcodes
function snn_social_network_shortcode($atts, $content = null, $tag = '') {
    $network = str_replace('social_', '', $tag);
    
    $atts = shortcode_atts([
        'link' => 'false',
        'text' => '',
        'target' => '_blank',
        'icon' => 'false',
        'class' => 'social-link social-' . $network
    ], $atts);
    
    $url = snn_get_social_network_url($network);
    if (empty($url)) return '';
    
    if ($atts['link'] === 'false') {
        return esc_url($url);
    }
    
    // Determine link text
    $link_text = '';
    if (!empty($atts['text'])) {
        $link_text = esc_html($atts['text']);
    } elseif ($atts['icon'] === 'true') {
        // Icon mapping
        $icons = [
            'facebook' => '<i class="fab fa-facebook-f" aria-label="Facebook"></i>',
            'twitter' => '<i class="fab fa-twitter" aria-label="Twitter"></i>',
            'instagram' => '<i class="fab fa-instagram" aria-label="Instagram"></i>',
            'linkedin' => '<i class="fab fa-linkedin-in" aria-label="LinkedIn"></i>',
            'youtube' => '<i class="fab fa-youtube" aria-label="YouTube"></i>',
            'tiktok' => '<i class="fab fa-tiktok" aria-label="TikTok"></i>'
        ];
        $link_text = isset($icons[$network]) ? $icons[$network] : ucfirst($network);
    } else {
        $link_text = ucfirst($network);
    }
    
    return '<a href="' . esc_url($url) . '" target="' . esc_attr($atts['target']) . '" class="' . esc_attr($atts['class']) . '" rel="noopener noreferrer">' . $link_text . '</a>';
}

// Register individual social network shortcodes
add_shortcode('social_facebook', 'snn_social_network_shortcode');
add_shortcode('social_twitter', 'snn_social_network_shortcode');
add_shortcode('social_instagram', 'snn_social_network_shortcode');
add_shortcode('social_linkedin', 'snn_social_network_shortcode');
add_shortcode('social_youtube', 'snn_social_network_shortcode');
add_shortcode('social_tiktok', 'snn_social_network_shortcode');

// All social networks shortcode
function snn_all_social_networks_shortcode($atts) {
    $atts = shortcode_atts([
        'icons' => 'true',
        'target' => '_blank',
        'class' => 'social-networks',
        'separator' => '',
        'show_empty' => 'false'
    ], $atts);
    
    $social_networks = get_all_social_networks();
    if ($atts['show_empty'] === 'false') {
        $social_networks = array_filter($social_networks);
    }
    
    if (empty($social_networks)) return '';
    
    $output = '<div class="' . esc_attr($atts['class']) . '">';
    $links = [];
    
    foreach ($social_networks as $network => $url) {
        if (!empty($url)) {
            $shortcode_atts = [
                'link' => 'true',
                'target' => $atts['target'],
                'icon' => $atts['icons']
            ];
            
            $shortcode_atts_string = '';
            foreach ($shortcode_atts as $key => $value) {
                $shortcode_atts_string .= ' ' . $key . '="' . $value . '"';
            }
            
            $links[] = do_shortcode('[social_' . $network . $shortcode_atts_string . ']');
        }
    }
    
    $output .= implode($atts['separator'], $links);
    $output .= '</div>';
    
    return $output;
}
add_shortcode('social_networks', 'snn_all_social_networks_shortcode');

// Footer Menu Shortcodes
function snn_footer_menu_shortcode($atts, $content = null, $tag = '') {
    $location_map = [
        'footer_menu_1' => 'footer_1',
        'footer_menu_2' => 'footer_2',
        'footer_legal_menu' => 'footer_legal_links'
    ];
    
    $location = isset($location_map[$tag]) ? $location_map[$tag] : $tag;
    
    $atts = shortcode_atts([
        'class' => 'footer-menu ' . str_replace('_', '-', $location),
        'container' => 'nav',
        'fallback' => 'false'
    ], $atts);
    
    if (!has_nav_menu($location)) {
        return $atts['fallback'] === 'true' ? '<p>Menu not assigned</p>' : '';
    }
    
    ob_start();
    wp_nav_menu([
        'theme_location' => $location,
        'menu_class' => $atts['class'],
        'container' => $atts['container'] === 'false' ? false : $atts['container'],
        'fallback_cb' => false,
        'echo' => true
    ]);
    return ob_get_clean();
}

add_shortcode('footer_menu_1', 'snn_footer_menu_shortcode');
add_shortcode('footer_menu_2', 'snn_footer_menu_shortcode');
add_shortcode('footer_legal_menu', 'snn_footer_menu_shortcode');

// Company info combined shortcode
function snn_company_info_shortcode($atts) {
    $atts = shortcode_atts([
        'fields' => 'name,address,phone,email', // Comma-separated list of fields
        'wrapper' => 'div',
        'class' => 'company-info',
        'separator' => '<br>',
        'phone_link' => 'true',
        'email_link' => 'true'
    ], $atts);
    
    $fields = array_map('trim', explode(',', $atts['fields']));
    $output_parts = [];
    
    foreach ($fields as $field) {
        $value = '';
        
        switch ($field) {
            case 'name':
                $value = get_company_name();
                break;
            case 'address':
                $value = nl2br(get_company_address());
                break;
            case 'phone':
                $phone = get_company_phone();
                if (!empty($phone)) {
                    $value = $atts['phone_link'] === 'true' 
                        ? '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>'
                        : esc_html($phone);
                }
                break;
            case 'email':
                $email = get_company_email();
                if (!empty($email)) {
                    $value = $atts['email_link'] === 'true' 
                        ? '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>'
                        : esc_html($email);
                }
                break;
            case 'website':
                $value = get_company_website();
                break;
            case 'slogan':
                $value = get_company_slogan();
                break;
        }
        
        if (!empty($value)) {
            $output_parts[] = $value;
        }
    }
    
    if (empty($output_parts)) return '';
    
    $content = implode($atts['separator'], $output_parts);
    
    if ($atts['wrapper'] !== 'false') {
        $content = '<' . $atts['wrapper'] . ' class="' . esc_attr($atts['class']) . '">' . $content . '</' . $atts['wrapper'] . '>';
    }
    
    return $content;
}
add_shortcode('company_info', 'snn_company_info_shortcode');

?>
