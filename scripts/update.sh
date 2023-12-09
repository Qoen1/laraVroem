#! /usr/bin/bash
#the first argument is the path to the backup folder
#the second argument is the username with wich to login to the database
#the third argument is the password with wich to login to the database
#the fourth argument is the name of the database to backup

# go to project root
cd ..

# disable site
php artisan down

# backup database
NAME="update on "
DATE=$(date +"%Y-%m-%d %T")
PATH=$1
EXTENTION=.sql
FILENAME="$PATH$NAME$DATE$EXTENTION"
echo "saved database backup to: $FILENAME"
/usr/bin/mysqldump -u "$2" -p"$3" --databases "$4" > "$FILENAME"

#pull latest version from git
git pull

# update database
php artisan migrate --force

# update composer
composer update

# update npm
npm install
npm run build

# clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize

# enable website
php artisan up
