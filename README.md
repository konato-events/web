Konato - Event Discovery
========================

How to handle this... thing.
----------------------------

### Installation
0. Clone the project. You've probably already done it now, or at least know how to do if you're reading this file.
0. Make sure those folders have write access by the server:
    - storage/logs
    - bootstrap/cache
0. Create an environment file for you: `cp .env.example .env`
0. Insert cool keys into it, for cool crpytography operations: `./artisan key:generate`
0. Install all dependencies (wait, you have Composer and NPM, right? You don't? [See below](#package-managers)):
    - `composer install`
    - `npm install --global gulp` (not obligatory, but will help you with some commands)
    - `npm install`

#### <a name="package-managers"></a>Package managers
Seriously? You don't have those nice Composer/NPM guys there? Ok, keep reading:

##### Composer
This will install Composer globaly, and you can call it through `composer`; no need for `.phar` or local installations, yey!

    $ curl -sS https://getcomposer.org/installer \
      | sudo php -- --filename=composer \
      --install-dir=/usr/local/bin`

##### Node/io.js + NPM
To make matters easier, you should preferably install those using the Node Version Manager. If you prefer not, go to: [io.js] or [node.js].

Down to the rabbit hole (you should check the [latest NVM release][nvm-release] to use the version number in the first command):

    $ curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.26.1/install.sh \
      | sudo NVM_DIR=/usr/local/nvm bash
    $ nvm install iojs # installs io.js. You can use `nvm ls-remote` to see other packages and versions  
    $ nvm alias default iojs # sets io.js as the default version
    $ nvm use iojs # enables io.js right away, without having to restart the shell

[io.js]: https://iojs.org
[node.js]:https://nodejs.org
[nvm-release]: https://github.com/creationix/nvm/releases/latest

### Assets management
Laravel comes pre-packed with [Elixir], an easier way to run Gulp tasks. _No, it's not the [Brazilian easier version of Erlang][elixir-erlang]._ Coincidentally enough, our CSS framework of choice ([Semantic UI]) also uses Gulp for building its assets. Thus, both were bounded together so we can have a party.

You can find more information on how to configure and enjoy Semantic UI at `resources/assets/semantic/README.md`, but for now it's good to know the following:

- You'll be mainly working with the `gulpfile.js` from the root dir. Elixir functions are baked there and Semantic UI tasks were placed there as well;
- To compile once, run `gulp` from the root dir;
- To compile for production usage, run `gulp --production`;
- To keep compiling while you develop, use `gulp watch watch-ui`.
- See [this question on SO][question] to see if the watcher can be improved.
 
[elixir]: http://laravel.com/docs/5.1/elixir
[elixir-erlang]: https://en.wikipedia.org/wiki/Elixir_(programming_language)
[semantic ui]: http://semantic-ui.com
[question]: http://stackoverflow.com/questions/32622893