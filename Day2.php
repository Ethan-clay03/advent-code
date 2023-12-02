<?php


class day2
{

    //Change which part number you want to output.
    const PART = 2;

    //Don't need to change these values
    const GREEN_COUNT = 13;
    const RED_COUNT = 12;
    const BLUE_COUNT = 14;

    function main()
    {
        $raw_data = $this->getInput();
        $array_data = $this->parseInput($raw_data);

        $count_1 = $this->checkValidGames($array_data);
        $count_2 = $this->calculateCubePowers($array_data);
        echo "Final count for part 1: $count_1 \n Final count for part 2: $count_2";
    }

    function getInput()
    {
        return file_get_contents('input.txt');
    }

    function parseInput($data)
    {
        $games = explode("\n", $data);

        $parsed_data = [];

        foreach ($games as $game) {
            preg_match('/Game (\d+)/', $game, $matches);

                $game_id = $matches[1];

                $rounds = explode(";", $game);

                //Too lazy to do anything fancy so this removes `Game ID:` from start of first $round
                $rounds[0] = $this->truncateGame($rounds[0], $game_id);

                foreach ($rounds as $round) {
                    $split = explode(", ", $round);
                    $round_data = [];

                foreach ($split as $split_type) {
                    preg_match('/(\d+) ([a-zA-Z]+)/', $split_type, $matches);
                    $round_data[] = [$matches[2] => $matches[1]];
                }

                $parsed_data[$game_id][] = $round_data;
                }
        }

        return $parsed_data;
    }

    function truncateGame($round_string, $game_id) 
    {
        $to_remove = strlen("Game $game_id: ");
        return substr($round_string, $to_remove);

    }

    function checkValidGames($game_data) 
    {
        $valid_count = 0;

        foreach ($game_data as $id => $games) {
            $invalid = false;

            foreach ($games as $game) {
                foreach ($game as $row) {
                    foreach ($row as $colour => $count) {
                        if (
                            ($colour === "green" && $count > self::GREEN_COUNT) ||
                            ($colour === "red" && $count > self::RED_COUNT) ||
                            ($colour === "blue" && $count > self::BLUE_COUNT)
                        ) {
                            $invalid = true;
                            break 3; 
                        }
                    }
                }
            }

            if ($invalid == false) {
                $valid_count += $id;
            }
        }

        return $valid_count;
    }

    function calculateCubePowers($game_data) 
    {
        $game_total = 0;

        foreach ($game_data as $games) {
            $highest_green = 0;
            $highest_red = 0;
            $highest_blue = 0;

            foreach ($games as $game) {
                foreach ($game as $row) {
                    foreach ($row as $colour => $count) {
                        switch ($colour) {
                            case "green":
                                $highest_green = max($highest_green, $count);
                                break;
                            case "red":
                                $highest_red = max($highest_red, $count);
                                break;
                            case "blue":
                                $highest_blue = max($highest_blue, $count);
                                break;
                        }
                    }
                }
            }
            
            $game_highest_total = ($highest_green * $highest_red * $highest_blue);
            $game_total = $game_highest_total + $game_total;
        }

        return $game_total;
    }

}

$day2 = new day2();
$day2->main();

?>
