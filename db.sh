#! /bin/bash
. .env
# Homestead forwards port 33060 on 127.0.0.1
#mysql --host=127.0.0.1 --port=33060 --user=$DB_USERNAME --password=$DB_PASSWORD $DB_DATABASE
# but we can also use the values defined in .env
mysql --host=$DB_HOST --port=$DB_PORT --user=$DB_USERNAME --password=$DB_PASSWORD $DB_DATABASE
