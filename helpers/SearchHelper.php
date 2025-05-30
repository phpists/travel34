<?php

class SearchHelper
{
    private static $search_min_word = 2;

    private static $search_max_word = 30;

    /**
     * Clean up text
     * @param string $text
     * @return string
     */
    public static function cleanText($text)
    {
        $text = str_replace('><', '> <', $text); //space between tags
        $text = preg_replace('{<br ?/?>}', ' ', $text); //replace <br> with space
        $text = preg_replace('{<time([^>]*)>([^<]+)</time>}', '', $text); // remove time
        $text = strip_tags($text); // remove other html
        $text = trim(str_replace(["\n", "\r", "\t"], ' ', $text)); // remove eols
        $text = preg_replace('/&([a-z0-9]+|#[0-9]+);/i', ' ', $text); // remove entities
        $text = preg_replace('/( )\1+/', '$1', $text); // remove repeating spaces
        $text = str_replace([' .', ' ,', ' ?', ' !'], ['.', ',', '?', '!'], $text); // remove space before punctuation signs
        return "{$text}";
    }

    /**
     * "Cleans up" a text string and returns an array of unique words
     * @param string $text
     * @return array
     */
    public static function splitWords($text)
    {
        if (empty($text)) {
            return [];
        }

        $text = mb_strtolower($text);

        // Remove any apostrophes or dashes which aren't part of words
        $text = substr(preg_replace('%((?<=[^\p{L}\p{N}])[\'\-]|[\'\-](?=[^\p{L}\p{N}]))%u', '', ' ' . $text . ' '), 1, -1);

        // Remove punctuation and symbols (actually anything that isn't a letter or number), allow apostrophes and dashes (and % * if we aren't indexing)
        $text = preg_replace('%(?![\'\-\%\*])[^\p{L}\p{N}]+%u', ' ', $text);

        // Replace multiple whitespace or dashes
        $text = preg_replace('%(\s){2,}%u', '\1', $text);

        // Fill an array with all the words
        $words = array_unique(explode(' ', $text));

        // Remove any words that should not be indexed
        foreach ($words as $key => $value) {
            // If the word shouldn't be indexed, remove it
            if (!self::validateSearchWord($value)) {
                unset($words[$key]);
            }
        }

        return $words;
    }

    /**
     * @param array $words
     * @return array
     */
    public static function getWordsBases($words)
    {
        $stemmer = new Stemmer;
        foreach ($words as $k => $word) {
            $word = $stemmer->getWordBase($word);
            if (mb_strlen($word) >= self::$search_min_word) {
                $words[$k] = $word;
            } else {
                unset($words[$k]);
            }
        }

        return $words;
    }

    /**
     * @param string $text
     * @param array|string $words
     * @param int $length
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public static function excerpt($text, $words, $length = 250, $prefix = '...', $suffix = '...')
    {
        $text_length = mb_strlen($text);

        if ($text_length <= $length) {
            return $text;
        }

        if (!is_array($words)) {
            $words = (array)$words;
        }

        if (empty($words)) {
            return self::cropText($text, $length, $suffix);
        }

        $min_pos = $text_length - $length;
        $low_text = mb_strtolower($text);
        $word_found = false;

        foreach ($words as $word) {
            $word = mb_strtolower($word);
            $pos = mb_strpos($low_text, $word);
            if ($pos > 0) {
                if ($pos < $min_pos) {
                    $min_pos = $pos;
                }
                $word_found = true;
            }
        }

        if (!$word_found || $min_pos < 30) {
            return self::cropText($text, $length, $suffix);
        }

        $excerpt = '';
        $begin_count = 0;
        $use_suffix = true;
        $text_array = explode(' ', $text);
        $total = count($text_array);
        $count = 1;
        foreach ($text_array as $text_word) {
            if (empty($text_word)) {
                continue;
            }
            $begin_count += mb_strlen($text_word) + 1;
            // начинаем собирать слова с мин. положения
            if ($begin_count > $min_pos - 30) {
                $excerpt .= $text_word . ' ';
            }
            if ($count >= $total) {
                $use_suffix = false;
            }
            if (mb_strlen($excerpt) > $length) {
                break;
            }
            $count++;
        }

        $excerpt = $prefix . trim($excerpt) . ($use_suffix ? $suffix : '');

        return $excerpt;
    }

    /**
     * @param string $text
     * @param array $words
     * @param string $pattern
     * @return string
     */
    public static function highlight($text, $words, $pattern = '<mark>$1</mark>')
    {
        foreach ($words as $word) {
            $text = preg_replace('{([\p{L}\p{N}]*' . $word . '[\p{L}\p{N}]*)}iu', $pattern, $text);
        }
        return $text;
    }

    /**
     * @param string $text
     * @param array $words
     * @param int $length
     * @param string $prefix
     * @param string $suffix
     * @param string $pattern
     * @return string
     */
    public static function highlightExcerpt($text, $words, $length = 250, $prefix = '...', $suffix = '...', $pattern = '<mark>$1</mark>')
    {
        $text = self::excerpt($text, $words, $length, $prefix, $suffix);
        return self::highlight($text, $words, $pattern);
    }

    /**
     * @param string $text
     * @param int $length
     * @param string $suffix
     * @return string
     */
    public static function cropText($text, $length = 250, $suffix = '...')
    {
        if (mb_strlen($text) < $length) {
            return $text;
        }
        $excerpt = '';
        $text_array = explode(' ', $text);
        foreach ($text_array as $text_word) {
            $excerpt .= $text_word . ' ';
            if (mb_strlen($excerpt) >= $length) {
                break;
            }
        }

        return trim($excerpt, ' .,!?:;(') . $suffix;
    }

    /**
     * Checks if a word is a valid searchable word
     * @param string $word
     * @return bool
     */
    private static function validateSearchWord($word)
    {
        // If the word is CJK we don't want to index it, but we do want to be allowed to search it
        if (self::isCJK($word)) {
            return false;
        }

        // Check the word is within the min/max length
        $num_chars = mb_strlen($word);
        return $num_chars >= self::$search_min_word && $num_chars <= self::$search_max_word;
    }

    /**
     * Check if a given word is CJK or Hangul.
     * @param string $word
     * @return bool
     */
    private static function isCJK($word)
    {
        $cjk_hangul_regex = '[' .
            '\x{1100}-\x{11FF}' .   // Hangul Jamo
            '\x{3130}-\x{318F}' .   // Hangul Compatibility Jamo
            '\x{AC00}-\x{D7AF}' .   // Hangul Syllables

            // Hiragana
            '\x{3040}-\x{309F}' .   // Hiragana

            // Katakana
            '\x{30A0}-\x{30FF}' .   // Katakana
            '\x{31F0}-\x{31FF}' .   // Katakana Phonetic Extensions

            // CJK Unified Ideographs
            '\x{2E80}-\x{2EFF}' .   // CJK Radicals Supplement
            '\x{2F00}-\x{2FDF}' .   // Kangxi Radicals
            '\x{2FF0}-\x{2FFF}' .   // Ideographic Description Characters
            '\x{3000}-\x{303F}' .   // CJK Symbols and Punctuation
            '\x{31C0}-\x{31EF}' .   // CJK Strokes
            '\x{3200}-\x{32FF}' .   // Enclosed CJK Letters and Months
            '\x{3400}-\x{4DBF}' .   // CJK Unified Ideographs Extension A
            '\x{4E00}-\x{9FFF}' .   // CJK Unified Ideographs
            '\x{20000}-\x{2A6DF}' . // CJK Unified Ideographs Extension B
            ']';

        return preg_match('%^' . $cjk_hangul_regex . '+$%u', $word) ? true : false;
    }
}
