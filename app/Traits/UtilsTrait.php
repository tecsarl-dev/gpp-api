<?php
namespace App\Traits;

trait UtilsTrait{
    /**
     * Generate Numbers and shuffle the result 
     * @param Integer $n
     * @return Integer
     */
    public function generateNumbers(int $n):Int
    {
        $numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $numbersGenerateArray = [];

        for ($i = 0; $i < $n; $i++) {
            $nombre = random_int(1, 9);
            $numbersGenerateArray[$i] = $numbers[$nombre];
        }

        $numbersGenerateString = implode($numbersGenerateArray);
        $result = str_shuffle(trim($numbersGenerateString));

        return $result;
    }
    
}
