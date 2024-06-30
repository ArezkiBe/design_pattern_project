# Payment Library

## Configuration

Avant de commencer, assurez-vous d'avoir configuré le fichier `config.php` avec les informations nécessaires pour vos moyens de paiement (comme Stripe, Paypal, etc.).

```bash
cp config.copie.php config.php
```

Modifiez `config.php` pour ajouter vos clés d'API et autres configurations spécifiques.

## Installation

Pour installer les dépendances nécessaires, utilisez Composer. Si vous n'avez pas encore Composer installé, suivez les instructions sur [getcomposer.org](https://getcomposer.org/).

```bash
composer install
```

## Exécution du CLI Payment Processor

Pour utiliser le CLI Payment Processor et effectuer des tests interactifs :

```bash
php cli_payment_processor.php
```

Suivez les instructions à l'écran pour choisir un moyen de paiement, entrer le montant, la devise et la description du paiement, puis confirmer ou annuler le paiement lorsque cela vous est demandé.

## Exécution des tests

Pour exécuter les tests unitaires avec PHPUnit :

```bash
vendor/bin/phpunit
```

Assurez-vous que tous les tests passent avec succès avant de déployer ou d'intégrer les modifications dans un environnement de production.

```

Ce fichier `README.md` fournit des instructions claires et concises sur la configuration initiale, l'installation des dépendances, l'utilisation du CLI pour tester les paiements, et l'exécution des tests unitaires. Assurez-vous de personnaliser les sections selon les détails spécifiques de votre projet et d'inclure toutes les informations pertinentes pour les utilisateurs ou les développeurs qui pourraient utiliser votre bibliothèque de paiement.
