# styx
composer install  
npm install  
touch database/database.sqlite  
cp .env.example .env  
modifier dans le .env la ligne DB_DATABASE  
et mettre le chemin absolu vers database/database.sqlite
(par exemple :/Users/2pac/Desktop/styx/database/database.sqlite)
php artisan migrate:refresh --seed  
pour dev : npm run dev  
pour prod : npm run build  


dans le php.ini changer et mettre les valeurs suivantes  
à la fin du fichier  
upload_max_filesize = 130M  
post_max_size = 100M  
max_file_uploads = 20  

la commande php --ini donne le chemin vers votre php.ini  
php --ini  :

Configuration File (php.ini) Path: /yourpathtoini  
Loaded Configuration File:         /yourpathtoini/php.ini  
Scan for additional .ini files in: (none)  
Additional .ini files parsed:      (none)

modifier le php.ini du Loaded Configuration File
