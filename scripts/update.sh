#! /usr/bin/bash
#the first argument is the path to the backup folder
#the second argument is the username with wich to login to the database
#the third argument is the password with wich to login to the database
#the fourth argument is the name of the database to backup
cd /var/www/laraVroem
php artisan down
# make backup
git pull
php artisan migrate --force
php artisan up
NAME="update on "
DATE=$(date +"%Y-%m-%d %T")
PATH=$1
EXTENTION=.sql
FILENAME="$PATH$NAME$DATE$EXTENTION"
echo "saved database backup to: $FILENAME"
/usr/bin/mysqldump -u "$2" -p"$3" --databases "$4" > "$FILENAME"
