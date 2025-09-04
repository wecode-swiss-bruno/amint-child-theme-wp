<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

use Bricks\Element;

class Snn_References_Grid extends Element {
    public $category     = 'snn';
    public $name         = 'references-grid';
    public $icon         = 'ti-layout-grid3';
    public $css_selector = '.snn-references';
    public $scripts      = [];

    public function get_label() {
        return esc_html__('Références (onglets + grille)', 'snn');
    }

    public function set_controls() {
        // Filters
        $this->controls['filters'] = [
            'tab'           => 'content',
            'label'         => esc_html__('Filtres (onglets)', 'snn'),
            'type'          => 'repeater',
            'titleProperty' => 'label',
            'fields'        => [
                'id'    => [ 'label' => esc_html__('Identifiant (slug)', 'snn'), 'type' => 'text' ],
                'label' => [ 'label' => esc_html__('Label', 'snn'), 'type' => 'text' ],
            ],
            'default'       => [
                [ 'id' => 'invest',   'label' => 'Conseils en investissements' ],
                [ 'id' => 'expertise','label' => 'Expertise & conseils stratégiques' ],
                [ 'id' => 'locataire','label' => 'Mise en valeur et représentation locataire' ],
            ],
        ];

        // Cards
        $this->controls['cards'] = [
            'tab'           => 'content',
            'label'         => esc_html__('Cartes', 'snn'),
            'type'          => 'repeater',
            'titleProperty' => 'title',
            'fields'        => [
                'category'    => [ 'label' => esc_html__('Catégorie (id du filtre)', 'snn'), 'type' => 'text' ],
                'image'       => [ 'label' => esc_html__('Image', 'snn'), 'type' => 'image' ],
                'image_url'   => [ 'label' => esc_html__('URL image (fallback)', 'snn'), 'type' => 'text' ],
                'date'        => [ 'label' => esc_html__('Date', 'snn'), 'type' => 'text' ],
                'title'       => [ 'label' => esc_html__('Titre', 'snn'), 'type' => 'text' ],
                'bullet_one'  => [ 'label' => esc_html__('Ligne 1', 'snn'), 'type' => 'text' ],
                'bullet_two'  => [ 'label' => esc_html__('Ligne 2', 'snn'), 'type' => 'text' ],
            ],
            'default'       => [
                [ 'category' => 'invest',   'image_url' => 'https://picsum.photos/id/1011/1200/800', 'date' => '2023 - 2024', 'title' => 'Clinique la Prairie (VD)', 'bullet_one' => 'Ceci est un texte', 'bullet_two' => 'Ceci est un texte' ],
                [ 'category' => 'expertise','image_url' => 'https://picsum.photos/id/1015/1200/800', 'date' => '2023 - 2024', 'title' => 'Clinique la Prairie (VD)', 'bullet_one' => 'Ceci est un texte', 'bullet_two' => 'Ceci est un texte' ],
                [ 'category' => 'locataire','image_url' => 'https://picsum.photos/id/1025/1200/800', 'date' => '2023 - 2024', 'title' => 'Clinique la Prairie (VD)', 'bullet_one' => 'Ceci est un texte', 'bullet_two' => 'Ceci est un texte' ],
                [ 'category' => 'invest',   'image_url' => 'https://picsum.photos/id/1035/1200/800', 'date' => '2023 - 2024', 'title' => 'Clinique la Prairie (VD)', 'bullet_one' => 'Ceci est un texte', 'bullet_two' => 'Ceci est un texte' ],
                [ 'category' => 'expertise','image_url' => 'https://picsum.photos/id/1045/1200/800', 'date' => '2023 - 2024', 'title' => 'Clinique la Prairie (VD)', 'bullet_one' => 'Ceci est un texte', 'bullet_two' => 'Ceci est un texte' ],
                [ 'category' => 'locataire','image_url' => 'https://picsum.photos/id/1055/1200/800', 'date' => '2023 - 2024', 'title' => 'Clinique la Prairie (VD)', 'bullet_one' => 'Ceci est un texte', 'bullet_two' => 'Ceci est un texte' ],
            ],
        ];
    }

    public function render() {
        $filters = isset($this->settings['filters']) && is_array($this->settings['filters']) ? $this->settings['filters'] : [];
        $cards   = isset($this->settings['cards']) && is_array($this->settings['cards']) ? $this->settings['cards'] : [];

        $this->set_attribute('_root', 'class', 'snn-references');
        if (isset($this->attributes['_root']['id']) && !empty($this->attributes['_root']['id'])) {
            $root_id = $this->attributes['_root']['id'];
        } else {
            $root_id = 'snn-references-' . uniqid();
            $this->set_attribute('_root', 'id', $root_id);
        }

        echo '<section ' . $this->render_attributes('_root') . '>';
        echo '<div class="refs">';
        echo '<div class="refs__container">';
        echo '<div class="refs__tabs" role="tablist" aria-label="Filtres">';
        foreach ($filters as $i => $f) {
            $id    = isset($f['id']) ? sanitize_title($f['id']) : 'cat-' . $i;
            $label = isset($f['label']) ? wp_kses_post($f['label']) : ('Cat ' . ($i+1));
            echo '<button class="refs__tab" type="button" role="tab" data-cat="' . esc_attr($id) . '" aria-selected="' . ($i===0 ? 'true' : 'false') . '">' . $label . '</button>';
        }
        echo '</div>';

        echo '<div class="refs__grid" aria-live="polite">';
        $this->render_cards($cards);
        echo '</div>';

        echo '</div>';
        echo '</div>';

        // Styles inline (simples et sobres)
        echo '<style>
        #' . esc_attr($root_id) . ' .refs__container{max-width:1200px;margin:0 auto;}
        #' . esc_attr($root_id) . ' .refs__tabs{display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e5e7eb;margin-bottom:24px;overflow:auto;}
        #' . esc_attr($root_id) . ' .refs__tab{appearance:none;background:none;border:0;padding:8px 0;color:#243046;font-weight:600;cursor:pointer;white-space:nowrap;border-bottom:2px solid transparent;transition:color .2s ease,border-color .2s ease}
        #' . esc_attr($root_id) . ' .refs__tab[aria-selected="true"]{color:#0C2D57;border-color:#0C2D57}
        #' . esc_attr($root_id) . ' .refs__grid{display:grid;gap:24px;opacity:1;transform:translateY(0);transition:opacity .26s ease, transform .26s ease}
        @media(min-width:1024px){#' . esc_attr($root_id) . ' .refs__grid{grid-template-columns:repeat(3,1fr)}}
        @media(min-width:640px) and (max-width:1023.98px){#' . esc_attr($root_id) . ' .refs__grid{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:639.98px){#' . esc_attr($root_id) . ' .refs__grid{grid-template-columns:1fr}}
        #' . esc_attr($root_id) . ' .refcard{background:#fff;border:1px solid #e5e7eb;overflow:hidden;display:flex;flex-direction:column}
        #' . esc_attr($root_id) . ' .refcard__img{display:block;width:100%;height:auto;object-fit:cover;aspect-ratio:4/3}
        #' . esc_attr($root_id) . ' .refcard__body{padding:12px 12px 16px}
        #' . esc_attr($root_id) . ' .refcard__date{color:#8a94a4;font-size:.875rem;margin-bottom:4px}
        #' . esc_attr($root_id) . ' .refcard__title{margin:0 0 6px 0;color:#243046;font-weight:600}
        #' . esc_attr($root_id) . ' .refcard__list{margin:0;padding-left:18px;color:#4b5563;}
        #' . esc_attr($root_id) . ' .is-fading{opacity:0;transform:translateY(8px)}
        </style>';

        // JS (filtrage + fade)
        $rootId = json_encode($root_id);
        $js = <<<JS
<script>(function(){
  var root = document.getElementById($rootId);
  if(!root) return;
  var grid = root.querySelector('.refs__grid');
  var tabs = [].slice.call(root.querySelectorAll('.refs__tab'));
  function render(cat){
    if(!grid) return;
    grid.classList.add('is-fading');
    setTimeout(function(){
      var items = [].slice.call(grid.querySelectorAll('.refcard'));
      items.forEach(function(it){ it.style.display = (!cat || it.getAttribute('data-cat')===cat) ? '' : 'none'; });
      grid.classList.remove('is-fading');
    }, 140);
  }
  tabs.forEach(function(t){ t.addEventListener('click', function(){
    tabs.forEach(function(x){ x.setAttribute('aria-selected', 'false'); });
    t.setAttribute('aria-selected', 'true');
    render(t.getAttribute('data-cat'));
  }); });
  var tablist = root.querySelector('.refs__tabs');
  if(tablist){ tablist.addEventListener('keydown', function(e){
    if(e.key!== 'ArrowLeft' && e.key!=='ArrowRight') return;
    var idx = tabs.findIndex(function(tb){ return tb.getAttribute('aria-selected')==='true'; });
    idx = e.key==='ArrowRight' ? (idx+1)%tabs.length : (idx-1+tabs.length)%tabs.length;
    tabs[idx].focus(); tabs[idx].click();
  }); }
  render(tabs.length?tabs[0].getAttribute('data-cat'):'');
})();</script>
JS;
        echo $js;

        echo '</section>';
    }

    private function render_cards($cards) {
        foreach ($cards as $c) {
            $cat = isset($c['category']) ? sanitize_title($c['category']) : '';
            $title = isset($c['title']) ? wp_kses_post($c['title']) : '';
            $date = isset($c['date']) ? wp_kses_post($c['date']) : '';
            $b1 = isset($c['bullet_one']) ? wp_kses_post($c['bullet_one']) : '';
            $b2 = isset($c['bullet_two']) ? wp_kses_post($c['bullet_two']) : '';
            $imgUrl = $this->get_image_url($c);
            echo '<article class="refcard" data-cat="' . esc_attr($cat) . '">';
            if ($imgUrl) {
                echo '<img class="refcard__img" src="' . esc_url($imgUrl) . '" alt="" loading="lazy" decoding="async">';
            }
            echo '<div class="refcard__body">';
            if ($date) { echo '<div class="refcard__date">' . $date . '</div>'; }
            if ($title) { echo '<h3 class="refcard__title">' . $title . '</h3>'; }
            echo '<ul class="refcard__list">';
            if ($b1) { echo '<li>' . $b1 . '</li>'; }
            if ($b2) { echo '<li>' . $b2 . '</li>'; }
            echo '</ul>';
            echo '</div>';
            echo '</article>';
        }
    }

    private function get_image_url($item){
        if (!empty($item['image']['id'])) {
            $size = !empty($item['image']['size']) ? $item['image']['size'] : 'large';
            $src = wp_get_attachment_image_src(intval($item['image']['id']), $size);
            if ($src && !empty($src[0])) { return $src[0]; }
        }
        if (!empty($item['image_url'])) {
            return esc_url_raw($item['image_url']);
        }
        return '';
    }
}


