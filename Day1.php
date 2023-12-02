<?php


class puzzle
{
    //File name of data provided by Advent of code
    const FILENAME = 'input.txt';
    //Would you like Part 1 or Part 2 of the solution
    const PART = 2;


    private $list_numbers = [];

    function main()
    {
        $raw_data = $this->getInput();
        $array_data = $this->parseInput($raw_data);
        $this->processArray($array_data);
        $result = $this->getAnswer();
        echo "Final result is $result";
    }

    function getInput()
    {
        return file_get_contents('input.txt');
    }

    function parseInput($data)
    {
        return explode("\n",$data);
    }

    function processArray($data)
    {
        $i = 0;
        foreach ($data as $line) {
            if (self::PART == 2) {
                $array = $this->replaceValues($line);
                $list = $this->getNumberPosition($array);
                $this->list_numbers[$i] = $this->concatNumbers($list);
                $i++;
            } else {
                if (!preg_match_all('/\d/', $line, $matches)) {
                    echo "No numbers found, on $line, $i passes made";
                    die();
                } else {
                    $this->list_numbers[$i] = $this->concatNumbers($matches[0]);
                    $i++;
                }
            }
        }
        return true;
    }

    function replaceValues($string)
    {
        $search  = ['one','two','three','four','five','six','seven','eight','nine','zero',1,2,3,4,5,6,7,8,9,0];
        $result_forward = [];
        $result_inverse = [];


        //Get first instance of every number
        foreach ($search as $s)
        {
            $pos = strpos($string, $s);

            if ($pos !== false) {
                    $result_forward[$s] = $pos;
            } 

            $result['forward'] = $result_forward;
        }
        //Get last instance of every number
        foreach ($search as $s)
        {
            $pos = strrpos($string, $s);

            if ($pos !== false) {
                    $result_inverse[$s] = $pos;
            }
            $result['reverse'] = $result_inverse;
        }

        return empty($result) ? false : $result;
    }

    function concatNumbers($matches)
    {
        $matches_count = count($matches);

        if ($matches_count == 1) {
            //Returns the same number twice if only one instance exists
            return $matches[0] . $matches[0];
        } else {
            //Returns the first and last array entry
            return $matches[0] . $matches[$matches_count-1];
        }

    }

    function getAnswer()
    {
        $answer = null;
        foreach ($this->list_numbers as $number) {
            $answer = $answer + $number;
        }

        return $answer;
    }

    function getNumberPosition($array)
    {
        $convert = [
            1=>'one',
            2=>'two',
            3=>'three',
            4=>'four',
            5=>'five',
            6=>'six',
            7=>'seven',
            8=>'eight',
            9=>'nine',
            0=>'zero',
        ];

        $min_value = null;
        $min_key = null;
        $max_value = null;
        $max_key = null;

        foreach ($array as $type) {
            foreach($type as $id => $pos) {
                if ($min_value === null || $pos < $min_value) {
                    $min_key = $id;
                    $min_value = $pos;
                }
                if ($max_value === null || $pos > $max_value) {
                    $max_key = $id;
                    $max_value = $pos;
                }
            }

            if (is_int($min_key)) {
                $value['0'] = $min_key;
            } else {
                $value['0'] = array_search($min_key, $convert);
            }

            if (is_int($max_key)) {
                $value['1'] = $max_key;
            } else {
                $value['1'] = array_search($max_key, $convert);
            }
        }
        return $value;
    }

}

$start = new puzzle();
$start->main();


?>