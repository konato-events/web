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
