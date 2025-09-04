<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

use Bricks\Element;

class Snn_Services_Steps extends Element {
    public $category     = 'snn';
    public $name         = 'services-steps';
    public $icon         = 'ti-view-list';
    public $css_selector = '.snn-services-steps';
    public $scripts      = [];

    public function get_label() {
        return esc_html__('Services – Étapes', 'snn');
    }

    public function set_controls() {
        $this->controls['main_title'] = [
            'tab'   => 'content',
            'label' => esc_html__('Titre principal', 'snn'),
            'type'  => 'text',
        ];

        // Image de gauche par défaut (utilisée au chargement)
        $this->controls['default_image'] = [
            'tab'   => 'content',
            'label' => esc_html__('Image par défaut (colonne gauche)', 'snn'),
            'type'  => 'image',
        ];

        // Steps
        $this->controls['steps'] = [
            'tab'           => 'content',
            'label'         => esc_html__('Étapes', 'snn'),
            'type'          => 'repeater',
            'titleProperty' => 'title',
            'fields'        => [
                'title' => [ 'label' => esc_html__('Titre', 'snn'), 'type' => 'text' ],
                'description' => [ 'label' => esc_html__('Description', 'snn'), 'type' => 'text' ],
                'image' => [ 'label' => esc_html__('Image de l\'étape', 'snn'), 'type' => 'image' ],
                'image_url' => [ 'label' => esc_html__('URL image (fallback)', 'snn'), 'type' => 'text' ],
                'anchor' => [ 'label' => esc_html__('Ancre (optionnelle)', 'snn'), 'type' => 'text' ],
            ],
            'default'       => [
                [ 'title' => 'Expertise', 'description' => 'Analyse complète de votre bien immobilier par nos experts CEI.', 'image_url' => 'https://picsum.photos/1200/1600?random=1' ],
                [ 'title' => 'Préparation', 'description' => 'Documentation de vente, site dédié, bases de données sécurisées.', 'image_url' => 'https://picsum.photos/1200/1600?random=2' ],
                [ 'title' => 'Mise en vente', 'description' => 'Sélection d’investisseurs, visites, analyse des offres.', 'image_url' => 'https://picsum.photos/1200/1600?random=3' ],
                [ 'title' => 'Closing', 'description' => 'Négociation finale, due diligence, signature.', 'image_url' => 'https://picsum.photos/1200/1600?random=4' ],
            ],
        ];
    }

    public function render() {
        $steps = isset($this->settings['steps']) && is_array($this->settings['steps']) ? $this->settings['steps'] : [];

        $this->set_attribute('_root', 'class', 'snn-services-steps');
        if (isset($this->attributes['_root']['id']) && !empty($this->attributes['_root']['id'])) {
            $root_id = $this->attributes['_root']['id'];
        } else {
            $root_id = 'snn-services-steps-' . uniqid();
            $this->set_attribute('_root', 'id', $root_id);
        }

        // Determine initial image
        $initial_img_html = '';
        if (!empty($this->settings['default_image']['id'])) {
            $size = !empty($this->settings['default_image']['size']) ? $this->settings['default_image']['size'] : 'full';
            $initial_img_html = wp_get_attachment_image(intval($this->settings['default_image']['id']), $size, false, [ 'class' => 'service__image-img', 'loading' => 'eager', 'decoding' => 'async' ]);
        } else if (!empty($steps)) {
            // Fallback to first step image URL
            $first_url = $this->get_step_image_url($steps[0]);
            if ($first_url) {
                $initial_img_html = '<img class="service__image-img" src="' . esc_url($first_url) . '" alt="" loading="eager" decoding="async" />';
            }
        }

        echo '<section ' . $this->render_attributes('_root') . '>'; // root
        echo '<div class="service">';
        echo '<div class="service__container">';
        echo '<div class="service__grid">';

        // Left sticky image
        echo '<div class="service__image">';
        echo '<div class="service__image-stack">';
        // Two stacked images for crossfade
        echo '<div class="service__image-layer service__image-layer--front">' . $initial_img_html . '</div>';
        echo '<div class="service__image-layer service__image-layer--back"><img class="service__image-img" src="' . esc_url($this->placeholder()) . '" alt="" loading="lazy" decoding="async" /></div>';
        echo '</div>';
        echo '</div>';

        // Right steps
        echo '<div class="service__content">';
        if (!empty($this->settings['main_title'])) {
            echo '<h2 class="service__title">' . wp_kses_post($this->settings['main_title']) . '</h2>';
        }

        echo '<ol class="service__steps" role="list">';
        foreach ($steps as $i => $step) {
            $index = $i + 1;
            $title = isset($step['title']) ? wp_kses_post($step['title']) : '';
            $desc  = isset($step['description']) ? wp_kses_post($step['description']) : '';
            $url   = $this->get_step_image_url($step);
            $anchor = isset($step['anchor']) && $step['anchor'] !== '' ? sanitize_title($step['anchor']) : 'step-' . $index;

            echo '<li id="' . esc_attr($anchor) . '" class="step" tabindex="0" data-image="' . esc_url($url) . '">';
            echo '<div class="step__card">';
            echo '<h3 class="step__title"><span class="step__num">' . $index . '.</span> ' . $title . '</h3>';
            if ($desc) {
                echo '<p class="step__desc">' . $desc . '</p>';
            }
            echo '</div>';
            echo '</li>';
        }
        echo '</ol>';
        echo '</div>'; // content

        echo '</div>'; // grid
        echo '</div>'; // container
        echo '</div>'; // service wrapper

        // Styles
        echo '<style>
        #' . esc_attr($root_id) . ' .service__container{max-width:1200px;margin:0 auto;padding:0;}
        #' . esc_attr($root_id) . ' .service__grid{display:grid;grid-template-columns:1fr;gap:24px;}
        @media(min-width:1024px){
            #' . esc_attr($root_id) . ' .service__grid{grid-template-columns:1fr 1fr;align-items:start;}
        }
        #' . esc_attr($root_id) . ' .service__image{position:sticky;top:0;height:auto;}
        #' . esc_attr($root_id) . ' .service__image-stack{position:relative;width:100%;height:100%;overflow:hidden;border-radius:0;background:#E7EFFA;}
        #' . esc_attr($root_id) . ' .service__image-layer{position:absolute;inset:0;}
        #' . esc_attr($root_id) . ' .service__image-img{width:100%;height:100%;object-fit:cover;display:block;}
        #' . esc_attr($root_id) . ' .service__image-layer--front{opacity:1;transition:opacity .35s ease;}
        #' . esc_attr($root_id) . ' .service__image-layer--back{opacity:0;}
        #' . esc_attr($root_id) . ' .service__content{min-height:200vh;}
        #' . esc_attr($root_id) . ' .service__title{color:#243046;margin:0 0 24px 0;font-weight:600;}
        #' . esc_attr($root_id) . ' .service__steps{display:grid;gap:28px;margin:0;padding:0;list-style:none;}
        #' . esc_attr($root_id) . ' .step{outline:none;}
        #' . esc_attr($root_id) . ' .step__card{background:#F8FAFC;border:1px solid #E5E7EB;border-radius:0;padding:24px;color:#243046;transition:background-color .2s ease,color .2s ease;}
        #' . esc_attr($root_id) . ' .step__card:hover{box-shadow:none;} 
        #' . esc_attr($root_id) . ' .step__title{margin:0;font-size:1.125rem;display:flex;align-items:center;gap:8px;}
        #' . esc_attr($root_id) . ' .step__num{display:inline-grid;place-items:center;background:#E7EFFA;color:#243046;width:32px;height:32px;border-radius:999px;font-weight:600;}
        #' . esc_attr($root_id) . ' .step__desc{margin:.5rem 0 0 0;}
        /* Active */
        #' . esc_attr($root_id) . ' .step.is-active .step__card,
        #' . esc_attr($root_id) . ' .step:focus .step__card{background:#0C2D57;color:#fff;border-color:#0C2D57;}
        #' . esc_attr($root_id) . ' .step.is-active .step__num,
        #' . esc_attr($root_id) . ' .step:focus .step__num{background:#092142;color:#fff;}
        </style>';

        // JS
        $rootId = json_encode($root_id);
        $js = <<<JS
<script>(function(){
  var root = document.getElementById($rootId);
  if(!root) return;
  var steps = Array.prototype.slice.call(root.querySelectorAll('.step'));
  var front = root.querySelector('.service__image-layer--front .service__image-img');
  var back  = root.querySelector('.service__image-layer--back .service__image-img');
  var frontLayer = root.querySelector('.service__image-layer--front');
  var backLayer  = root.querySelector('.service__image-layer--back');
  var imageStack = root.querySelector('.service__image-stack');
  var stepsList = root.querySelector('.service__steps');
  function swapImage(url){
    if(!url || !front || !back) return;
    if(front.getAttribute('src') === url) return;
    back.src = url; backLayer.style.opacity = 1; frontLayer.style.opacity = 0;
    setTimeout(function(){ var tmpSrc = front.src; front.src = back.src; back.src = tmpSrc; frontLayer.style.opacity = 1; backLayer.style.opacity = 0; }, 380);
  }
  var io; function createObserver(){
    if(io) io.disconnect();
    io = new IntersectionObserver(function(entries){
      entries.forEach(function(entry){
        var el = entry.target;
        if(entry.isIntersecting && entry.intersectionRatio >= 0.5){
          steps.forEach(function(s){ s.classList.remove('is-active'); });
          el.classList.add('is-active');
          var url = el.getAttribute('data-image');
          swapImage(url);
        }
      });
    }, { threshold:[0,0.5,1], rootMargin:'0px' });
    steps.forEach(function(s){ io.observe(s); });
  }
  createObserver();
  // Sync image height with steps list height
  function syncImageHeight(){
    if(!imageStack || !stepsList) return;
    imageStack.style.height = stepsList.getBoundingClientRect().height + 'px';
  }
  syncImageHeight();
  var ro = new ResizeObserver(function(){ syncImageHeight(); });
  if(stepsList){ ro.observe(stepsList); }
  root.addEventListener('click', function(e){
    var a = e.target.closest("a[href^='#']");
    if(!a) return;
    var id = a.getAttribute('href').substring(1);
    var target = root.querySelector('#'+CSS.escape(id));
    if(target){ e.preventDefault(); window.scrollTo({ top: target.getBoundingClientRect().top + window.pageYOffset - 24, behavior: 'smooth' }); }
  });
  var to; window.addEventListener('resize', function(){ clearTimeout(to); to = setTimeout(createObserver, 200); });
})();</script>
JS;
        echo $js;

        echo '</section>';
    }

    private function get_step_image_url($step){
        if (!empty($step['image']['id'])) {
            $size = !empty($step['image']['size']) ? $step['image']['size'] : 'full';
            $src = wp_get_attachment_image_src(intval($step['image']['id']), $size);
            if ($src && !empty($src[0])) { return $src[0]; }
        }
        if (!empty($step['image_url'])) {
            return esc_url_raw($step['image_url']);
        }
        return '';
    }

    private function placeholder(){
        return 'data:image/gif;base64,R0lGODlhAQABAAAAACw='; // 1x1 gif
    }
}


