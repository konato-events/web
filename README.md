Konato - Event Discovery
========================

[![Next issues](https://badge.waffle.io/konato-events/web.svg?label=ready&title=Next%20issues)](http://waffle.io/konato-events/web)
[![Working on](https://badge.waffle.io/konato-events/web.svg?label=in%20progress&title=Working%20on)](http://waffle.io/konato-events/web)

[![Activity Graph](https://graphs.waffle.io/konato-events/web/throughput.svg)](https://waffle.io/konato-events/web/metrics)


How to handle this... thing.
----------------------------

### Installation
0. Clone the project. You've probably already done it now, or at least know how to do if you're reading this file.
0. Spin up the docker containers: `docker-compose up -d`
0. Make sure those folders have write access by the server:
    - bootstrap/cache
0. Create an environment file for you: `cp .env.example .env`
0. Insert cool keys into it, for cool cryptographic operations: `docker-compose exec php ./artisan key:generate`
0. Install all dependencies (If you don't have NPM, see the next section):
    - `docker-compose exec php composer install`
    - `npm install --global gulp` (not mandatory, but will help you with some commands)
    - `npm install`

#### Package managers
Seriously? You don't have those nice Composer/NPM guys there? Ok, keep reading:

##### Composer
This guy is now bundled onto the Docker image so we are good to go.

##### Node + NPM
As NPM is quite a heavy guy and you, as a developer, probably already have that somewhere in your machine. So you can just keep using your local version - instead of stuffing our cool Alpine image with Node.  
To make matters easier, you should preferably use the Node Version Manager (if you prefer not, go to [node.js] and do whatever is suggested there):

> _First, you should check the [latest NVM release][nvm-release] to use the version number in the first command._

    $ curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.26.1/install.sh \
      | sudo NVM_DIR=/usr/local/nvm bash
    $ nvm install lts-boron # Installs the latest stable LTS release. You can use `nvm ls-remote` to see specific versions
    $ nvm use node # enables io.js right away, without having to restart the shell

[node.js]:https://nodejs.org
[nvm-release]: https://github.com/creationix/nvm/releases/latest

### Assets management
Laravel comes pre-packed with [Elixir], an easier way to run Gulp tasks. _No, it's not the [Brazilian, easier version of Erlang][elixir-erlang]._

- You'll be mainly working with the `gulpfile.js` from the root dir. Elixir functions are baked there;
- To compile once, run `gulp` from the root dir;
- To compile for production usage, run `gulp --production`;
- To keep compiling while you develop, use `gulp watch`.

### Database
We use PostgreSQL here - as it's prepackaged in Heroku and has cool geolocation features if we need them later. The PostgreSQL docker image will get you a database and user, and then you need to create the rest of the db: `docker-compose exec php ./artisan migrate`.

To access the PostgreSQL database, use `psql -h 127.0.0.1 -WU konato konato` from your machine or inside the `db` container (remember, Alpine-based images run on `sh`, not `bash`).

Deploying to production
-----------------------
We needed to make some tweaks to the original project to have it running smoothly inside Heroku.

### Environment variables
Laravel uses `.env` to manage environment variables. Sadly, it seems there's no easy way to have a production `.env` file, since we don't have access to the production machines and what's deployed is exactly the same codebase. However, Heroku provides a way to configure env vars as well. And they override Laravel ones. Great! The command is `heroku config:set VAR=value`. This can be used to alter other variables, and I guess this can be changed in the Heroku Dashboard as well.

Current list of custom variables we had to setup to have the application working:

- APP_ENV=prod
- APP_DEBUG=false
- APP_KEY=secretDuh
- FACEBOOK_ID=secretDuh
- FACEBOOK_SECRET=secretDuh

### Logging
Inside Heroku, logs must be sent to `stdout`/`stderr`. In Laravel 5, this is done by configuring logs to go to _errorlog_.  
PaperTrail is a Heroku addon that enables us to see the log stream, live - it can be accessed from the Heroku Dashboard as well.

>_Logging to `stdout` also enables us to read logs through `docker-compose logs`._

### Additional deployment procedures
To make matters easier, there's a helper script in the root folder called `deploy`. It's scheduled to run in Composer every time a new `composer install` command is issued -- but rest assured, it won't complicate your development life: it verifies the environment before compressing and caching files ;)

[elixir]: http://laravel.com/docs/5.1/elixir
[elixir-erlang]: https://en.wikipedia.org/wiki/Elixir_(programming_language)
[semantic ui]: http://semantic-ui.com
[question]: http://stackoverflow.com/questions/32622893
