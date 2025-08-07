<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Bricks\Element;

class Stats_Counter_Element extends Element {
    public $category     = 'snn';
    public $name         = 'stats-counter';
    public $icon         = 'ti-stats-up';
    public $css_selector = '.stats-counter-element';
    public $scripts      = ['stats-counter'];
    public $nestable     = false;

    /**
     * Helper to ensure a value is returned as a string.
     */
    private function ensure_string( $value ) {
        if ( is_array( $value ) ) {
            // For color controls, prefer 'hex'
            if ( isset( $value['hex'] ) ) {
                return $value['hex'];
            }
            // For editor controls, check for 'raw'
            if ( isset( $value['raw'] ) ) {
                return $value['raw'];
            }
            return implode( ' ', $value );
        } elseif ( is_scalar( $value ) ) {
            return (string) $value;
        }
        return '';
    }

    public function get_label() {
        return esc_html__( 'Stats Counter', 'snn' );
    }

    public function set_control_groups() {
        $this->control_groups['general'] = [
            'title' => esc_html__( 'General', 'snn' ),
            'tab'   => 'content',
        ];

        $this->control_groups['style'] = [
            'title' => esc_html__( 'Style', 'snn' ),
            'tab'   => 'content',
        ];
    }

    public function set_controls() {
        // Columns Layout
        $this->controls['columns'] = [
            'tab'     => 'content',
            'group'   => 'general',
            'label'   => esc_html__( 'Columns', 'snn' ),
            'type'    => 'select',
            'options' => [
                '1' => esc_html__( '1 Column', 'snn' ),
                '2' => esc_html__( '2 Columns', 'snn' ),
                '3' => esc_html__( '3 Columns', 'snn' ),
                '4' => esc_html__( '4 Columns', 'snn' ),
            ],
            'default' => '3',
            'css'     => [
                [
                    'property' => '--stats-columns',
                    'selector' => '',
                ],
            ],
        ];

        // Gap between items
        $this->controls['gap'] = [
            'tab'     => 'content',
            'group'   => 'general',
            'label'   => esc_html__( 'Gap', 'snn' ),
            'type'    => 'number',
            'units'   => ['px', 'rem', 'em'],
            'default' => '60px',
            'css'     => [
                [
                    'property' => 'gap',
                    'selector' => '.stats-counter-wrapper',
                ],
            ],
        ];

        // Alignment
        $this->controls['alignment'] = [
            'tab'     => 'content',
            'group'   => 'general',
            'label'   => esc_html__( 'Alignment', 'snn' ),
            'type'    => 'text-align',
            'default' => 'center',
            'css'     => [
                [
                    'property' => 'text-align',
                    'selector' => '.stats-counter-item',
                ],
            ],
        ];

        // Stats Items Repeater
        $this->controls['stats_items'] = [
            'tab'     => 'content',
            'group'   => 'general',
            'type'    => 'repeater',
            'label'   => esc_html__( 'Stats Items', 'snn' ),
            'titleProperty' => 'title',
            'default' => [
                [
                    'title'       => 'Transactions',
                    'value'       => '1',
                    'suffix'      => 'Mrd',
                    'description' => 'lors des 5 dernières années',
                ],
                [
                    'title'       => 'Asset Management',
                    'value'       => '30',
                    'suffix'      => 'M',
                    'description' => 'd\'état locatif sous gestion',
                ],
                [
                    'title'       => 'Evaluations',
                    'value'       => '1.5',
                    'suffix'      => 'Mrd',
                    'description' => 'd\'actifs évalués annuellement',
                ],
            ],
            'fields'  => [
                'title' => [
                    'type'    => 'text',
                    'label'   => esc_html__( 'Title', 'snn' ),
                    'default' => 'Title',
                ],
                'value' => [
                    'type'    => 'text',
                    'label'   => esc_html__( 'Value', 'snn' ),
                    'default' => '0',
                ],
                'prefix' => [
                    'type'    => 'text',
                    'label'   => esc_html__( 'Prefix', 'snn' ),
                    'placeholder' => '$',
                ],
                'suffix' => [
                    'type'    => 'text',
                    'label'   => esc_html__( 'Suffix', 'snn' ),
                    'placeholder' => 'M',
                ],
                'description' => [
                    'type'    => 'text',
                    'label'   => esc_html__( 'Description', 'snn' ),
                    'default' => '',
                ],
                'icon' => [
                    'type'    => 'icon',
                    'label'   => esc_html__( 'Icon', 'snn' ),
                ],
            ],
        ];

        // Animation Settings
        $this->controls['enable_animation'] = [
            'tab'     => 'content',
            'group'   => 'general',
            'label'   => esc_html__( 'Enable Count Animation', 'snn' ),
            'type'    => 'checkbox',
            'default' => true,
        ];

        $this->controls['animation_duration'] = [
            'tab'      => 'content',
            'group'    => 'general',
            'label'    => esc_html__( 'Animation Duration (ms)', 'snn' ),
            'type'     => 'number',
            'default'  => 2000,
            'min'      => 500,
            'max'      => 5000,
            'step'     => 100,
            'required' => ['enable_animation', '=', true],
        ];

        // Style Controls - Title
        $this->controls['title_typography'] = [
            'tab'   => 'content',
            'group' => 'style',
            'label' => esc_html__( 'Title Typography', 'snn' ),
            'type'  => 'typography',
            'css'   => [
                [
                    'property' => 'font',
                    'selector' => '.stats-counter-title',
                ],
            ],
            'default' => [
                'font-size' => '14px',
                'font-weight' => '400',
                'text-transform' => 'uppercase',
                'letter-spacing' => '1px',
            ],
        ];

        $this->controls['title_color'] = [
            'tab'   => 'content',
            'group' => 'style',
            'label' => esc_html__( 'Title Color', 'snn' ),
            'type'  => 'color',
            'css'   => [
                [
                    'property' => 'color',
                    'selector' => '.stats-counter-title',
                ],
            ],
            'default' => '#666666',
        ];

        // Style Controls - Value
        $this->controls['value_typography'] = [
            'tab'   => 'content',
            'group' => 'style',
            'label' => esc_html__( 'Value Typography', 'snn' ),
            'type'  => 'typography',
            'css'   => [
                [
                    'property' => 'font',
                    'selector' => '.stats-counter-value',
                ],
            ],
            'default' => [
                'font-size' => '48px',
                'font-weight' => '700',
                'line-height' => '1.2',
            ],
        ];

        $this->controls['value_color'] = [
            'tab'   => 'content',
            'group' => 'style',
            'label' => esc_html__( 'Value Color', 'snn' ),
            'type'  => 'color',
            'css'   => [
                [
                    'property' => 'color',
                    'selector' => '.stats-counter-value',
                ],
            ],
            'default' => '#333333',
        ];

        // Style Controls - Description
        $this->controls['description_typography'] = [
            'tab'   => 'content',
            'group' => 'style',
            'label' => esc_html__( 'Description Typography', 'snn' ),
            'type'  => 'typography',
            'css'   => [
                [
                    'property' => 'font',
                    'selector' => '.stats-counter-description',
                ],
            ],
            'default' => [
                'font-size' => '14px',
                'font-weight' => '400',
                'line-height' => '1.5',
            ],
        ];

        $this->controls['description_color'] = [
            'tab'   => 'content',
            'group' => 'style',
            'label' => esc_html__( 'Description Color', 'snn' ),
            'type'  => 'color',
            'css'   => [
                [
                    'property' => 'color',
                    'selector' => '.stats-counter-description',
                ],
            ],
            'default' => '#777777',
        ];

        // Icon Style
        $this->controls['icon_size'] = [
            'tab'   => 'content',
            'group' => 'style',
            'label' => esc_html__( 'Icon Size', 'snn' ),
            'type'  => 'number',
            'units' => ['px', 'em', 'rem'],
            'default' => '40px',
            'css'   => [
                [
                    'property' => 'font-size',
                    'selector' => '.stats-counter-icon',
                ],
            ],
        ];

        $this->controls['icon_color'] = [
            'tab'   => 'content',
            'group' => 'style',
            'label' => esc_html__( 'Icon Color', 'snn' ),
            'type'  => 'color',
            'css'   => [
                [
                    'property' => 'color',
                    'selector' => '.stats-counter-icon',
                ],
            ],
            'default' => '#3498db',
        ];

        // Spacing
        $this->controls['title_margin'] = [
            'tab'   => 'content',
            'group' => 'style',
            'label' => esc_html__( 'Title Margin', 'snn' ),
            'type'  => 'spacing',
            'css'   => [
                [
                    'property' => 'margin',
                    'selector' => '.stats-counter-title',
                ],
            ],
            'default' => [
                'bottom' => '15px',
            ],
        ];

        $this->controls['value_margin'] = [
            'tab'   => 'content',
            'group' => 'style',
            'label' => esc_html__( 'Value Margin', 'snn' ),
            'type'  => 'spacing',
            'css'   => [
                [
                    'property' => 'margin',
                    'selector' => '.stats-counter-value',
                ],
            ],
            'default' => [
                'bottom' => '10px',
            ],
        ];
    }

    public function enqueue_scripts() {
        // Enqueue CSS
        wp_enqueue_style(
            'stats-counter',
            get_stylesheet_directory_uri() . '/assets/css/stats-counter.css',
            [],
            filemtime( get_stylesheet_directory() . '/assets/css/stats-counter.css' )
        );
        
        // Enqueue JS if animation is enabled
        if ( isset( $this->settings['enable_animation'] ) && $this->settings['enable_animation'] ) {
            wp_enqueue_script(
                'stats-counter',
                get_stylesheet_directory_uri() . '/assets/js/stats-counter.js',
                [],
                filemtime( get_stylesheet_directory() . '/assets/js/stats-counter.js' ),
                true
            );
   
        }
    }

    public function render() {
        $settings = $this->settings;
        
        $stats_items = isset( $settings['stats_items'] ) ? $settings['stats_items'] : [];
        $columns = isset( $settings['columns'] ) ? $settings['columns'] : '3';
        $enable_animation = isset( $settings['enable_animation'] ) && $settings['enable_animation'];
        $animation_duration = isset( $settings['animation_duration'] ) ? $settings['animation_duration'] : 2000;

        $root_classes = [ 'stats-counter-element' ];
        if ( $enable_animation ) {
            $root_classes[] = 'has-animation';
        }

        $this->set_attribute( '_root', 'class', $root_classes );
        $this->set_attribute( '_root', 'data-animation-duration', $animation_duration );

        // Output HTML
        echo '<div ' . $this->render_attributes( '_root' ) . '>';
        echo '<div class="stats-counter-wrapper" style="--stats-columns: ' . esc_attr( $columns ) . ';">';

        foreach ( $stats_items as $index => $item ) {
            $title = isset( $item['title'] ) ? $this->ensure_string( $item['title'] ) : '';
            $value = isset( $item['value'] ) ? $this->ensure_string( $item['value'] ) : '0';
            $prefix = isset( $item['prefix'] ) ? $this->ensure_string( $item['prefix'] ) : '';
            $suffix = isset( $item['suffix'] ) ? $this->ensure_string( $item['suffix'] ) : '';
            $description = isset( $item['description'] ) ? $this->ensure_string( $item['description'] ) : '';
            $icon = isset( $item['icon'] ) ? $item['icon'] : '';

            echo '<div class="stats-counter-item">';
            
            // Icon
            if ( ! empty( $icon ) ) {
                echo '<div class="stats-counter-icon">';
                echo \Bricks\Element::render_icon( $icon, [] );
                echo '</div>';
            }

            // Title
            if ( ! empty( $title ) ) {
                echo '<div class="stats-counter-title">' . esc_html( $title ) . '</div>';
            }

            // Value with prefix and suffix
            echo '<div class="stats-counter-value">';
            if ( ! empty( $prefix ) ) {
                echo '<span class="stats-counter-prefix">' . esc_html( $prefix ) . '</span>';
            }
            echo '<span class="stats-counter-number" data-value="' . esc_attr( $value ) . '">';
            echo $enable_animation ? '0' : esc_html( $value );
            echo '</span>';
            if ( ! empty( $suffix ) ) {
                echo '<span class="stats-counter-suffix">' . esc_html( $suffix ) . '</span>';
            }
            echo '</div>';

            // Description
            if ( ! empty( $description ) ) {
                echo '<div class="stats-counter-description">' . esc_html( $description ) . '</div>';
            }

            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
    }

    public function get_nestable_item() {
        return [];
    }

    public function convert_element_settings_to_block( $settings ) {
        return $settings;
    }

    public function convert_block_to_element_settings( $block ) {
        return $block['attrs'];
    }
}