# Configuration des informations d'entreprise et menus de footer

## Aperçu

Ce thème inclut maintenant un système complet pour gérer les informations de l'entreprise et les menus de footer. Deux nouvelles pages d'options ont été ajoutées automatiquement dans l'admin WordPress.

## Pages d'options disponibles

### 1. Informations de l'entreprise
**Accès :** Admin → Informations de l'entreprise

Champs disponibles :
- **Nom de l'entreprise** : Le nom officiel de votre entreprise
- **Adresse complète** : L'adresse physique complète
- **Téléphone** : Numéro de téléphone principal
- **Email** : Adresse email de contact
- **Site web** : URL du site web principal
- **Slogan** : Le slogan ou la phrase d'accroche de l'entreprise
- **Texte de copyright du footer** : Texte qui apparaîtra dans le footer
- **Logos du footer** : Logos multiples pour le footer (champ répétable)

### 2. Réseaux sociaux
**Accès :** Admin → Réseaux sociaux

Réseaux disponibles :
- Facebook
- Twitter
- Instagram
- LinkedIn
- YouTube
- TikTok

## Emplacements de menus

Trois nouveaux emplacements de menus ont été enregistrés :

1. **Footer 1** (`footer_1`)
2. **Footer 2** (`footer_2`) 
3. **Footer Legal Links** (`footer_legal_links`)

**Configuration :** Admin → Apparence → Menus

## Utilisation avec des shortcodes (recommandé)

### Shortcodes pour les informations d'entreprise

```
[company_name]
[company_address] ou [company_address br="false"]
[company_phone] ou [company_phone link="true"] ou [company_phone link="true" text="Appelez-nous"]
[company_email] ou [company_email link="true"] ou [company_email link="true" text="Contactez-nous"]
[company_website] ou [company_website link="true" target="_blank" text="Visitez notre site"]
[company_slogan]
[footer_copyright] ou [footer_copyright year="false"]
[footer_logos] ou [footer_logos size="large" class="my-logos" link="true"]
```

### Shortcodes pour les réseaux sociaux

```
// Réseaux individuels (URL seulement)
[social_facebook]
[social_twitter]
[social_instagram]
[social_linkedin]
[social_youtube]
[social_tiktok]

// Réseaux individuels avec liens
[social_facebook link="true"]
[social_facebook link="true" text="Suivez-nous"]
[social_facebook link="true" icon="true"]

// Tous les réseaux sociaux
[social_networks]
[social_networks icons="true" separator=" | "]
[social_networks icons="false" class="my-social-class"]
```

### Shortcodes pour les menus de footer

```
[footer_menu_1]
[footer_menu_2]
[footer_legal_menu]
[footer_menu_1 class="custom-menu" container="div"]
```

### Shortcode combiné pour les informations d'entreprise

```
[company_info]
[company_info fields="name,slogan,phone,email"]
[company_info fields="name,address" separator="<br><br>" phone_link="true"]
[company_info wrapper="section" class="contact-info"]
```

## Utilisation dans les templates (PHP)

### Fonctions pour les informations d'entreprise

```php
// Informations de base
echo get_company_name();
echo get_company_address();
echo get_company_phone();
echo get_company_email();
echo get_company_website();
echo get_company_slogan();
echo get_footer_copyright();

// Logos du footer
$logos = get_footer_logos();
foreach ($logos as $logo_id) {
    echo wp_get_attachment_image($logo_id, 'medium');
}
```

### Fonctions pour les réseaux sociaux

```php
// Réseaux individuels
echo get_social_facebook();
echo get_social_twitter();
echo get_social_instagram();
echo get_social_linkedin();
echo get_social_youtube();
echo get_social_tiktok();

// Tous les réseaux sociaux
$social_networks = get_all_social_networks();
foreach ($social_networks as $network => $url) {
    if (!empty($url)) {
        echo '<a href="' . esc_url($url) . '">' . ucfirst($network) . '</a>';
    }
}

// Affichage automatique avec icônes
display_social_networks(true, '_blank', 'my-social-class');
```

### Fonctions pour les menus de footer

```php
// Afficher les menus
display_footer_menu_1('custom-menu-class');
display_footer_menu_2('custom-menu-class');
display_footer_legal_menu('custom-menu-class');

// Ou utiliser directement
snn_display_footer_menu('footer_1', 'menu-class');
```

### Données structurées

Pour améliorer le SEO, ajoutez les données structurées de l'entreprise :

```php
// Dans le <head> de votre template
display_company_structured_data();
```

## Exemples d'utilisation dans Bricks Builder

### Avec les shortcodes (méthode recommandée)

Vous pouvez utiliser les shortcodes directement dans :
- **Éléments Text** : Insérez simplement le shortcode dans le contenu
- **Éléments Code** : Utilisez `echo do_shortcode('[shortcode]');`
- **Dynamic Data** : Utilisez les shortcodes comme contenu dynamique

#### Exemples dans les éléments Text :

**Footer avec informations d'entreprise :**
```
<h3>[company_name]</h3>
<p>[company_slogan]</p>
<p>[company_address]</p>
<p>[company_phone link="true" text="📞 Appelez-nous"]</p>
<p>[company_email link="true" text="✉️ Contactez-nous"]</p>
```

**Réseaux sociaux :**
```
<div class="social-footer">
    [social_networks icons="true" separator=" "]
</div>
```

**Copyright :**
```
<p class="copyright">[footer_copyright]</p>
```

#### Exemples dans les éléments Code :

**Informations complètes d'entreprise :**
```html
<div class="company-contact">
    <?php echo do_shortcode('[company_info fields="name,address,phone,email" separator="<br>" phone_link="true" email_link="true"]'); ?>
</div>
```

**Logos du footer :**
```html
<div class="footer-logos">
    <?php echo do_shortcode('[footer_logos size="medium" link="true"]'); ?>
</div>
```

### Avec les fonctions PHP (méthode alternative)

Vous pouvez aussi utiliser les fonctions PHP dans des éléments Code de Bricks Builder :

### Exemple : Footer avec informations d'entreprise

```php
<div class="company-info">
    <h3><?php echo get_company_name(); ?></h3>
    <p><?php echo nl2br(get_company_address()); ?></p>
    <p>
        <a href="tel:<?php echo get_company_phone(); ?>">
            <?php echo get_company_phone(); ?>
        </a>
    </p>
    <p>
        <a href="mailto:<?php echo get_company_email(); ?>">
            <?php echo get_company_email(); ?>
        </a>
    </p>
</div>
```

### Exemple : Réseaux sociaux

```php
<div class="social-networks">
    <?php display_social_networks(true, '_blank', 'social-icons'); ?>
</div>
```

### Exemple : Menus de footer

```php
<div class="footer-menus">
    <div class="footer-menu-1">
        <?php display_footer_menu_1('footer-nav'); ?>
    </div>
    <div class="footer-menu-2">
        <?php display_footer_menu_2('footer-nav'); ?>
    </div>
    <div class="footer-legal">
        <?php display_footer_legal_menu('legal-nav'); ?>
    </div>
</div>
```

## Notes techniques

- Les champs sont enregistrés dans le système de champs personnalisés existant du thème
- Les données sont stockées comme options WordPress avec le préfixe `snn_opt_`
- Les emplacements de menus sont enregistrés automatiquement au chargement du thème
- Toutes les fonctions incluent une protection contre les erreurs et la sécurisation des données

## Support

Pour toute question ou personnalisation, consultez les fichiers :
- `/includes/company-settings.php` - Configuration principale
- `/includes/company-helpers.php` - Fonctions d'aide
