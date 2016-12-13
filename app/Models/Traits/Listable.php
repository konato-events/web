<?php namespace App\Models\Traits;

/**
 * Adds two methods to generate clean lists of model items, indexing a field by another one.
 *
 * By default, indexes "names"  by "ids"; this can be changed by creating a static property called "$listableConfig".
 * It should contain an array with keys "field" and "key", indicating what goes as value and what goes as key in the
 * resulting array.
 */
trait Listable {

    private static $defaults = ['field' => 'name', 'key' => 'id'];

    /**
     * Finds all models and generates a simple array from a given $field or self::$listableConfig['field'].
     * Note: keys are turned into strings so they can always be preserved.
     * Values can be ordered by another field instead of key by using self::$listableConfig['order'].
     *
     * @param string|bool $include_empty If true, includes an empty value in the beginning.
     *                                   If string, the passed value will be used as the first value,
     *                                   Both will be set with an empty string as key. Useful for select lists.
     * @param bool        $indexed_by    By default, indexes by "id". If this param is given, it's used as index column.
     *                                   Can be setup globally creating a static prop $listableConfig with a key "key".
     * @param string|null $field         Specifies the field to be used as array value. By default, uses "name".
     *                                   Can be setup globally creating a static prop $listableConfig with a key "field".
     * @see array_column()
     * @return array
     */
    public static function toList($include_empty = false, $indexed_by = false, $field = null) {
        if (isset(static::$listableConfig)) {
            static::$defaults = array_merge(static::$defaults, static::$listableConfig);
        }
        $list    = static::orderBy(static::$defaults['order'] ?? static::$defaults['key'])->get()->toArray();
        $columns = array_column($list, $field?: static::$defaults['field'], $indexed_by? null : static::$defaults['key']);

        if ($include_empty) {
            $empty = is_bool($include_empty)? ' ' : $include_empty;
            return ['' => $empty] + $columns;
        } else {
            return $columns;
        }
    }

    /**
     * Same as {@link toList()}, but pass column values through ucfirst() and then, gettext().
     * @param bool|false $include_empty
     * @param bool|false $indexed_by
     * @param null       $field
     * @return array
     */
    public static function toTransList($include_empty = false, $indexed_by = false, $field = null) {
        $list  = static::toList($include_empty, $indexed_by, $field);
        $trans = array_map('_', array_map('ucfirst', $list));

        if (isset(static::$defaults['order']) && static::$defaults['order'] == ($field ?? static::$defaults['field'])) {
            if ($include_empty) {
                $empty = $trans[''];
                unset($trans['']);
            }

            asort($trans);

            if ($include_empty) {
                $trans = ['' => $empty] + $trans;
            }
        }

        return $trans;
    }
}
