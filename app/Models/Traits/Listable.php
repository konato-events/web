<?php namespace App\Models\Traits;

trait Listable {

    protected static $listField = 'name';

    protected static $listKey = 'id';

    /**
     * Finds all models and generates a simple array from a given $field or {@link self::$listField}.
     * Note: keys are turned into strings so they can always be preserved.
     *
     * @param string|bool $include_empty If true, includes an empty value in the beginning.
     *                                   If string, the passed value will be used as the first value,
     *                                   Both will be set with an empty string as key. Useful for select lists.
     * @param string|bool $indexed_by   By default, indexes by {@link self::$listKey}. If this param is given,
     *                                   it's used as index column.
     * @param string|null $field         Specifies the field to be used as array value. By default, uses {@link self::$listValue}.
     * @see array_column()
     * @return array
     */
    public static function toList($include_empty = false, $indexed_by = false, $field = null) {
        $list    = static::orderBy(static::$listKey)->get()->toArray();
        $columns = array_column($list, $field?: static::$listField, $indexed_by? null : static::$listKey);

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
        $list = static::toList($include_empty, $indexed_by, $field);
        return array_map('_', array_map('ucfirst', $list));
    }
}
