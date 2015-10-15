<?php //declare(strict_types=1); //TODO: strict types were disabled here because Laravel IDE Helper does not support it

/**
 * Returns a piece of $text containing, at maximum, $max words.
 * @param string $text
 * @param int    $max
 * @param string $ellipsis
 * @return string
 */
function partial_text($text, $max = 100, $ellipsis = '[...]') {
    if (str_word_count($text) <= $max) {
        return $text;
    } else {
        $words = explode(' ', $text);
        return join(' ', array_slice($words, 0, $max)).' '.$ellipsis;
    }
}

/**
 * Calls {@link ngettext()} and {@link sprintf()} to make translation of pluralized strings easier. You should include a "%d" in your message IDs to have the number printed out.
 * @param string $singular Singular message ID
 * @param string $plural   Plural message ID
 * @param int    $n The number defining plural rule
 * @return string
 */
function __(string $singular, string $plural, int $n):string {
    return sprintf(ngettext($singular, $plural, $n), $n);
}
