i18n & l10n
===========

**[GNU Gettext]** is a standard for internationalization (i18n) of code projects. There's a `.po` file that contains all our translation strings, and it should be compiled into a `.mo` binary. The project is configured with gettext to read from the files stored in this folder. To use a translated string in a page, use the (standard) [`_()` function][_func].

For more details on how GNU Gettext works, take a look at this great [LingoHub tutorial] (no, currently we don't use `.pot` files - we prefer to keep a clean environment *(a-ha)*). 


How to use the translation files
--------------------------------

We use [Poedit] to work with the `.po` file. You can find it in Ubuntu's repositories or download an installable for Mac/Windows or a tarball from their site.

0. Run Poedit and open the `.po` file for your desired language. Our files are stored in `/web/resources/locales/<<language>>/LC_MESSAGES`.
0. You can select any translation to change it. Saving the file will recompile it.
0. Whenever you change your source files, you should open the translation again and hit Refresh. It will review the source codes and update strings accordingly - changing strings and marking as fuzzy, removing old or adding new ones as needed.
0. Issues will appear on the top of the list (unless `View > Not translated entries first` is unchecked. Check it!):
    - Fuzzy translations are golden-coloured. They should be verified, fixed if needed, and then marked as fine.
    - Some strings may contain errors - red ones. Fix them. Those are discovered when you ask Poedit to Validate your file, or when you try to save it.
    - If there's something without a translation, do it!


How to add a new locale
-----------------------


How is Gettext being configured
-------------------------------

There are two methods in `app/Providers/AppServiceProvider.php` that does the hard job. One discovers the user's language (`defineLocale`), and the second actually configures locale settings.

[GNU Gettext]: http://br2.php.net/manual/en/intro.gettext.php
[LingoHub tutorial]: https://lingohub.com/blogs/2013/07/php-internationalization-with-gettext-tutorial/
[_func]: http://br2.php.net/manual/en/function.gettext.php
[Poedit]: https://poedit.net/