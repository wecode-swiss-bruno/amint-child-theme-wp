<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

use Bricks\Element;

class Snn_Services_Tabs extends Element {
    public $category     = 'snn';
    public $name         = 'snn-services-tabs';
    public $icon         = 'ti-layout-tab';
    public $css_selector = '.snn-services-tabs';
    public $scripts      = [];

    public function get_label() {
        return esc_html__('Services Tabs (4)', 'snn');
    }

    public function set_controls() {
        // Which tab is open by default
        $this->controls['openTab'] = [
            'tab'         => 'content',
            'label'       => esc_html__('Open tab index', 'snn'),
            'type'        => 'number',
            'default'     => 0,
            'inline'      => true,
            'description' => esc_html__('Index of the item to open on load, starting at 0.', 'snn'),
        ];

        // Tabs repeater
        $this->controls['tabs'] = [
            'tab'           => 'content',
            'label'         => esc_html__('Tabs', 'snn'),
            'type'          => 'repeater',
            'titleProperty' => 'title',
            'fields'        => [
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
                    'placeholder' => esc_html__('En savoir plus', 'snn'),
                ],
                'link' => [
                    'label'       => esc_html__('Link', 'snn'),
                    'type'        => 'link',
                    'pasteStyles' => false,
                ],
                'link_icon' => [
                    'label' => esc_html__('Link icon', 'snn'),
                    'type'  => 'icon',
                ],
                'link_icon_position' => [
                    'label'       => esc_html__('Link icon position', 'snn'),
                    'type'        => 'select',
                    'options'     => [
                        'right' => esc_html__('Right', 'snn'),
                        'left'  => esc_html__('Left', 'snn'),
                    ],
                    'inline'      => true,
                    'placeholder' => esc_html__('Right', 'snn'),
                    'required'    => ['link_icon', '!=', '' ],
                ],
                'link_icon_gap' => [
                    'label'    => esc_html__('Link icon gap', 'snn'),
                    'type'     => 'number',
                    'units'    => true,
                    'default'  => '8px',
                ],
                'image' => [
                    'label' => esc_html__('Image', 'snn'),
                    'type'  => 'image',
                ],
            ],
            'default'       => [
                [
                    'title'       => esc_html__('Tab 1', 'snn'),
                    'description' => esc_html__('Your description for tab 1.', 'snn'),
                    'link_label'  => esc_html__('En savoir plus', 'snn'),
                ],
                [
                    'title'       => esc_html__('Tab 2', 'snn'),
                    'description' => esc_html__('Your description for tab 2.', 'snn'),
                    'link_label'  => esc_html__('En savoir plus', 'snn'),
                ],
                [
                    'title'       => esc_html__('Tab 3', 'snn'),
                    'description' => esc_html__('Your description for tab 3.', 'snn'),
                    'link_label'  => esc_html__('En savoir plus', 'snn'),
                ],
                [
                    'title'       => esc_html__('Tab 4', 'snn'),
                    'description' => esc_html__('Your description for tab 4.', 'snn'),
                    'link_label'  => esc_html__('En savoir plus', 'snn'),
                ],
            ],
        ];

        // Image aspect ratio
        $this->controls['imageAspectRatio'] = [
            'tab'       => 'content',
            'label'     => esc_html__('Image aspect ratio', 'snn'),
            'type'      => 'select',
            'inline'    => true,
            'options'   => [
                ''        => esc_html__('Auto', 'snn'),
                '1 / 1'   => '1:1',
                '4 / 3'   => '4:3',
                '3 / 2'   => '3:2',
                '16 / 9'  => '16:9',
                '21 / 9'  => '21:9',
                '3 / 4'   => '3:4',
                '9 / 16'  => '9:16',
            ],
            'description' => esc_html__('Applies to the image container. Image will be cropped to fit (cover).', 'snn'),
        ];

        // Navigation & autoplay
        $this->controls['showArrows'] = [
            'tab'     => 'content',
            'label'   => esc_html__('Show prev/next arrows', 'snn'),
            'type'    => 'checkbox',
            'inline'  => true,
            'default' => false,
        ];

        $this->controls['prevLabel'] = [
            'tab'      => 'content',
            'label'    => esc_html__('Prev label', 'snn'),
            'type'     => 'text',
            'default'  => 'Prev',
            'inline'   => true,
            'required' => ['showArrows', '=', true],
        ];

        $this->controls['nextLabel'] = [
            'tab'      => 'content',
            'label'    => esc_html__('Next label', 'snn'),
            'type'     => 'text',
            'default'  => 'Next',
            'inline'   => true,
            'required' => ['showArrows', '=', true],
        ];

        $this->controls['autoplay'] = [
            'tab'     => 'content',
            'label'   => esc_html__('Autoplay', 'snn'),
            'type'    => 'checkbox',
            'inline'  => true,
            'default' => false,
        ];

        $this->controls['autoplayDelay'] = [
            'tab'      => 'content',
            'label'    => esc_html__('Autoplay delay (ms)', 'snn'),
            'type'     => 'number',
            'default'  => 5000,
            'inline'   => true,
            'required' => ['autoplay', '=', true],
        ];

        $this->controls['pauseOnHover'] = [
            'tab'      => 'content',
            'label'    => esc_html__('Pause on hover', 'snn'),
            'type'     => 'checkbox',
            'default'  => true,
            'inline'   => true,
            'required' => ['autoplay', '=', true],
        ];

        // STYLE CONTROLS
        $this->controls['tabsAlignment'] = [
            'tab'   => 'content',
            'label' => esc_html__('Tabs align', 'snn'),
            'type'  => 'justify-content',
            'css'   => [
                [
                    'property' => 'justify-content',
                    'selector' => '.snn-services-tabs__menu',
                ],
            ],
        ];

        $this->controls['tabsTypography'] = [
            'tab'   => 'content',
            'label' => esc_html__('Tabs typography', 'snn'),
            'type'  => 'typography',
            'css'   => [
                [
                    'property' => 'font',
                    'selector' => '.snn-services-tabs__tab',
                ],
            ],
        ];

        $this->controls['tabColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Tab color', 'snn'),
            'type'  => 'color',
            'css'   => [
                [
                    'property' => 'color',
                    'selector' => '.snn-services-tabs__tab',
                ],
            ],
        ];

        $this->controls['tabHoverColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Tab hover color', 'snn'),
            'type'  => 'color',
            'css'   => [
                [
                    'property' => 'color',
                    'selector' => '.snn-services-tabs__tab:hover',
                ],
            ],
        ];

        $this->controls['tabActiveColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Tab active color', 'snn'),
            'type'  => 'color',
            'css'   => [
                [
                    'property' => 'color',
                    'selector' => '.snn-services-tabs__tab.is-active',
                ],
            ],
        ];

        $this->controls['tabActiveTypography'] = [
            'tab'   => 'content',
            'label' => esc_html__('Tab active typography', 'snn'),
            'type'  => 'typography',
            'css'   => [
                [
                    'property' => 'font',
                    'selector' => '.snn-services-tabs__tab.is-active',
                ],
            ],
        ];

        // Active underline customization
        $this->controls['tabActiveUnderlineThickness'] = [
            'tab'   => 'content',
            'label' => esc_html__('Active underline thickness', 'snn'),
            'type'  => 'slider',
            'units' => [
                'px' => [ 'min' => 0, 'max' => 12, 'step' => 1 ],
            ],
            'default' => '3px',
            'css' => [
                [
                    'property' => 'height',
                    'selector' => '.snn-services-tabs__tab.is-active:after',
                ],
            ],
        ];

        $this->controls['tabActiveUnderlineColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Active underline color', 'snn'),
            'type'  => 'color',
            'css'   => [
                [
                    'property' => 'background-color',
                    'selector' => '.snn-services-tabs__tab.is-active:after',
                ],
            ],
        ];

        // Title styles
        $this->controls['titleTypography'] = [
            'tab'   => 'content',
            'label' => esc_html__('Title typography', 'snn'),
            'type'  => 'typography',
            'css'   => [
                [
                    'property' => 'font',
                    'selector' => '.snn-services-tabs__title',
                ],
            ],
        ];

        $this->controls['titleColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Title color', 'snn'),
            'type'  => 'color',
            'css'   => [
                [
                    'property' => 'color',
                    'selector' => '.snn-services-tabs__title',
                ],
            ],
        ];

        // Description styles
        $this->controls['descTypography'] = [
            'tab'   => 'content',
            'label' => esc_html__('Description typography', 'snn'),
            'type'  => 'typography',
            'css'   => [
                [
                    'property' => 'font',
                    'selector' => '.snn-services-tabs__desc',
                ],
            ],
        ];

        $this->controls['descColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Description color', 'snn'),
            'type'  => 'color',
            'css'   => [
                [
                    'property' => 'color',
                    'selector' => '.snn-services-tabs__desc',
                ],
            ],
        ];

        // Panel background
        $this->controls['panelBackground'] = [
            'tab'   => 'content',
            'label' => esc_html__('Panel background', 'snn'),
            'type'  => 'color',
            'css'   => [
                [
                    'property' => 'background-color',
                    'selector' => '.snn-services-tabs__panel',
                ],
            ],
        ];

        // Column paddings
        $this->controls['mediaPadding'] = [
            'tab'   => 'content',
            'label' => esc_html__('Image column padding', 'snn'),
            'type'  => 'spacing',
            'css'   => [
                [
                    'property' => 'padding',
                    'selector' => '.snn-services-tabs__media',
                ],
            ],
        ];

        $this->controls['contentPadding'] = [
            'tab'   => 'content',
            'label' => esc_html__('Text column padding', 'snn'),
            'type'  => 'spacing',
            'css'   => [
                [
                    'property' => 'padding',
                    'selector' => '.snn-services-tabs__content',
                ],
            ],
        ];

        // Space between tabs and panel
        $this->controls['menuPanelSpacing'] = [
            'tab'     => 'content',
            'label'   => esc_html__('Space between tabs and panel', 'snn'),
            'type'    => 'slider',
            'units'   => [
                'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                'rem' => [ 'min' => 0, 'max' => 8, 'step' => 0.1 ],
            ],
            'default' => '24px',
            'css'     => [
                [
                    'property' => 'margin-top',
                    'selector' => '.snn-services-tabs__panels',
                ],
            ],
        ];

        // Link styles
        $this->controls['linkTypography'] = [
            'tab'   => 'content',
            'label' => esc_html__('Link typography', 'snn'),
            'type'  => 'typography',
            'css'   => [
                [
                    'property' => 'font',
                    'selector' => '.snn-services-tabs__link a',
                ],
            ],
        ];

        $this->controls['linkColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Link color', 'snn'),
            'type'  => 'color',
            'css'   => [
                [
                    'property' => 'color',
                    'selector' => '.snn-services-tabs__link a',
                ],
            ],
        ];

        $this->controls['linkHoverColor'] = [
            'tab'   => 'content',
            'label' => esc_html__('Link hover color', 'snn'),
            'type'  => 'color',
            'css'   => [
                [
                    'property' => 'color',
                    'selector' => '.snn-services-tabs__link a:hover',
                ],
            ],
        ];

        $this->controls['linkDecoration'] = [
            'tab'   => 'content',
            'label' => esc_html__('Link decoration', 'snn'),
            'type'  => 'select',
            'options' => [
                'none' => esc_html__('None', 'snn'),
                'underline' => esc_html__('Underline', 'snn'),
                'overline' => esc_html__('Overline', 'snn'),
                'line-through' => esc_html__('Line-through', 'snn'),
            ],
            'css' => [
                [
                    'property' => 'text-decoration',
                    'selector' => '.snn-services-tabs__link a',
                ],
            ],
        ];

        $this->controls['linkHoverDecoration'] = [
            'tab'   => 'content',
            'label' => esc_html__('Link hover decoration', 'snn'),
            'type'  => 'select',
            'options' => [
                'none' => esc_html__('None', 'snn'),
                'underline' => esc_html__('Underline', 'snn'),
                'overline' => esc_html__('Overline', 'snn'),
                'line-through' => esc_html__('Line-through', 'snn'),
            ],
            'css' => [
                [
                    'property' => 'text-decoration',
                    'selector' => '.snn-services-tabs__link a:hover',
                ],
            ],
        ];
    }

    public function render() {
        $tabs   = isset($this->settings['tabs']) && is_array($this->settings['tabs']) ? $this->settings['tabs'] : [];
        $open   = isset($this->settings['openTab']) ? intval($this->settings['openTab']) : 0;

        if (!$tabs) {
            echo esc_html__('Add at least one tab.', 'snn');
            return;
        }

        // Root attributes
        $this->set_attribute('_root', 'class', 'snn-services-tabs');
        if (isset($this->attributes['_root']['id']) && !empty($this->attributes['_root']['id'])) {
            $root_id = $this->attributes['_root']['id'];
        } else {
            $root_id = 'snn-services-tabs-' . uniqid();
            $this->set_attribute('_root', 'id', $root_id);
        }

        echo '<div ' . $this->render_attributes('_root') . '>';

        // Header with optional arrows
        $show_arrows = ! empty($this->settings['showArrows']);
        $prev_label  = isset($this->settings['prevLabel']) ? esc_html($this->settings['prevLabel']) : 'Prev';
        $next_label  = isset($this->settings['nextLabel']) ? esc_html($this->settings['nextLabel']) : 'Next';

        echo '<div class="snn-services-tabs__header">';
        if ($show_arrows) {
            echo '<button type="button" class="snn-services-tabs__arrow snn-services-tabs__prev" aria-label="' . esc_attr__('Previous tab', 'snn') . '">' . $prev_label . '</button>';
        }

        // Menu
        echo '<div class="snn-services-tabs__menu" role="tablist">';
        foreach ($tabs as $index => $item) {
            $title = isset($item['title']) ? wp_kses_post($item['title']) : esc_html__('Tab', 'snn');
            $active_class = $index === $open ? ' is-active' : '';
            echo '<button type="button" class="snn-services-tabs__tab' . esc_attr($active_class) . '" role="tab" data-index="' . esc_attr($index) . '">' . $title . '</button>';
        }
        echo '</div>'; // menu

        if ($show_arrows) {
            echo '<button type="button" class="snn-services-tabs__arrow snn-services-tabs__next" aria-label="' . esc_attr__('Next tab', 'snn') . '">' . $next_label . '</button>';
        }
        echo '</div>'; // header

        // Panels
        echo '<div class="snn-services-tabs__panels">';
        foreach ($tabs as $index => $item) {
            $is_active = $index === $open;
            $panel_classes = 'snn-services-tabs__panel' . ($is_active ? ' is-active' : '');
            $panel_style   = $is_active ? '' : 'display:none;';

            $title       = isset($item['title']) ? wp_kses_post($item['title']) : '';
            $description = isset($item['description']) ? $item['description'] : '';
            $link_label  = isset($item['link_label']) ? esc_html($item['link_label']) : '';
            $link        = isset($item['link']) ? $item['link'] : null;
            $image       = isset($item['image']) ? $item['image'] : null;

            $link_url      = $link && !empty($link['url']) ? esc_url($link['url']) : '';
            $link_target   = $link && !empty($link['target']) ? ' target="_blank"' : '';
            $link_rel_attr = '';
            if ($link && !empty($link['rel'])) {
                $rel = is_array($link['rel']) ? implode(' ', $link['rel']) : $link['rel'];
                $link_rel_attr = ' rel="' . esc_attr($rel) . '"';
            }

            echo '<div class="' . esc_attr($panel_classes) . '" role="tabpanel" data-index="' . esc_attr($index) . '" style="' . esc_attr($panel_style) . '">';
            echo '<div class="snn-services-tabs__layout">';

            // Left: image
            echo '<div class="snn-services-tabs__media">';
            if ($image && !empty($image['id'])) {
                $size = !empty($image['size']) ? $image['size'] : 'large';
                echo wp_get_attachment_image(intval($image['id']), $size, false, ['class' => 'snn-services-tabs__img']);
            }
            echo '</div>';

            // Right: content
            echo '<div class="snn-services-tabs__content">';
            if ($title) {
                echo '<h3 class="snn-services-tabs__title">' . $title . '</h3>';
            }
            if (!empty($description)) {
                echo '<div class="snn-services-tabs__desc">' . wp_kses_post($description) . '</div>';
            }
            if ($link_url && $link_label) {
                $icon_html = '';
                $icon_pos  = isset($item['link_icon_position']) ? $item['link_icon_position'] : 'right';
                $icon_gap  = isset($item['link_icon_gap']) ? $item['link_icon_gap'] : '8px';
                if (!empty($item['link_icon'])) {
                    $icon_html = \Bricks\Element::render_icon($item['link_icon']);
                }
                echo '<p class="snn-services-tabs__link"><a href="' . $link_url . '"' . $link_target . $link_rel_attr . ' style="display:inline-flex;align-items:center;gap:' . esc_attr($icon_gap) . ';">';
                if ($icon_html && $icon_pos === 'left') { echo $icon_html; }
                echo esc_html($link_label);
                if ($icon_html && $icon_pos !== 'left') { echo $icon_html; }
                echo '</a></p>';
            }
            echo '</div>'; // content

            echo '</div>'; // layout
            echo '</div>'; // panel
        }
        echo '</div>'; // panels

        // Styles
        echo '<style>
            #' . esc_attr($root_id) . ' { width: 100%; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__header { display:flex; align-items:center; gap:1rem; margin-bottom:1rem; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__arrow { appearance:none; background:transparent; border:1px solid currentColor; padding:.25rem .6rem; cursor:pointer; border-radius:4px; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__menu { display: flex; gap: 2.5rem; border-bottom: 1px solid rgba(0,0,0,.12); flex-grow: 1; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__tab { position: relative; appearance:none; background:transparent; border:none; padding: 1rem 0; cursor:pointer; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__tab.is-active { font-weight: 600; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__tab.is-active:after { content: ""; position:absolute; left:0; right:0; bottom:-1px; height:3px; background: currentColor; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__panels { margin-top:1.5rem; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__panel { display:none; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__panel.is-active { display:block; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__layout { display:grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: center; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__img { width: 100%; height: auto; display:block; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__title { margin: 0 0 .75rem 0;  line-height: 1.15; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__desc { margin-bottom: 1rem; }
            #' . esc_attr($root_id) . ' .snn-services-tabs__link a { text-decoration: none; position: relative; }
            @media (max-width: 900px) {
                #' . esc_attr($root_id) . ' .snn-services-tabs__layout { grid-template-columns: 1fr; }
            }
        </style>';

        // Aspect ratio CSS (scoped) if set
        $aspect_ratio = isset($this->settings['imageAspectRatio']) ? trim($this->settings['imageAspectRatio']) : '';
        if (!empty($aspect_ratio)) {
            // Safe allowlist: numbers, slash and whitespace
            if (preg_match('/^[0-9]+\s*\/\s*[0-9]+$/', $aspect_ratio)) {
                echo '<style>#' . esc_attr($root_id) . ' .snn-services-tabs__media{aspect-ratio:' . esc_attr($aspect_ratio) . ';overflow:hidden;}#' . esc_attr($root_id) . ' .snn-services-tabs__img{height:100%;width:100%;object-fit:cover;}</style>';
            }
        }

        // Script
        $autoplay      = ! empty($this->settings['autoplay']);
        $autoplayDelay = isset($this->settings['autoplayDelay']) ? intval($this->settings['autoplayDelay']) : 5000;
        $pauseOnHover  = ! empty($this->settings['pauseOnHover']);

        echo '<script>(function(){
            var root = document.getElementById(' . json_encode($root_id) . ');
            if(!root) return;
            var tabs = root.querySelectorAll(".snn-services-tabs__tab");
            var panels = root.querySelectorAll(".snn-services-tabs__panel");
            var prevBtn = root.querySelector(".snn-services-tabs__prev");
            var nextBtn = root.querySelector(".snn-services-tabs__next");
            function activate(i){
                tabs.forEach(function(t){ t.classList.remove("is-active"); });
                panels.forEach(function(p){ p.classList.remove("is-active"); p.style.display = "none"; });
                if(tabs[i]) tabs[i].classList.add("is-active");
                if(panels[i]) { panels[i].classList.add("is-active"); panels[i].style.display = "block"; }
            }
            function currentIndex(){ var idx = 0; tabs.forEach(function(t,i){ if(t.classList.contains("is-active")) idx=i; }); return idx; }
            function next(){ var i=currentIndex(); i=(i+1)%tabs.length; activate(i); restart(); }
            function prev(){ var i=currentIndex(); i=(i-1+tabs.length)%tabs.length; activate(i); restart(); }
            tabs.forEach(function(tab){
                tab.addEventListener("click", function(){
                    var idx = parseInt(tab.getAttribute("data-index"), 10) || 0;
                    activate(idx);
                    restart();
                });
            });
            if(prevBtn){ prevBtn.addEventListener("click", prev); }
            if(nextBtn){ nextBtn.addEventListener("click", next); }

            var autoplay = ' . ($autoplay ? 'true' : 'false') . ';
            var delay = ' . $autoplayDelay . ';
            var pauseOnHover = ' . ($pauseOnHover ? 'true' : 'false') . ';
            var timer = null;
            function stop(){ if(timer){ clearInterval(timer); timer=null; } }
            function start(){ if(!autoplay) return; stop(); timer = setInterval(next, delay); }
            function restart(){ stop(); start(); }
            if(pauseOnHover){ root.addEventListener("mouseenter", stop); root.addEventListener("mouseleave", start); }
            start();
        })();</script>';

        echo '</div>';
    }
}

