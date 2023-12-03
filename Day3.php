<?php

class day3 
{
    //Name of input file
    const FILE_PATH = 'input.txt';

    function main() 
    {
        $array = $this->getInput();
        $part_1 = $this->getSumOfNumbers($array);
        $part_2 = $this->getMultiplesOfGear($array);
        echo "Part 1 final total: $part_1 \nPart 2 final total: $part_2";
    }

    function getInput()
    {
        return file(self::FILE_PATH, FILE_IGNORE_NEW_LINES);
    }

    function getSumOfNumbers($array)
    {
        $sum = 0;

        for ($row = 0; $row < count($array); $row++) {
            for ($letter = 0; $letter < strlen($array[$row]); $letter++) {
                if (is_numeric($array[$row][$letter])) {
                    $number = $array[$row][$letter];
                    $i = $letter + 1;

                    while ($i < strlen($array[$row]) && is_numeric($array[$row][$i])) {
                        $number .= $array[$row][$i];
                        $i++;
                    }

                    if ($this->numberTouchingSymbol($array, $row, $letter, $i - 1, 1)) {
                        $sum = $sum + $number;
                    }

                    $letter = $i - 1;
                }
            }
        }

        return $sum;
    }

    function numberTouchingSymbol($array, $row, $letter, $k, $part)
    {
        for ($col = $letter; $col <= $k; $col++) {
            if ($x = $this->hasAdjacentSymbol($array, $row, $col, $part)) {
                if ($part == 1) {
                    return true;
                } else {
                    return $x;
                }
            }
        }
        return false;
    }


    function hasAdjacentSymbol($array, $row, $letter, $part)
    {
        $neighbour_squares = [[-1, -1], [-1, 0], [-1, 1], [0, -1], [0, 1], [1, -1], [1, 0], [1, 1]];

        foreach ($neighbour_squares as $neighbour) {
            $a = $row + $neighbour[0];
            $b = $letter + $neighbour[1];

            if ($a >= 0 && $a < count($array) && $b >= 0 && $b < strlen($array[$a])) {
                $adjectent = $array[$a][$b];
                if (!is_numeric($adjectent) && $adjectent !== '.' && $adjectent !== ' ') {
                    if ($part == 1) {
                        return true;
                    } else {
                        return $a . "-" . $b;
                    }
                }
            }
        }

        return false;
    }

    function getMultiplesOfGear($array)
    {
        $gear_numbers = [];
        $total = 0;

        foreach ($array as $key => $line) {
            $array[$key] = preg_replace('/[^0-9*]/', '.', $line);
        }

        foreach ($array as $key => $line) {
            for ($col_key = 0; $col_key < strlen($line); $col_key++) {
                if (is_numeric($line[$col_key])) {
                    $number = $line[$col_key];
                    $next_key = $col_key + 1;
    
                    while ($next_key < strlen($line) && is_numeric($line[$next_key])) {
                        $number .= $line[$next_key];
                        $next_key++;
                    }
    
                    $gear_position = $this->numberTouchingSymbol($array, $key, $col_key, $next_key - 1, 2);
                    if ($gear_position) {
                        $gear_numbers[$gear_position][] = $number;
                    }
    
                    $col_key = $next_key - 1;
                }
            }
        }
    
        foreach ($gear_numbers as $numbers) {
            if (count($numbers) == 2) {
                $total = ($numbers[0] * $numbers[1]) + $total;
            }
        }
    
        return $total;
    }
}

$day3 = new day3();
$day3->main();

