# MessUp
Application communautaire pour échanger des messages sur des salons publics.
Composée d'une base de données avec une table utilisateur & message.

## API
Endpoints:
- POST /api/messages/enregistrer.php pour enregistrer les messages
- GET /api/messages/recuperer.php pour afficher les messages

Nécessite une authentification.

- POST /api/auth/index.php pour s'authentifier, créer l'utilisateur ou vérifier le token
- PUT /api/auth/index.php pour rafraichir le token

## PAGES

- index.php : page d'accueil et de chats
- auth.php : page de connexion/enregistrement

Necessite une authentification.

URL : messup.alwaysdata.net