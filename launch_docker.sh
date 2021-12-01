#!/bin/bash

# arrêt du container si il tourne déjà en arrière plan
docker stop sti_project
# suppression du container
docker rm sti_project
# téléchargement de l'image et lancement du container
docker run -ti -v "$PWD/site":/usr/share/nginx/ -d -p 8080:80 --name sti_project --hostname sti arubinst/sti:project2018
# exécution du service php
docker exec -u root sti_project service php5-fpm start
# exécution du service nginx
docker exec -u root sti_project service nginx start
# changement du propriétaire de la base de données
docker exec -u root sti_project chown -R www-data:www-data /usr/share/nginx/databases
