# My personal notes to set up, understand, use, extend Ushahidi

## Setup Backend

`vagrant up` (using Homestead) works fine as described [here](./setup_alternatives/vagrant-setup.md).

I only needed to [update some parts](https://github.com/ushahidi/platform/pull/4393) in order to [work with the current mysql](https://github.com/ushahidi/platform/issues/4392).

Ensure that php7.3 is used also locally (on your dev machine) to make git's pre-commit / pre-push hooks work.
I simply changed the php name to `php7.3` and installed it also locally using `sudo add-apt-repository ppa:ondrej/php`
(see HowTo e.g. on [DigitalOcean][php1] or [Techmint][php2]);
the Homestead container already provides several php versions.

## Setup Frontend

`npm i` worked [only with node v10.x for me](https://github.com/ushahidi/platform/issues/4390). I really recommend using `nvm`.

`serve` script (`package.json`) worked fine for me.

[php1]: https://www.digitalocean.com/community/tutorials/how-to-run-multiple-php-versions-on-one-server-using-apache-and-php-fpm-on-ubuntu-18-04
[php2]: https://www.tecmint.com/install-different-php-versions-in-ubuntu/

### or via docker

```bash
date=$(date +%Y-%m-%d--%H-%M)
docker build -t ushahidi-client:$date .
docker run  --env BACKEND_URL=...:8880 -d -p 8888:8080 ushahidi-client:$date
```


## Server Access

- Login to container: `vagrant ssh`
- Go to project directory: `cd ~/Code/platform-api`

## Database

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


## Docs I found helpful of tools & frameworks used by Ushahidi

### Backend

* PHP
  * [composer](https://getcomposer.org/) -> is the `npm` of PHP and quite straightforward to use
  * [Laravel 5.5](https://laravel.com/docs/5.5/structure) and there especially:
    * [Laravel Homestead](https://laravel.com/docs/5.5/homestead) -> used for vagrant / VirtualBox based dev server
    * [Laravel Routing](https://laravel.com/docs/5.5/routing) -> `v5/routes/web.php` (v5 API) and `routes/web.php` (v3 API)
    * [Laravel Database](https://laravel.com/docs/5.5/database) (I actually did not need to change / adjust something here) and [Database Queries](https://laravel.com/docs/5.5/queries)
    * [Laravel Eloquent](https://laravel.com/docs/5.5/eloquent) -> Used to define data models that also encapsulate the DB; this was quite helpful for me to understand the framework!
    * [Laravel Authentication](https://laravel.com/docs/5.5/authentication#retrieving-the-authenticated-user) -> e.g. get authenticated user
  * [Phinx 0.8.1](https://netlor-phinx.readthedocs.io/en/v0.8.1/intro.html) -> used to setup and update database
    * and there especially [how to write new migrations](https://netlor-phinx.readthedocs.io/en/v0.8.1/migrations.html#creating-a-new-migration)
      to add a new or alter an existing table. Really nice tool!
