<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

use Bricks\Element;

// demo lol

class Snn_Steps_Vertical extends Element {
    public $category     = 'snn';
    public $name         = 'steps-vertical';
    public $icon         = 'ti-menu-alt';
    public $css_selector = '.snn-steps-vertical';
    public $scripts      = [];

    public function get_label() {
        return esc_html__('Steps - Vertical', 'snn');
    }

    private function sanitize_css_length($value, $fallback = '0px') {
        if ($value === null) {
            return $fallback;
        }
        if (!is_string($value)) {
            $value = (string) $value;
        }
        $value = trim($value);
        if ($value === '') {
            return $fallback;
        }
        // Already a valid CSS length with unit
        if (preg_match('/^-?\d+(?:\.\d+)?(px|rem|em|%|vh|vw)$/', $value)) {
            return $value;
        }
        // Pure number -> assume px
        if (preg_match('/^-?\d+(?:\.\d+)?$/', $value)) {
            return $value . 'px';
        }
        return $fallback;
    }

    public function set_controls() {
        // Main title (right column)
        $this->controls['main_title'] = [
            'tab'   => 'content',
            'label' => esc_html__('Titre principal', 'snn'),
            'type'  => 'text',
        ];

        // Media (left column)
        $this->controls['main_image'] = [
            'tab'   => 'content',
            'label' => esc_html__('Image (left column)', 'snn'),
            'type'  => 'image',
        ];

        // Steps repeater (1-6 typical)
        $this->controls['steps'] = [
            'tab'           => 'content',
            'label'         => esc_html__('Steps', 'snn'),
            'type'          => 'repeater',
            'titleProperty' => 'title',
            'fields'        => [
                'number_override' => [
                    'label'       => esc_html__('Number override', 'snn'),
                    'type'        => 'text',
                    'placeholder' => esc_html__('Auto (1..n)', 'snn'),
                ],
                'title' => [
                    'label' => esc_html__('Title', 'snn'),
                    'type'  => 'text',
                ],
                'description' => [
                    'label' => esc_html__('Description', 'snn'),
                    'type'  => 'editor',
                ],
                'link_label' => [
                    'label' => esc_html__('Link label', 'snn'),
                    'type'  => 'text',
                ],
                'link' => [
                    'label' => esc_html__('Link', 'snn'),
                    'type'  => 'link',
                ],
                'link_icon' => [
                    'label' => esc_html__('Link icon', 'snn'),
                    'type'  => 'icon',
                ],
                'link_icon_position' => [
                    'label'       => esc_html__('Icon position', 'snn'),
                    'type'        => 'select',
                    'options'     => [ 'right' => esc_html__('Right', 'snn'), 'left' => esc_html__('Left', 'snn') ],
                    'inline'      => true,
                    'placeholder' => esc_html__('Right', 'snn'),
                    'required'    => ['link_icon', '!=', '' ],
                ],
                'link_icon_gap' => [
                    'label'   => esc_html__('Icon gap', 'snn'),
                    'type'    => 'number',
                    'units'   => true,
                    'default' => '8px',
                ],
            ],
            'default'       => [
                [ 'title' => esc_html__('Expertise', 'snn'), 'description' => esc_html__('Votre description ici.', 'snn'), 'link_label' => '' ],
                [ 'title' => esc_html__('Direction', 'snn'), 'description' => esc_html__('Votre description ici.', 'snn'), 'link_label' => '' ],
                [ 'title' => esc_html__('Mise en vente', 'snn'), 'description' => esc_html__('Votre description ici.', 'snn'), 'link_label' => '' ],
                [ 'title' => esc_html__('Closing', 'snn'), 'description' => esc_html__('Votre description ici.', 'snn'), 'link_label' => '' ],
            ],
        ];

        // General styles
        $this->controls['backgroundColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Background color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'background-color', 'selector' => '.snn-steps-vertical' ] ],
        ];

        $this->controls['mediaPadding'] = [
            'tab'   => 'content',
            'label' => esc_html__('Image column padding', 'snn'),
            'type'  => 'spacing',
            'css'   => [ [ 'property' => 'padding', 'selector' => '.snn-steps-vertical__media' ] ],
        ];

        $this->controls['contentPadding'] = [
            'tab'   => 'content',
            'label' => esc_html__('Text column padding', 'snn'),
            'type'  => 'spacing',
            'css'   => [ [ 'property' => 'padding', 'selector' => '.snn-steps-vertical__content' ] ],
        ];

        // Separator
        $this->controls['separatorThickness'] = [
            'tab'     => 'content',
            'label'   => esc_html__('Separator thickness', 'snn'),
            'type'    => 'slider',
            'units'   => [ 'px' => [ 'min' => 0, 'max' => 8, 'step' => 1 ] ],
            'default' => '1px',
            'css'     => [ [ 'property' => 'border-bottom-width', 'selector' => '.snn-steps-vertical__item' ] ],
        ];
        $this->controls['separatorColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Separator color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'border-bottom-color', 'selector' => '.snn-steps-vertical__item' ] ],
        ];

        // Bullet styles
        $this->controls['bulletBg'] = [
            'tab'   => 'content',
            'label' => esc_html__('Bullet background', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'background-color', 'selector' => '.snn-steps-vertical__number' ] ],
        ];
        $this->controls['bulletColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Bullet text color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'color', 'selector' => '.snn-steps-vertical__number' ] ],
        ];
        $this->controls['bulletSize'] = [
            'tab'     => 'content',
            'label'   => esc_html__('Bullet size', 'snn'),
            'type'    => 'slider',
            'units'   => [ 'px' => [ 'min' => 20, 'max' => 80, 'step' => 1 ] ],
            'default' => '36px',
            'css'     => [
                [ 'property' => 'width',  'selector' => '.snn-steps-vertical__number' ],
                [ 'property' => 'height', 'selector' => '.snn-steps-vertical__number' ],
            ],
        ];
        $this->controls['bulletTypography'] = [
            'tab'   => 'content',
            'label' => esc_html__('Bullet typography', 'snn'),
            'type'  => 'typography',
            'css'   => [ [ 'property' => 'font', 'selector' => '.snn-steps-vertical__number' ] ],
        ];

        // Manual centering of numbers (fine-tune)
        $this->controls['bulletOffsetX'] = [
            'tab'     => 'content',
            'label'   => esc_html__('Bullet number offset X', 'snn'),
            'type'    => 'slider',
            'units'   => [ 'px' => [ 'min' => -20, 'max' => 20, 'step' => 1 ] ],
            'default' => '0px',
        ];
        $this->controls['bulletOffsetY'] = [
            'tab'     => 'content',
            'label'   => esc_html__('Bullet number offset Y', 'snn'),
            'type'    => 'slider',
            'units'   => [ 'px' => [ 'min' => -20, 'max' => 20, 'step' => 1 ] ],
            'default' => '0px',
        ];

        // Main title styles
        $this->controls['mainTitleTypography'] = [
            'tab'   => 'content',
            'label' => esc_html__('Main title typography', 'snn'),
            'type'  => 'typography',
            'css'   => [ [ 'property' => 'font', 'selector' => '.snn-steps-vertical__main-title' ] ],
        ];
        $this->controls['mainTitleColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Main title color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'color', 'selector' => '.snn-steps-vertical__main-title' ] ],
        ];

        // Title, text, link typography
        $this->controls['titleTypography'] = [
            'tab'   => 'content',
            'label' => esc_html__('Title typography', 'snn'),
            'type'  => 'typography',
            'css'   => [ [ 'property' => 'font', 'selector' => '.snn-steps-vertical__title' ] ],
        ];
        $this->controls['titleColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Title color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'color', 'selector' => '.snn-steps-vertical__title' ] ],
        ];
        $this->controls['descTypography'] = [
            'tab'   => 'content',
            'label' => esc_html__('Text typography', 'snn'),
            'type'  => 'typography',
            'css'   => [ [ 'property' => 'font', 'selector' => '.snn-steps-vertical__desc' ] ],
        ];
        $this->controls['descColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Text color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'color', 'selector' => '.snn-steps-vertical__desc' ] ],
        ];
        $this->controls['linkTypography'] = [
            'tab'   => 'content',
            'label' => esc_html__('Link typography', 'snn'),
            'type'  => 'typography',
            'css'   => [ [ 'property' => 'font', 'selector' => '.snn-steps-vertical__link a' ] ],
        ];
        $this->controls['linkColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Link color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'color', 'selector' => '.snn-steps-vertical__link a' ] ],
        ];
        $this->controls['linkHoverColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Link hover color', 'snn'),
            'type'  => 'color',
            'css'   => [ [ 'property' => 'color', 'selector' => '.snn-steps-vertical__link a:hover' ] ],
        ];
    }

    public function render() {
        $steps = isset($this->settings['steps']) && is_array($this->settings['steps']) ? $this->settings['steps'] : [];

        // Root attributes
        $this->set_attribute('_root', 'class', 'snn-steps-vertical');
        if (isset($this->attributes['_root']['id']) && !empty($this->attributes['_root']['id'])) {
            $root_id = $this->attributes['_root']['id'];
        } else {
            $root_id = 'snn-steps-vertical-' . uniqid();
            $this->set_attribute('_root', 'id', $root_id);
        }

        // Inline background color fallback if set
        if (!empty($this->settings['backgroundColor'])) {
            $bg = $this->settings['backgroundColor'];
            $bg_value = '';
            if (is_array($bg)) {
                $bg_value = $bg['rgba'] ?? ($bg['rgb'] ?? ($bg['hex'] ?? ''));
            } else {
                $bg_value = $bg;
            }
            if (!empty($bg_value)) {
                $this->set_attribute('_root', 'style', 'background-color: ' . esc_attr($bg_value) . ';');
            }
        }

        echo '<div ' . $this->render_attributes('_root') . '>';

        // Layout
        echo '<div class="snn-steps-vertical__layout">';

        // Media column
        echo '<div class="snn-steps-vertical__media">';
        if (!empty($this->settings['main_image']['id'])) {
            $size = !empty($this->settings['main_image']['size']) ? $this->settings['main_image']['size'] : 'large';
            echo wp_get_attachment_image(intval($this->settings['main_image']['id']), $size, false, [ 'class' => 'snn-steps-vertical__img' ]);
        }
        echo '</div>';

        // Content column
        echo '<div class="snn-steps-vertical__content">';
        
        // Main title
        if (!empty($this->settings['main_title'])) {
            echo '<h2 class="snn-steps-vertical__main-title">' . wp_kses_post($this->settings['main_title']) . '</h2>';
        }
        
        if ($steps) {
            foreach ($steps as $i => $item) {
                $number = isset($item['number_override']) && $item['number_override'] !== '' ? wp_kses_post($item['number_override']) : strval($i + 1);
                $title  = isset($item['title']) ? wp_kses_post($item['title']) : '';
                $desc   = isset($item['description']) ? $item['description'] : '';
                $link   = isset($item['link']) ? $item['link'] : null;
                $label  = isset($item['link_label']) ? $item['link_label'] : '';

                $link_url      = $link && !empty($link['url']) ? esc_url($link['url']) : '';
                $link_target   = $link && !empty($link['target']) ? ' target="_blank"' : '';
                $link_rel_attr = '';
                if ($link && !empty($link['rel'])) {
                    $rel = is_array($link['rel']) ? implode(' ', $link['rel']) : $link['rel'];
                    $link_rel_attr = ' rel="' . esc_attr($rel) . '"';
                }

                $icon_html = '';
                $icon_pos  = isset($item['link_icon_position']) ? $item['link_icon_position'] : 'right';
                $icon_gap  = isset($item['link_icon_gap']) ? $item['link_icon_gap'] : '8px';
                if (!empty($item['link_icon'])) {
                    $icon_html = \Bricks\Element::render_icon($item['link_icon']);
                }

                echo '<div class="snn-steps-vertical__item">';
                echo '<div class="snn-steps-vertical__header">';
                echo '<span class="snn-steps-vertical__number"><span class="snn-steps-vertical__number-text">' . $number . '</span></span>';
                if ($title) {
                    echo '<h3 class="snn-steps-vertical__title">' . $title . '</h3>';
                }
                echo '</div>';

                if (!empty($desc)) {
                    echo '<div class="snn-steps-vertical__desc">' . wp_kses_post($desc) . '</div>';
                }

                if ($link_url && $label) {
                    echo '<p class="snn-steps-vertical__link"><a href="' . $link_url . '"' . $link_target . $link_rel_attr . ' style="display:inline-flex;align-items:center;gap:' . esc_attr($icon_gap) . ';">';
                    if ($icon_html && $icon_pos === 'left') { echo $icon_html; }
                    echo esc_html($label);
                    if ($icon_html && $icon_pos !== 'left') { echo $icon_html; }
                    echo '</a></p>';
                }

                echo '</div>'; // item
            }
        } else {
            esc_html_e('Add steps.', 'snn');
        }
        echo '</div>'; // content

        echo '</div>'; // layout

        // Styles
        echo '<style>
            #' . esc_attr($root_id) . ' { width: 100%; }
            #' . esc_attr($root_id) . ' .snn-steps-vertical__layout { display:grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: stretch; }
            #' . esc_attr($root_id) . ' .snn-steps-vertical__media { height: 100%; }
            #' . esc_attr($root_id) . ' .snn-steps-vertical__img { width: 100%; height: 100%; display:block; object-fit: cover; }
            #' . esc_attr($root_id) . ' .snn-steps-vertical__content { }
            #' . esc_attr($root_id) . ' .snn-steps-vertical__main-title { margin: 0 0 32px 0; font-size: 2rem; font-weight: 600; }
            #' . esc_attr($root_id) . ' .snn-steps-vertical__item { padding: 24px 0; border-bottom: 1px solid rgba(0,0,0,.12); }
            #' . esc_attr($root_id) . ' .snn-steps-vertical__item:last-child { border-bottom: none; }
            #' . esc_attr($root_id) . ' .snn-steps-vertical__header { display:flex; align-items:center; gap: 16px; margin-bottom: 10px; }
            #' . esc_attr($root_id) . ' .snn-steps-vertical__number { display:inline-grid; place-items:center; width: 36px; height: 36px; border-radius:999px; background:#0b3b6b; color:#fff; }
            #' . esc_attr($root_id) . ' .snn-steps-vertical__number-text{ display:inline-block; }
            #' . esc_attr($root_id) . ' .snn-steps-vertical__title { margin: 0; }
            #' . esc_attr($root_id) . ' .snn-steps-vertical__desc { margin: 10px 0 0 0; }
            #' . esc_attr($root_id) . ' .snn-steps-vertical__link a { text-decoration:none; }
            @media (max-width: 900px) {
                #' . esc_attr($root_id) . ' .snn-steps-vertical__layout { grid-template-columns: 1fr; }
            }
        </style>';

        // Bullet offset styles if set
        $offX = isset($this->settings['bulletOffsetX']) ? $this->settings['bulletOffsetX'] : '';
        $offY = isset($this->settings['bulletOffsetY']) ? $this->settings['bulletOffsetY'] : '';
        if ($offX !== '' || $offY !== '') {
            $tx = $this->sanitize_css_length($offX, '0px');
            $ty = $this->sanitize_css_length($offY, '0px');
            echo '<style>#' . esc_attr($root_id) . ' .snn-steps-vertical__number-text{transform: translate(' . esc_attr($tx) . ', ' . esc_attr($ty) . ');}</style>';
        }

        echo '</div>';
    }
}

