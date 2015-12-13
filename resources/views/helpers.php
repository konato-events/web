<?php declare(strict_types = 1);

use Illuminate\Support\Str;

function printr(array $data):string {
    $dump = print_r($data, true);
    $dump = strtr($dump, ["Array\n" => '', "\n" => ', ', '    ' => '']);
    $dump = strtr($dump, ['(, ' => '(', ', )' => ')']);
    $dump = rtrim(trim($dump), ',');
    return $dump;
}

/**
 * Syntatic sugar to create FontAwesome i-icons to concat with strings.
 * @param string $name The icon name, as in fa-"facebook"
 * @return string
 */
function icon(string $name) {
    return " <i class='fa fa-$name'></i> ";
}

/**
 * Generates a link inside a parent element (li?). That parent will include the "active" class if the action passed is
 * the same that was called (found by the "globals" created by {@link \App\Listener\Route}).
 * @param string $title What will become the link
 * @param string $act The link action, as used by {@link act{})
 * @param array  $params Action params
 * @param string $wrapper What will wrap the link and receive the 'active' class
 * @param array $attributes Attributes for both the wrapper and the link.
 *                          Specify like `['wrap' => ['class' => 'presentation'], 'link' => ['data-block' => 'xxx']]`.
 * @return string
 * @see act()
 */
function activableLink($title, $act, array $params = [], $wrapper = 'li', array $attributes = []):string {
    $final_attrs = [];
    foreach(['wrap', 'link'] as $el) {
        $attrs = $attributes[$el] ?? [];

        //separates the class and removes it from the standard attributes array, so we can include the needed class
        $classes = $attrs['class'] ?? '';
        unset($attrs['class']);
        if ($el == 'wrap' && ($act) == app()['controller'].'@'.app()['action']) {
            $classes .= ' active';
            $title .= ' <span class="sr-only">(current)</span>';
        }
        $attrs = ['class' => $classes];

        foreach($attrs as $attr => $value) {
            $final_attrs[$el][] = "$attr='$value'";
        }
        $final_attrs[$el] = join(' ', $final_attrs[$el]);
    }

    $action = act($act, $params);
    return "<$wrapper {$final_attrs['wrap']}><a href='$action' {$final_attrs['link']}>$title</a></$wrapper>";
}

/**
 * Shorthand function for {@link action()}, removing the need to indicate "Controller" for the classname
 * and "get" for the method name. Other HTTP verbs are still required. `getIndex` is also optional.
 * This version does not generate absolute URLs as it's {@link action()} default.
 * Examples:
 * - user > UserController@getIndex
 * - user@profile > UserController@getProfile
 * - user@postEdit > UserController@postEdit
 *
 * @link https://github.com/laravel/framework/issues/10659
 * @param string $route A "route" string as explained in the examples
 * @param mixed  ...$params Path variables
 * @see action()
 * @return string
 */
function act(string $route, ...$params):string {
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

    if (sizeof($params) == 1 && is_array($params[0])) {
        $params = $params[0];
    }

    return action("{$controller}Controller@$action", $params, false);
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
    return $id.'-'.Str::slug($name, '_');
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
