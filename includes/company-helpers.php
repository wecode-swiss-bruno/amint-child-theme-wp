<?php

// Company Information Helper Functions
// These functions provide easy access to company information and social networks

if (!function_exists('get_company_name')) {
    function get_company_name() {
        return snn_get_company_info('company_name');
    }
}

if (!function_exists('get_company_address')) {
    function get_company_address() {
        return snn_get_company_info('company_address');
    }
}

if (!function_exists('get_company_phone')) {
    function get_company_phone() {
        return snn_get_company_info('company_phone');
    }
}

if (!function_exists('get_company_email')) {
    function get_company_email() {
        return snn_get_company_info('company_email');
    }
}

if (!function_exists('get_company_website')) {
    function get_company_website() {
        return snn_get_company_info('company_website');
    }
}

if (!function_exists('get_company_slogan')) {
    function get_company_slogan() {
        return snn_get_company_info('company_slogan');
    }
}

if (!function_exists('get_footer_copyright')) {
    function get_footer_copyright() {
        return snn_get_company_info('footer_copyright_text');
    }
}

if (!function_exists('get_footer_logos')) {
    function get_footer_logos() {
        return snn_get_footer_logos();
    }
}

// Social Network Functions
if (!function_exists('get_social_facebook')) {
    function get_social_facebook() {
        return snn_get_social_network_url('facebook');
    }
}

if (!function_exists('get_social_twitter')) {
    function get_social_twitter() {
        return snn_get_social_network_url('twitter');
    }
}

if (!function_exists('get_social_instagram')) {
    function get_social_instagram() {
        return snn_get_social_network_url('instagram');
    }
}

if (!function_exists('get_social_linkedin')) {
    function get_social_linkedin() {
        return snn_get_social_network_url('linkedin');
    }
}

if (!function_exists('get_social_youtube')) {
    function get_social_youtube() {
        return snn_get_social_network_url('youtube');
    }
}

if (!function_exists('get_social_tiktok')) {
    function get_social_tiktok() {
        return snn_get_social_network_url('tiktok');
    }
}

// Get all social networks as array
if (!function_exists('get_all_social_networks')) {
    function get_all_social_networks() {
        return [
            'facebook' => get_social_facebook(),
            'twitter' => get_social_twitter(),
            'instagram' => get_social_instagram(),
            'linkedin' => get_social_linkedin(),
            'youtube' => get_social_youtube(),
            'tiktok' => get_social_tiktok()
        ];
    }
}

// Display social networks with icons
if (!function_exists('display_social_networks')) {
    function display_social_networks($show_icons = true, $target = '_blank', $css_class = 'social-links') {
        $social_networks = get_all_social_networks();
        $social_networks = array_filter($social_networks); // Remove empty values
        
        if (empty($social_networks)) {
            return;
        }
        
        echo '<div class="' . esc_attr($css_class) . '">';
        
        foreach ($social_networks as $network => $url) {
            if (!empty($url)) {
                echo '<a href="' . esc_url($url) . '" target="' . esc_attr($target) . '" rel="noopener noreferrer" class="social-link social-' . esc_attr($network) . '">';
                
                if ($show_icons) {
                    // You can customize these icons based on your theme
                    switch ($network) {
                        case 'facebook':
                            echo '<i class="fab fa-facebook-f" aria-label="Facebook"></i>';
                            break;
                        case 'twitter':
                            echo '<i class="fab fa-twitter" aria-label="Twitter"></i>';
                            break;
                        case 'instagram':
                            echo '<i class="fab fa-instagram" aria-label="Instagram"></i>';
                            break;
                        case 'linkedin':
                            echo '<i class="fab fa-linkedin-in" aria-label="LinkedIn"></i>';
                            break;
                        case 'youtube':
                            echo '<i class="fab fa-youtube" aria-label="YouTube"></i>';
                            break;
                        case 'tiktok':
                            echo '<i class="fab fa-tiktok" aria-label="TikTok"></i>';
                            break;
                        default:
                            echo ucfirst($network);
                            break;
                    }
                } else {
                    echo ucfirst($network);
                }
                
                echo '</a>';
            }
        }
        
        echo '</div>';
    }
}

// Display footer menus
if (!function_exists('display_footer_menu_1')) {
    function display_footer_menu_1($menu_class = 'footer-menu-1') {
        snn_display_footer_menu('footer_1', $menu_class);
    }
}

if (!function_exists('display_footer_menu_2')) {
    function display_footer_menu_2($menu_class = 'footer-menu-2') {
        snn_display_footer_menu('footer_2', $menu_class);
    }
}

if (!function_exists('display_footer_legal_menu')) {
    function display_footer_legal_menu($menu_class = 'footer-legal-menu') {
        snn_display_footer_menu('footer_legal_links', $menu_class);
    }
}

// Company information structured data (JSON-LD)
if (!function_exists('display_company_structured_data')) {
    function display_company_structured_data() {
        $company_name = get_company_name();
        $company_address = get_company_address();
        $company_phone = get_company_phone();
        $company_email = get_company_email();
        $company_website = get_company_website();
        
        if (empty($company_name)) {
            return;
        }
        
        $structured_data = [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => $company_name
        ];
        
        if (!empty($company_website)) {
            $structured_data["url"] = $company_website;
        }
        
        if (!empty($company_phone)) {
            $structured_data["telephone"] = $company_phone;
        }
        
        if (!empty($company_email)) {
            $structured_data["email"] = $company_email;
        }
        
        if (!empty($company_address)) {
            $structured_data["address"] = [
                "@type" => "PostalAddress",
                "streetAddress" => $company_address
            ];
        }
        
        // Add social media profiles
        $social_profiles = [];
        $social_networks = get_all_social_networks();
        foreach ($social_networks as $network => $url) {
            if (!empty($url)) {
                $social_profiles[] = $url;
            }
        }
        
        if (!empty($social_profiles)) {
            $structured_data["sameAs"] = $social_profiles;
        }
        
        echo '<script type="application/ld+json">' . wp_json_encode($structured_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
}

?>
