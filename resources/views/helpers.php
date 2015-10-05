<?php declare(strict_types=1);

/**
 * Returns a piece of $text containing, at maximum, $max words.
 * @param string $text
 * @param int    $max
 * @param string $ellipsis
 * @return string
 */
function partial_text(string $text, int $max = 100, string $ellipsis = '[...]'):string {
    if (str_word_count($text) <= $max) {
        return $text;
    } else {
        $words = explode(' ', $text);
        return join(' ', array_slice($words, 0, $max)).' '.$ellipsis;
    }
}
