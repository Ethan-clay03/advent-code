<?php

class day4 
{
    //Name of input file
    const FILE_PATH = 'input.txt';

    function main() 
    {
        $array = $this->getInput();
        $part_1 = $this->getSumWinningPoints($array);
        echo "Part 1 final total: $part_1 \n";
        echo("Sit tight, Part 2 takes quite a while to process!\n");
        $part_2 = $this->calculateTotalPoints($array);
        
        echo "Part 2 final total: $part_2";
    }

    function getInput()
    {
        return file(self::FILE_PATH, FILE_IGNORE_NEW_LINES);
    }

    function getSumWinningPoints($data)
    {
        $total_points = 0;

        foreach ($data as $card) {
            $parts = explode('|', $card);
            $winning_nums = trim(substr($parts[0], strpos($parts[0], ':') + 1));
            $nums = trim($parts[1]);
    
            $winning_nums = explode(' ', preg_replace('/\s+/', ' ', $winning_nums));
            $nums = explode(' ', preg_replace('/\s+/', ' ', $nums));
    
            $matches = array_intersect($winning_nums, $nums);
            $match_count = count($matches);
    
            if ($match_count > 0) {
                $points = pow(2, $match_count - 1);
            } else {
                $points = 0;
            }
    
            $total_points += $points;
        }
        return $total_points;
    }

    function truncateGame($round_string, $game_id) 
    {
        $to_remove = strlen("Card $game_id: ");
        return substr($round_string, $to_remove);

    }

    function calculateTotalPoints($data)
    {
        $total = count($data);

        for ($i = 0; $i < count($data); $i++) {
            $total += $this->processCopies($data, $i);
        }
        return $total;
    }


    //Ampersand needed cause recursive logic
    function processCopies(&$data, $index)
    {
        if ($index >= count($data)) {
            return 0;
        }

        [$winning_nums, $nums] = explode('|', $data[$index]);
        $winning_nums = array_filter(explode(' ', trim($winning_nums)), 'strlen');
        $nums = array_filter(explode(' ', trim($nums)), 'strlen');

        $matches = array_intersect($winning_nums, $nums);
        $count = count($matches);

        $total = 0;
        for ($i = 1; $i <= $count; $i++) {
            $total = 1 + $this->processCopies($data, $index + $i) + $total;
        }

        return $total;
    }


}

$day4 = new day4();
$day4->main();

