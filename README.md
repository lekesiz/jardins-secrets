# Jardins Secrets — Site WordPress

Site web professionnel pour **Jardins Secrets**, entreprise paysagiste basée à Montbronn (Moselle).

## Projet Tuteuré — LPDWCA 2025/2026
**Groupe JS** : Mikail Lekesiz, Stéphane Vallejo, Virginie Sanfins, Catherine Braun

## Stack technique
- WordPress + Spectra One (thème parent `flavor`)
- Spectra Gutenberg Blocks
- Hébergement : Hostinger
- Formulaires : Tally.so
- Polices : Google Fonts (Playfair Display + Open Sans)

## Structure du projet

```
jardins-secrets/
├── style.css              # Child theme + CSS (palette, responsive, a11y)
├── functions.php          # Fonctions (Gutenberg palette, SEO schema, shortcodes)
├── assets/
│   └── js/
│       └── jardins-secrets.js   # JS (FAQ accordion, animations, back-to-top)
├── templates/
│   ├── page-accueil.html                # Page d'accueil
│   ├── page-particulier.html            # Services particuliers
│   ├── page-pro.html                    # Services professionnels
│   ├── page-realisations.html           # Portfolio / Réalisations
│   ├── page-a-propos.html               # À propos / Notre histoire
│   ├── page-contact.html                # Contact
│   ├── page-parlons-de-votre-projet.html # Formulaire devis
│   ├── page-mentions-legales.html       # Mentions légales (RGPD)
│   ├── page-politique-confidentialite.html # Politique de confidentialité
│   └── footer.html                      # Footer global
└── README.md
```

## Pages du site

| Page | Fichier | Description |
|------|---------|-------------|
| Accueil | `page-accueil.html` | Hero, services, témoignages, CTA |
| Particuliers | `page-particulier.html` | Prestations jardins privés |
| Professionnels | `page-pro.html` | Solutions entreprises & collectivités |
| Réalisations | `page-realisations.html` | Portfolio projets (particuliers + pro) |
| À propos | `page-a-propos.html` | Histoire, équipe, valeurs |
| Contact | `page-contact.html` | Formulaire Tally + coordonnées |
| Devis | `page-parlons-de-votre-projet.html` | Formulaire projet détaillé |
| Mentions légales | `page-mentions-legales.html` | Obligations légales françaises |
| Confidentialité | `page-politique-confidentialite.html` | RGPD / cookies |

## Palette de couleurs
| Couleur | Hex | Usage |
|---------|-----|-------|
| Vert nature | `#2d5016` | Couleur principale, titres, boutons |
| Vert clair | `#4a7c29` | Hover, dégradés |
| Terre/Brun | `#8B6914` | Accents, focus outlines |
| Crème | `#F5F0E8` | Arrière-plans alternatifs |
| Blanc | `#FFFFFF` | Fond principal |

## Fonctionnalités techniques
- **Responsive** : breakpoints 1024px, 768px, 480px avec `clamp()` pour la typographie
- **Accessibilité** : skip link, `aria-expanded`, focus visible, `prefers-reduced-motion`, `prefers-contrast: high`
- **SEO** : Schema.org LocalBusiness (JSON-LD), meta descriptions, titre dynamique
- **Performance** : preconnect Google Fonts, lazy loading iframes, émojis WP désactivés
- **Sécurité** : version WP masquée, login page personnalisée
- **Print** : styles d'impression dédiés

## Installation
1. Installer WordPress + Spectra One sur Hostinger
2. Copier le contenu du repo dans `wp-content/themes/jardins-secrets-child/`
3. Activer le child theme dans Apparence > Thèmes
4. Créer les pages dans WordPress et copier le contenu HTML des templates
5. Configurer les formulaires Tally (remplacer `VOTRE_ID_TALLY` dans les templates)

## Contact technique
Mikail Lekesiz — mikaillekesiz@gmail.com
