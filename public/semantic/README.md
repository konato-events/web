Semantic UI usage
=================

Installation
------------
Head over to the [Getting started](http://semantic-ui.com/introduction/getting-started.html) page.
However, you probably don't need it - the framework is already installed. It might be useful though if we want to change installed components.

This is how installation was done at the first time (and if you're redoing it you'll want to keep most settings):

    $ npm install semantic-ui --save
        Is this your project folder? /home/igorsantos/dev/konato/web  [Yes]
        Where should we put Semantic UI inside your project?          [public/css/semantic/]
        What components should we include in the package?             [all]
        Should we set permissions on outputted files?                 [No]
        Do you use a RTL (Right-To-Left) language?                    [No]
        Where should we put your site folder?                         [src/site/]
        Where should we output a packaged version?                    [dist/]
        Where should we output compressed components?                 [dist/components/]
        Where should we output uncompressed components?               [dist/components/]
        [...]
    $ cd public/css/semantic/
    $ ../../../node_modules/.bin/gulp build

Updating
--------
Simply run `npm update`. You might need to rebuild files using Gulp. Not sure.
