#!/usr/bin/env bash

# Ensure the log file exists
# touch /var/www/storage/logs/crontab.log

# Ensure permission on the command
# chmod a+x /app/bin/my-awesome-command

# Added a cronjob in a new crontab
# echo "* * * * * /usr/local/bin/php /var/www/artisan schedule:run >> /var/www/storage/logs/crontab.log 2>&1" > /etc/crontab
echo "* * * * * /usr/local/bin/php /var/www/artisan schedule:run >> /dev/null 2>&1" > /etc/crontab

# Registering the new crontab
crontab /etc/crontab

# Starting the cron
/usr/sbin/service cron start

# Displaying logs
tail -f /var/www/storage/logs/crontab.log
