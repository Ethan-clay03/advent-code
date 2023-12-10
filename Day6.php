<?php

class Day6
{
    private $lines;
    private $races;

    public function main()
    {
        $data = $this->getFile();
        $this->parseLines($data);
        $this->processRaces();
        $this->part1();
        $this->part2();
    }

    private function getFile() 
    {
        return file('input.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    }

    private function parseLines($data)
    {
        foreach ($data as $line) {
            $split_lines = preg_split('/\s+/', $line);
            $split_line = array_slice($split_lines, 1);
            $this->lines[] = $split_line;
        }
    }

    private function processRaces()
    {
        foreach ($this->lines[0] as $i => $value) {
            $this->races[] = [$value, $this->lines[1][$i]];
        }
    }

    private function part1()
    {
        $part1 = 1;
        foreach ($this->races as $race) {
            list($time, $distance) = $race;
            $part1 *= $this->getWays($time, $distance);
        }
        echo "Part 1: $part1\n";
    }

    private function part2()
    {
        $time = implode('', array_column($this->races, 0));
        $distance = implode('', array_column($this->races, 1));

        $part2 = $this->getWays($time, $distance);
        echo "Part 2: $part2\n";
    }

    private function getWays($time, $distance)
    {
        $min = ceil(($distance + 1) / $time);
        $max = $time - 1;
        $ways = 0;
        for ($i = $min; $i <= $max; $i++) {
            if (($time - $i) * $i > $distance) {
                $ways++;
            }
        }
        return $ways;
    }
}

$day6 = new Day6();
$day6->main();