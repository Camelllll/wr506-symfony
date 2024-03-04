
# WR506 - Site API Camélien Tournu ✈️

### Prérequis

- [Php 8.1](https://www.php.net/downloads)
- [Composer](https://getcomposer.org/download/)
- [Symfony CLI](https://symfony.com/download)
- OpenSSL (pour générer les clés JWT)
- Projet Frontend [WR505](https://github.com/maximilienlemoine/WR505-MovieApp) (optionnel)

### Installation

1. Cloner le projet

2. Installer les dépendances
    ```bash
    composer install
    ```
3. Créer le fichier .env.local et renseigner les variables d'environnement
    ```bash
    cp .env .env.local
    ```
4. Renseigner les variables suivantes :
    ```dotenv
    DATABASE_URL #(url de la base de données)
    APP_URL #(adresse du back)
    FRONT_URL #(adresse du front)
    ```
5. Créer la base de données
    ```bash
    php bin/console d:d:c
    php bin/console d:m:m
    ```
6. Créer les fixtures
    ```bash
    php bin/console d:f:l
    ```
7. Générer les clés JWT
    ```bash
    php bin/console lexik:jwt:generate-keypair
    ```
8. Lancer le serveur
    ```bash
    symfony server:start
    ```

Les identifiants par défaut pour se connecter à l'API sont les suivants :
```
Admin:
    email: user@gmail.com
    password: test
```

Amusez-vous bien !
