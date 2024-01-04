<?php

namespace App\Helpers;

use Str;

class Md
{
    public static function escapeSpecialCharacters(string $string): string
    {
        $specialCharacters = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];

        foreach ($specialCharacters as $char) {
            $escapedChar = '\\' . $char;
            $string = str_replace($char, $escapedChar, $string);
        }

        return $string;
    }

    public static function escapeSpecialCharactersInArray(array $array): array
    {
        foreach ($array as &$item) {
            if (is_string($item)) {
                $item = self::escapeSpecialCharacters($item);
            } elseif (is_array($item)) {
                $item = self::escapeSpecialCharactersInArray($item);
            }
        }

        return $array;
    }

}
