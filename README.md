<p align="center"><img src="public/image/pp.png" width="400" alt="Laravel Logo"></p>

## À propos

Cette application web de gestion de tâches permet aux utilisateurs de recevoir des tâches assignées avec différents niveaux de priorité. Elle offre également un suivi de l'avancement de chaque tâche, facilitant ainsi l'organisation et la gestion efficace des tâches au sein d'une équipe.

## Fonctionnalités

### Admin

- Se connecter
- Créer des tâches
- Modifier des tâches
- Supprimer des tâches
- Créer un compte utilisateur
- Changer la priorité d'une tâche : Sur la page des tâches, cliquez sur le bouton de priorité d'une tâche pour pouvoir la modifier.
- Promouvoir un utilisateur (d'un compte simple à un compte admin)
- Changer le statut d'une tâche qui lui est assignée : Le statut d'une tâche ne peut être modifié que par l'utilisateur à qui cette tâche a été assignée, sur sa page profil.
- Modifier les informations de son compte
- Se déconnecter

### Utilisateur

- Se connecter
- Changer le statut d'une tâche qui lui est assignée
- Modifier les informations de son compte
- Se déconnecter

## Mise en place

Commandes à taper après le `git clone` :

1. Clonez le dépôt :
    ```sh
    git clone <url-du-repo>
    cd <nom-du-repo>
    ```

2. Installez les dépendances du projet :
    ```sh
    composer install
    ```

3. Créez un fichier `.env` en copiant le fichier `.env.example` :
    ```sh
    cp .env.example .env
    ```

4. Générez la clé d'application :
    ```sh
    php artisan key:generate
    ```

5. Configurez vos informations de base de données et de l'envoi de mail dans le fichier `.env` :
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=task_manager_app_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    ```dotenv
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=thibauttest70@gmail.com
    MAIL_PASSWORD=hxfywalgifwelyfw
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=thibauttest70@gmail.com
    MAIL_FROM_NAME="MyTask"
    ```

6. Exécutez les migrations de base de données :
    ```sh
    php artisan migrate
    ```

7. Exécutez le seeder pour créer un admin de test :
    ```sh
    php artisan db:seed --class=AdminUserSeeder
    ```
    - Email : admin@gmail.com
    - Mot de passe : admin

8. Lancez le serveur de développement :
    ```sh
    php artisan serve
    ```

9. Exécutez le seeder pour créer des utilisateurs de test :
    ```sh
    php artisan db:seed --class=UserSeeder
    ```

10. Exécutez le seeder pour créer des tâches de test (assurez-vous d'avoir créé des utilisateurs avant) :
    ```sh
    php artisan db:seed --class=TacheSeeder
    ```
