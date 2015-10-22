<?php declare(strict_types = 1);

use Illuminate\Support\Str;

/**
 * Shorthand function for {@link action()}, removing the need to indicate "Controller" for the classname
 * and "get" for the method name. Other HTTP verbs are still required. `getIndex` is also optional.
 * This version also uses urlencode() in parameters.
 * Examples:
 * - user > UserController@getIndex
 * - user@profile > UserController@getProfile
 * - user@postEdit > UserController@postEdit
 *
 * @link https://github.com/laravel/framework/issues/10659
 * @param string $route A "route" string as explained in the examples
 * @param mixed  ...$vars Path variables
 * @see action()
 * @return string
 */
function act(string $route, ...$vars):string {
    $parts      = explode('@', $route);
    $controller = ucfirst($parts[0]);
    $action     = $parts[1] ?? 'getIndex';

    $has_verb = false;
    foreach(['get', 'post', 'put', 'delete'] as $verb) {
        if (strpos($action, $verb) === 0) {
            $has_verb = true;
            break;
        }
    }
    if (!$has_verb) {
        $action = 'get'.ucfirst($action);
    }

    array_walk_recursive($vars, function(&$value) { $value = urlencode($value); });

    return action("{$controller}Controller@$action", ...$vars);
}

/**
 * Temporary (?) helper to create our search URL with query parameters.
 * @link https://github.com/laravel/framework/issues/10659
 * @param array $params
 * @return string
 */
function search_url(array $params = []):string {
    return act('event@search').'?'.http_build_query($params);
}

function nbsp(string $str):string {
    return strtr($str, [' ' => '&nbsp;']);
}

/**
 * Creates an URL slug, composed from an ID and name
 * @param int    $id
 * @param string $name
 * @return string
 */
function slugify(int $id, string $name):string {
    return $id.'-'.Str::slug($name);
}

/**
 * Breaks back a slug made of id and a name into an indexed array.
 * @param string $id_slug
 * @return mixed
 */
function unslug(string $id_slug):array {
    $id    = strtok($id_slug, '-');
    $title = strtok('');
    return [$id, $title];
}

/**
 * Calls {@link ngettext()} and {@link sprintf()} to make translation of pluralized strings easier.
 * You should include a "%d" in your message IDs to have the number printed out.
 * If you need to use additional parameters for {@link sprintf()}, use {@link __s()}.
 * @param string $singular Singular message ID
 * @param string $plural   Plural message ID
 * @param int    $n        The number defining plural rule
 * @see __s()
 * @see ngettext()
 * @see sprintf()
 * @return string
 */
function __(string $singular, string $plural, int $n):string {
    return sprintf(ngettext($singular, $plural, $n), $n);
}

/**
 * Calls in {@link __()} with a variable number of arguments for {@link sprintf()}.
 * In this implementation, you'll have to reference your $n again as a replace value,
 * since we can't guess where your number will be in the placeholder string.
 * Note: r comes from replace ;)
 * @param string $singular  Singular message ID
 * @param string $plural    Plural message ID
 * @param int    $n         The number defining plural rule
 * @param mixed  ...$values Additional values to be replaced, as per {@link sprintf()}
 * @see ngettext()
 * @see sprintf()
 * @see _s()
 * @see __()
 * @return string
 */
function __r(string $singular, string $plural, int $n, ...$values) {
    return sprintf(ngettext($singular, $plural, $n), ...$values);
}

/**
 * Shorthand function for calling {@link _()} inside {@link sprintf()}.
 * Note: r comes from replace ;)
 * @param string $msg_key   Message ID for translation
 * @param mixed  ...$values Values to be replaced by sprintf()
 * @see _()
 * @see __s()
 * @see gettext()
 * @see sprintf()
 * @return string
 */
function _r(string $msg_key, ...$values) {
    return sprintf(_($msg_key), ...$values);
}
