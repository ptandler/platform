# My personal notes to setup, understand, use, extend Ushahidi

# setup

Backend: `vagrant up` / Homestead works fine as described

Ensure that php7.3 is used also locally to make git's pre-commit / pre-push hooks work
I simply changed the php name to `php7.3` and installed it also locally using `sudo add-apt-repository ppa:ondrej/php`
(see HowTo e.g. on [DigitalOcean][php1] or [Techmint][php2]);
the Homestead container already provides several php versions.

Frontend: `serve` script (`package.json`) works also fine


[php1]: https://www.digitalocean.com/community/tutorials/how-to-run-multiple-php-versions-on-one-server-using-apache-and-php-fpm-on-ubuntu-18-04
[php2]: https://www.tecmint.com/install-different-php-versions-in-ubuntu/


## Database

Login to container: `vagrant ssh`

Ushahidi uses [Phinx migrations](https://netlor-phinx.readthedocs.io/en/latest/migrations.html) to manage the DB.

Apply new migrations: `composer migrate` === `./bin/phinx migrate` (see `composer.json`; I believe that the ` -c phinx.php` that is added there is not necessary as this is the default file the phinx reads...?)

Rollback to a previous timestamp: `./bin/phinx rollback -t 20211215110945` (look at the migration script names to get the timestamp)


### Connect to MySQL

Use the `db.sh` script to connect, Homestead forwards port 33060 on 127.0.0.1

```bash
#! /bin/bash
source .env
mysql --host=$DB_HOST --port=$DB_PORT --user=$DB_USERNAME --password=$DB_PASSWORD $DB_DATABASE
```
