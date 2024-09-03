<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormulaDescription;

class FormulaDescriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Données des descriptions à insérer avec IDs explicites
        $descriptions = [
            // Essentiel
            ['id' => 1, 'description_text' => "Un site vitrine conçu pour présenter votre activité ou vos services de manière simple et élégante. Idéal pour ceux qui souhaitent une présence en ligne sans fonctionnalités complexes."],
            ['id' => 2, 'description_text' => "Trois pages clés pour structurer l'information de manière concise, comme une page d'accueil, une page de services et une page de contact."],
            ['id' => 3, 'description_text' => "Un formulaire de contact fonctionnel et sécurisé pour permettre aux visiteurs de vous joindre facilement."],
            ['id' => 4, 'description_text' => "Optimisation basique pour les moteurs de recherche, afin de garantir que votre site soit bien indexé et visible sur Google."],
            ['id' => 5, 'description_text' => "Une révision gratuite pour ajuster le contenu ou la mise en page après la livraison du site, selon vos retours."],
            ['id' => 6, 'description_text' => "Assistance technique par email pour répondre à vos questions et résoudre d'éventuels problèmes."],
            // Premium
            ['id' => 7, 'description_text' => "Un site web conçu pour les entreprises cherchant une présence en ligne sophistiquée avec des fonctionnalités avancées. Parfait pour les projets de taille moyenne qui nécessitent une présentation professionnelle et un impact notable."],
            ['id' => 8, 'description_text' => "Cinq pages essentielles couvrant tous les aspects de votre activité, incluant une page d'accueil, une page de services, une page de contact, une page d'équipe ou d'entreprise, et une page de témoignages ou d'études de cas."],
            ['id' => 9, 'description_text' => "Un formulaire de contact avancé avec des champs personnalisés et une intégration de réponse automatique pour améliorer l'expérience utilisateur et faciliter les interactions commerciales."],
            ['id' => 10, 'description_text' => "Optimisation approfondie pour les moteurs de recherche, incluant des recherches de mots-clés stratégiques, des optimisations techniques, et des analyses concurrentielles pour maximiser la visibilité de votre site sur Google."],
            ['id' => 11, 'description_text' => "Deux révisions incluses pour ajuster le contenu, la mise en page, ou d'autres aspects du site selon vos besoins et retours, garantissant que le résultat final soit à la hauteur de vos attentes."],
            ['id' => 12, 'description_text' => "Assistance technique via email et téléphone, permettant une communication rapide pour résoudre tout problème ou répondre à vos questions en temps réel."],
            ['id' => 13, 'description_text' => "Un accès administrateur complet pour que vous puissiez gérer, ajouter, modifier ou supprimer vos contenus en toute autonomie."],
            ['id' => 14, 'description_text' => "Intégration API basique pour connecter votre site à d'autres services ou applications, offrant des fonctionnalités supplémentaires et des automatisations."],
            // Expert
            ['id' => 15, 'description_text' => "Un site web professionnel, robuste et évolutif, conçu pour les entreprises nécessitant une présence en ligne puissante et flexible, avec des capacités de personnalisation avancées et un développement sur mesure."],
            ['id' => 16, 'description_text' => "Huit pages complètes pour une couverture détaillée de votre entreprise, incluant des pages d'accueil, de services, de contact, de blog, de témoignages, de portfolio, d'équipe, et de FAQ, offrant une présentation exhaustive de vos offres et compétences."],
            ['id' => 17, 'description_text' => "Formulaire de contact avancé et sécurisé avec options de personnalisation, intégration de CRM et fonctionnalités de suivi, permettant une gestion efficace des leads et des demandes clients."],
            ['id' => 18, 'description_text' => "Optimisation SEO complète incluant des recherches avancées de mots-clés, des stratégies de contenu, des backlinks de qualité, et un suivi de performance SEO pour garantir une visibilité maximale et un classement élevé dans les résultats de recherche."],
            ['id' => 19, 'description_text' => "Révisions illimitées pour s'assurer que chaque détail du site correspond parfaitement à vos attentes et aux besoins de votre entreprise, offrant un ajustement continu pendant le processus de développement."],
            ['id' => 20, 'description_text' => "Support technique multicanal disponible par email, téléphone, et chat en direct, assurant une assistance immédiate et complète pour tous vos besoins techniques et stratégiques."],
            ['id' => 21, 'description_text' => "Portail client dédié permettant à vos clients de gérer leurs devis, factures, paiements, et documents en ligne, simplifiant la gestion et améliorant l'expérience client."],
            ['id' => 22, 'description_text' => "Intégration API avancée avec des fonctionnalités personnalisées, permettant des connexions robustes avec des applications tierces, des plateformes de gestion, ou des outils spécifiques à votre activité pour une automatisation et une interopérabilité optimales."],
            // Options
            ['id' => 23, 'description_text' => "Ajout de pages supplémentaires pour étendre votre site"],
            ['id' => 24, 'description_text' => "Référencement Local pour améliorer votre visibilité dans les résultats de recherche géolocalisés."],
            ['id' => 25, 'description_text' => "Google My Business pour gérer la présence de votre entreprise sur Google."],
            ['id' => 26, 'description_text' => "Suivi Analytics pour analyser les performances de votre site."],
            ['id' => 27, 'description_text' => "Révision des contenus tous les 6 mois pour garantir leur pertinence."],
        ];

        // Insertion des descriptions dans la table avec IDs explicites
        foreach ($descriptions as $description) {
            FormulaDescription::updateOrCreate(
                ['id' => $description['id']], // Critère pour éviter les doublons
                $description
            );
        }
    }
}
