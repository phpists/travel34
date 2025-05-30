<?php

/**
 * Shortcodes
 *
 * Examples:
 * [shortcode /]
 * [shortcode foo="bar" baz="bing" /]
 * [shortcode foo="bar"]content[/shortcode]
 *
 * Apply shortcodes to content:
 * $out = Shortcodes::parse($content);
 */
class Shortcodes
{
    /**
     * @var array
     */
    protected static $tags;

    /**
     * Get tags config
     * @return array
     */
    public static function getTags()
    {
        self::fetchConfig();
        return self::$tags;
    }

    /**
     * Whether the passed content contains the specified shortcode
     * @param string $content
     * @param string $tag
     * @return bool
     */
    public static function hasShortcode($content, $tag)
    {
        if (false === strpos($content, '[')) {
            return false;
        }

        self::fetchConfig();

        if (array_key_exists($tag, self::$tags)) {
            $tagnames = array_keys(self::$tags);
            $regexp = self::getRegex(implode('|', array_map('preg_quote', $tagnames)));
            preg_match_all('/' . $regexp . '/s', $content, $matches, PREG_SET_ORDER);
            if (empty($matches)) {
                return false;
            }

            foreach ($matches as $shortcode) {
                if ($shortcode[2] === $tag) {
                    return true;
                } elseif (!empty($shortcode[5]) && self::hasShortcode($shortcode[5], $tag)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Search content for shortcodes and filter shortcodes through their callbacks.
     * @param string $content
     * @return string
     */
    public static function parse($content)
    {
        if (strpos($content, '[') === false) {
            return $content;
        }

        self::fetchConfig();

        if (empty(self::$tags)) {
            return $content;
        }

        // Find all registered tag names in $content.
        preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches);
        $tagnames = array_intersect(array_keys(self::$tags), $matches[1]);

        if (empty($tagnames)) {
            return $content;
        }

        // remove <p> and inline tags around block shortcodes
        $block_tagnames = [];
        foreach (self::$tags as $tagname => $tagdata) {
            if (isset($tagdata['inline']) && $tagdata['inline']) {
                continue;
            }
            $block_tagnames[] = $tagname;
        }
        if (count($block_tagnames) > 0) {
            $pattern = self::getRegexForClean($block_tagnames);
            $sp_regex = "(?:[\s\\xC2\\xA0]|&nbsp;)*";

            // replace shortcodes with hashes
            $replaced_codes = [];
            $content = preg_replace_callback("/$pattern/", function ($m) use (&$replaced_codes) {
                $key = '{' . md5($m[0]) . '}';
                $replaced_codes[$key] = $m[0];
                return $key;
            }, $content);

            $pattern = implode('|', array_map('preg_quote', array_keys($replaced_codes)));

            // remove inline tags around codes
            $pattern1 = "(?:<(?:span|code|strong|em|b|i)[^>]*>|<br(?: ?\/)?>)+$sp_regex($pattern)$sp_regex(?:<\/(?:span|code|strong|em|b|i)>|<br(?: ?\/)?>)+";
            $content = preg_replace("/$pattern1/", '$1', $content);

            // remove p around codes
            $pattern2 = "<p[^>]*>$sp_regex($pattern)$sp_regex<\/p>";
            $content = preg_replace("/$pattern2/", '$1', $content);

            $content = strtr($content, $replaced_codes);
        }

        $pattern = self::getRegex($tagnames);
        $content = preg_replace_callback("/$pattern/", function ($m) {
            // allow [[foo]] syntax for escaping a tag
            if ($m[1] == '[' && $m[6] == ']') {
                return substr($m[0], 1, -1);
            }

            $tag = $m[2];
            $attr = self::parseAtts($m[3]);

            if (isset(self::$tags[$tag]['callback']) && is_callable(self::$tags[$tag]['callback'])) {
                return $m[1] . call_user_func(self::$tags[$tag]['callback'], $attr, (isset($m[5]) ? $m[5] : null), $tag) . $m[6];
            } else {
                return $m[1] . $m[6];
            }
        }, $content);

        return $content;
    }

    /**
     * Remove all shortcode tags from the given content.
     * @param string $content
     * @return string
     */
    public static function strip($content)
    {
        if (false === strpos($content, '[')) {
            return $content;
        }

        self::fetchConfig();

        if (empty(self::$tags)) {
            return $content;
        }

        // Find all registered tag names in $content.
        preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches);
        $tagnames = array_intersect(array_keys(self::$tags), $matches[1]);

        if (empty($tagnames)) {
            return $content;
        }

        $pattern = self::getRegex($tagnames);
        $content = preg_replace_callback("/$pattern/", function ($m) {
            // allow [[foo]] syntax for escaping a tag
            if ($m[1] == '[' && $m[6] == ']') {
                return substr($m[0], 1, -1);
            }

            return $m[1] . $m[6];
        }, $content);

        return $content;
    }

    /**
     * Retrieve the shortcode regular expression for searching.
     * @param string|array $tagnames
     * @return string The shortcode search regular expression
     */
    protected static function getRegex($tagnames)
    {
        if (is_array($tagnames)) {
            $tagregexp = join('|', array_map('preg_quote', $tagnames));
        } else {
            $tagregexp = preg_quote($tagnames);
        }
        // With extra [ to allow for escaping shortcodes with double [[]]
        return "\\[(\\[?)($tagregexp)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)";
    }

    /**
     * Retrieve the shortcode regular expression for cleaning tags around shortcodes.
     * @param string|array $tagnames
     * @return string
     */
    protected static function getRegexForClean($tagnames)
    {
        if (is_array($tagnames)) {
            $tagregexp = join('|', array_map('preg_quote', $tagnames));
        } else {
            $tagregexp = preg_quote($tagnames);
        }
        // self closing, opening or closing tag
        return "\\[\\[?(?:($tagregexp)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(\\/)?|\\/($tagregexp))\\]\\]?";
    }

    /**
     * Retrieve all attributes from the shortcodes tag.
     * @param string $text
     * @return array List of attribute values.
     */
    protected static function parseAtts($text)
    {
        $atts = [];
        $pattern = self::getAttsRegex();
        $text = CHtml::decode($text); // todo: check if need
        $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
        if (preg_match_all($pattern, $text, $match, PREG_SET_ORDER)) {
            foreach ($match as $m) {
                if (!empty($m[1])) {
                    $atts[strtolower($m[1])] = stripcslashes($m[2]);
                } elseif (!empty($m[3])) {
                    $atts[strtolower($m[3])] = stripcslashes($m[4]);
                } elseif (!empty($m[5])) {
                    $atts[strtolower($m[5])] = stripcslashes($m[6]);
                } elseif (isset($m[7]) && strlen($m[7])) {
                    $atts[] = stripcslashes($m[7]);
                } elseif (isset($m[8]) && strlen($m[8])) {
                    $atts[] = stripcslashes($m[8]);
                } elseif (isset($m[9])) {
                    $atts[] = stripcslashes($m[9]);
                }
            }

            // Reject any unclosed HTML elements
            foreach ($atts as &$value) {
                if (strpos($value, '<') !== false) {
                    if (preg_match('/^[^<]*+(?:<[^>]*+>[^<]*+)*+$/', $value) !== 1) {
                        $value = '';
                    }
                }
            }
        }
        /*else {
            $atts = ltrim($text);
        }*/
        return $atts;
    }

    /**
     * Retrieve the shortcode attributes regex.
     * @return string
     */
    protected static function getAttsRegex()
    {
        return '/([\w-]+)\s*=\s*"([^"]*)"(?:\s|$)|([\w-]+)\s*=\s*\'([^\']*)\'(?:\s|$)|([\w-]+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|\'([^\']*)\'(?:\s|$)|(\S+)(?:\s|$)/';
    }

    /**
     * Fetch config
     */
    protected static function fetchConfig()
    {
        if (self::$tags === null) {
            self::$tags = Yii::app()->params['shortcodes'];
        }
    }
}