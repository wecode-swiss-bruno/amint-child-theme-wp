<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

use Bricks\Element;

class Snn_References_Carousel extends Element {
    public $category     = 'snn';
    public $name         = 'references-carousel';
    public $icon         = 'ti-layout-slider';
    public $css_selector = '.snn-references-carousel';
    public $scripts      = [];

    public function get_label() {
        return esc_html__('References Carousel', 'snn');
    }

    public function set_controls() {
        // Query settings
        $this->controls['query'] = [
            'tab'   => 'content',
            'label' => esc_html__('Query', 'snn'),
            'type'  => 'query',
            'default' => [
                'post_type' => 'reference',
                'posts_per_page' => 6,
                'orderby' => 'date',
                'order' => 'DESC',
            ],
        ];

        // Carousel settings
        $this->controls['slides_per_view'] = [
            'tab'     => 'content',
            'label'   => esc_html__('Slides per view', 'snn'),
            'type'    => 'slider',
            'units'   => [ '' => [ 'min' => 1, 'max' => 5, 'step' => 1 ] ],
            'default' => '3',
        ];

        $this->controls['space_between'] = [
            'tab'     => 'content',
            'label'   => esc_html__('Space between slides', 'snn'),
            'type'    => 'slider',
            'units'   => [ 'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ] ],
            'default' => '30px',
        ];

        $this->controls['autoplay'] = [
            'tab'   => 'content',
            'label' => esc_html__('Autoplay', 'snn'),
            'type'  => 'checkbox',
            'default' => true,
        ];

        $this->controls['autoplay_delay'] = [
            'tab'     => 'content',
            'label'   => esc_html__('Autoplay delay (ms)', 'snn'),
            'type'    => 'number',
            'default' => 3000,
            'min'     => 1000,
            'max'     => 10000,
            'step'    => 100,
            'required' => ['autoplay', '=', true],
        ];

        $this->controls['loop'] = [
            'tab'   => 'content',
            'label' => esc_html__('Loop', 'snn'),
            'type'  => 'checkbox',
            'default' => true,
        ];

        $this->controls['show_navigation'] = [
            'tab'   => 'content',
            'label' => esc_html__('Show navigation arrows', 'snn'),
            'type'  => 'checkbox',
            'default' => true,
        ];

        $this->controls['show_pagination'] = [
            'tab'   => 'content',
            'label' => esc_html__('Show pagination dots', 'snn'),
            'type'  => 'checkbox',
            'default' => true,
        ];

        // Card styles
        $this->controls['card_background'] = [
            'tab'   => 'style',
            'label' => esc_html__('Card background', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'background-color', 'selector' => '.snn-reference-card' ] ],
        ];

        $this->controls['card_padding'] = [
            'tab'   => 'style',
            'label' => esc_html__('Card padding', 'snn'),
            'type'  => 'spacing',
            'css'   => [ [ 'property' => 'padding', 'selector' => '.snn-reference-card' ] ],
        ];

        $this->controls['card_border_radius'] = [
            'tab'     => 'style',
            'label'   => esc_html__('Card border radius', 'snn'),
            'type'    => 'slider',
            'units'   => [ 'px' => [ 'min' => 0, 'max' => 50, 'step' => 1 ] ],
            'default' => '12px',
            'css'     => [ [ 'property' => 'border-radius', 'selector' => '.snn-reference-card' ] ],
        ];

        $this->controls['card_shadow'] = [
            'tab'   => 'style',
            'label' => esc_html__('Card shadow', 'snn'),
            'type'  => 'box-shadow',
            'css'   => [ [ 'property' => 'box-shadow', 'selector' => '.snn-reference-card' ] ],
        ];

        // Typography
        $this->controls['title_typography'] = [
            'tab'   => 'style',
            'label' => esc_html__('Title typography', 'snn'),
            'type'  => 'typography',
            'css'   => [ [ 'property' => 'font', 'selector' => '.snn-reference-title' ] ],
        ];

        $this->controls['title_color'] = [
            'tab'   => 'style',
            'label' => esc_html__('Title color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'color', 'selector' => '.snn-reference-title' ] ],
        ];

        $this->controls['description_typography'] = [
            'tab'   => 'style',
            'label' => esc_html__('Description typography', 'snn'),
            'type'  => 'typography',
            'css'   => [ [ 'property' => 'font', 'selector' => '.snn-reference-description' ] ],
        ];

        $this->controls['description_color'] = [
            'tab'   => 'style',
            'label' => esc_html__('Description color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'color', 'selector' => '.snn-reference-description' ] ],
        ];

        $this->controls['testimonial_typography'] = [
            'tab'   => 'style',
            'label' => esc_html__('Testimonial typography', 'snn'),
            'type'  => 'typography',
            'css'   => [ [ 'property' => 'font', 'selector' => '.snn-reference-testimonial' ] ],
        ];

        $this->controls['testimonial_color'] = [
            'tab'   => 'style',
            'label' => esc_html__('Testimonial color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'color', 'selector' => '.snn-reference-testimonial' ] ],
        ];

        $this->controls['client_name_typography'] = [
            'tab'   => 'style',
            'label' => esc_html__('Client name typography', 'snn'),
            'type'  => 'typography',
            'css'   => [ [ 'property' => 'font', 'selector' => '.snn-reference-client-name' ] ],
        ];

        $this->controls['client_name_color'] = [
            'tab'   => 'style',
            'label' => esc_html__('Client name color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'color', 'selector' => '.snn-reference-client-name' ] ],
        ];

        $this->controls['client_info_typography'] = [
            'tab'   => 'style',
            'label' => esc_html__('Client info typography', 'snn'),
            'type'  => 'typography',
            'css'   => [ [ 'property' => 'font', 'selector' => '.snn-reference-client-info' ] ],
        ];

        $this->controls['client_info_color'] = [
            'tab'   => 'style',
            'label' => esc_html__('Client info color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'color', 'selector' => '.snn-reference-client-info' ] ],
        ];

        // Stars color
        $this->controls['stars_color'] = [
            'tab'   => 'style',
            'label' => esc_html__('Stars color', 'snn'),
            'type'  => 'color',
            'default' => '#ffc107',
            'css'   => [ [ 'property' => 'color', 'selector' => '.snn-reference-stars' ] ],
        ];

        // Navigation styles
        $this->controls['nav_color'] = [
            'tab'   => 'style',
            'label' => esc_html__('Navigation color', 'snn'),
            'type'  => 'color',
            'css'   => [ 
                [ 'property' => 'color', 'selector' => '.swiper-button-next' ],
                [ 'property' => 'color', 'selector' => '.swiper-button-prev' ]
            ],
        ];

        $this->controls['nav_hover_color'] = [
            'tab'   => 'style',
            'label' => esc_html__('Navigation hover color', 'snn'),
            'type'  => 'color',
            'css'   => [ 
                [ 'property' => 'color', 'selector' => '.swiper-button-next:hover' ],
                [ 'property' => 'color', 'selector' => '.swiper-button-prev:hover' ]
            ],
        ];

        // Pagination styles
        $this->controls['pagination_color'] = [
            'tab'   => 'style',
            'label' => esc_html__('Pagination color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'background-color', 'selector' => '.swiper-pagination-bullet' ] ],
        ];

        $this->controls['pagination_active_color'] = [
            'tab'   => 'style',
            'label' => esc_html__('Pagination active color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'background-color', 'selector' => '.swiper-pagination-bullet-active' ] ],
        ];
    }

    public function render() {
        $settings = $this->settings;
        
        // Root attributes
        $this->set_attribute('_root', 'class', 'snn-references-carousel');
        $root_id = 'snn-references-carousel-' . uniqid();
        $this->set_attribute('_root', 'id', $root_id);

        // Query references
        $query_args = isset($settings['query']) ? $settings['query'] : [
            'post_type' => 'reference',
            'posts_per_page' => 6,
        ];
        
        $references = new WP_Query($query_args);

        if (!$references->have_posts()) {
            echo '<div class="snn-no-references">' . esc_html__('No references found.', 'snn') . '</div>';
            return;
        }

        // Carousel settings
        $slides_per_view = isset($settings['slides_per_view']) ? intval($settings['slides_per_view']) : 3;
        $space_between = isset($settings['space_between']) ? intval($settings['space_between']) : 30;
        $autoplay = isset($settings['autoplay']) ? $settings['autoplay'] : true;
        $autoplay_delay = isset($settings['autoplay_delay']) ? intval($settings['autoplay_delay']) : 3000;
        $loop = isset($settings['loop']) ? $settings['loop'] : true;
        $show_navigation = isset($settings['show_navigation']) ? $settings['show_navigation'] : true;
        $show_pagination = isset($settings['show_pagination']) ? $settings['show_pagination'] : true;

        echo '<div ' . $this->render_attributes('_root') . '>';
        echo '<div class="swiper-container" id="' . esc_attr($root_id) . '-swiper">';
        echo '<div class="swiper-wrapper">';

        while ($references->have_posts()) {
            $references->the_post();
            $post_id = get_the_ID();
            
            // Get ACF fields
            $titre_projet = get_field('titre_projet', $post_id);
            $description_projet = get_field('description_projet', $post_id);
            $image_projet = get_field('image_projet', $post_id);
            $nom_client = get_field('nom_client', $post_id);
            $poste_client = get_field('poste_client', $post_id);
            $photo_client = get_field('photo_client', $post_id);
            $temoignage = get_field('témoignage', $post_id);
            $note = get_field('note', $post_id);
            $entreprise_client = get_field('entreprise_client', $post_id);
            $annee_debut = get_field('annee_debut', $post_id);
            $annee_fin = get_field('annee_fin', $post_id);

            echo '<div class="swiper-slide">';
            echo '<div class="snn-reference-card">';
            
            // Project image
            if ($image_projet) {
                echo '<div class="snn-reference-image">';
                echo wp_get_attachment_image($image_projet['ID'], 'medium', false, ['class' => 'snn-reference-img']);
                echo '</div>';
            }
            
            // Content
            echo '<div class="snn-reference-content">';
            
            // Project title
            if ($titre_projet) {
                echo '<h3 class="snn-reference-title">' . esc_html($titre_projet) . '</h3>';
            }
            
            // Project description
            if ($description_projet) {
                echo '<p class="snn-reference-description">' . esc_html($description_projet) . '</p>';
            }
            
            // Years
            if ($annee_debut || $annee_fin) {
                echo '<div class="snn-reference-years">';
                if ($annee_debut && $annee_fin) {
                    echo '<span>' . esc_html($annee_debut) . ' - ' . esc_html($annee_fin) . '</span>';
                } elseif ($annee_debut) {
                    echo '<span>' . esc_html($annee_debut) . '</span>';
                }
                echo '</div>';
            }
            
            // Testimonial
            if ($temoignage) {
                echo '<blockquote class="snn-reference-testimonial">"' . esc_html($temoignage) . '"</blockquote>';
            }
            
            // Rating stars
            if ($note) {
                echo '<div class="snn-reference-stars">';
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $note) {
                        echo '<span class="star filled">★</span>';
                    } else {
                        echo '<span class="star">☆</span>';
                    }
                }
                echo '</div>';
            }
            
            // Client info
            echo '<div class="snn-reference-client">';
            
            // Client photo
            if ($photo_client) {
                echo '<div class="snn-reference-client-photo">';
                echo wp_get_attachment_image($photo_client['ID'], 'thumbnail', false, ['class' => 'snn-client-avatar']);
                echo '</div>';
            }
            
            echo '<div class="snn-reference-client-details">';
            if ($nom_client) {
                echo '<div class="snn-reference-client-name">' . esc_html($nom_client) . '</div>';
            }
            
            $client_info_parts = [];
            if ($poste_client) $client_info_parts[] = $poste_client;
            if ($entreprise_client) $client_info_parts[] = $entreprise_client;
            
            if (!empty($client_info_parts)) {
                echo '<div class="snn-reference-client-info">' . esc_html(implode(', ', $client_info_parts)) . '</div>';
            }
            echo '</div>';
            echo '</div>'; // client
            
            echo '</div>'; // content
            echo '</div>'; // card
            echo '</div>'; // slide
        }

        echo '</div>'; // swiper-wrapper

        // Navigation
        if ($show_navigation) {
            echo '<div class="swiper-button-next"></div>';
            echo '<div class="swiper-button-prev"></div>';
        }

        // Pagination
        if ($show_pagination) {
            echo '<div class="swiper-pagination"></div>';
        }

        echo '</div>'; // swiper-container
        echo '</div>'; // root

        wp_reset_postdata();

        // Swiper configuration
        $swiper_config = [
            'slidesPerView' => $slides_per_view,
            'spaceBetween' => $space_between,
            'loop' => $loop,
            'autoplay' => $autoplay ? ['delay' => $autoplay_delay] : false,
            'navigation' => $show_navigation ? [
                'nextEl' => '#' . $root_id . ' .swiper-button-next',
                'prevEl' => '#' . $root_id . ' .swiper-button-prev',
            ] : false,
            'pagination' => $show_pagination ? [
                'el' => '#' . $root_id . ' .swiper-pagination',
                'clickable' => true,
            ] : false,
            'breakpoints' => [
                '320' => ['slidesPerView' => 1],
                '768' => ['slidesPerView' => 2],
                '1024' => ['slidesPerView' => $slides_per_view],
            ],
        ];

        // Inline CSS and JS
        echo '<style>
            #' . esc_attr($root_id) . ' {
                position: relative;
                width: 100%;
                overflow: hidden;
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-card {
                background: #fff;
                border-radius: 12px;
                padding: 24px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                height: 100%;
                display: flex;
                flex-direction: column;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-image {
                margin-bottom: 16px;
                border-radius: 8px;
                overflow: hidden;
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                display: block;
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-content {
                flex: 1;
                display: flex;
                flex-direction: column;
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-title {
                margin: 0 0 12px 0;
                font-size: 1.25rem;
                font-weight: 600;
                color: #333;
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-description {
                margin: 0 0 12px 0;
                color: #666;
                line-height: 1.5;
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-years {
                margin-bottom: 16px;
                font-size: 0.875rem;
                color: #888;
                font-weight: 500;
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-testimonial {
                margin: 0 0 16px 0;
                font-style: italic;
                color: #555;
                border-left: 3px solid #0b3b6b;
                padding-left: 16px;
                flex: 1;
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-stars {
                margin-bottom: 16px;
                color: #ffc107;
                font-size: 1.2rem;
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-client {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-top: auto;
                padding-top: 16px;
                border-top: 1px solid #eee;
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-client-photo {
                flex-shrink: 0;
            }
            
            #' . esc_attr($root_id) . ' .snn-client-avatar {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                object-fit: cover;
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-client-name {
                font-weight: 600;
                color: #333;
                margin-bottom: 4px;
            }
            
            #' . esc_attr($root_id) . ' .snn-reference-client-info {
                font-size: 0.875rem;
                color: #666;
            }
            
            #' . esc_attr($root_id) . ' .swiper-button-next,
            #' . esc_attr($root_id) . ' .swiper-button-prev {
                color: #0b3b6b;
            }
            
            #' . esc_attr($root_id) . ' .swiper-pagination-bullet {
                background-color: #ccc;
            }
            
            #' . esc_attr($root_id) . ' .swiper-pagination-bullet-active {
                background-color: #0b3b6b;
            }
            
            @media (max-width: 768px) {
                #' . esc_attr($root_id) . ' .snn-reference-card {
                    padding: 20px;
                }
                
                #' . esc_attr($root_id) . ' .snn-reference-img {
                    height: 150px;
                }
            }
        </style>';

        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof Swiper !== "undefined") {
                    new Swiper("#' . esc_attr($root_id) . '-swiper", ' . json_encode($swiper_config) . ');
                } else {
                    console.warn("Swiper is not loaded. Please include Swiper.js library.");
                }
            });
        </script>';
    }

    public function enqueue_scripts() {
        // Enqueue Swiper CSS and JS if not already loaded
        if (!wp_script_is('swiper-js', 'enqueued')) {
            wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper@8/swiper-bundle.min.js', [], '8.0.0', true);
        }
        if (!wp_style_is('swiper-css', 'enqueued')) {
            wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper@8/swiper-bundle.min.css', [], '8.0.0');
        }
    }
}

