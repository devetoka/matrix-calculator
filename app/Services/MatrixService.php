<?php


namespace App\Services;


class MatrixService
{
    protected function __construct()
    {
    }

    public static function multiply($first_matrix, $second_matrix, $alpha = true)
    {
        $result = [];
        $count_of_mat2 = count($second_matrix[0]);
        $count_of_mat1 = count($first_matrix);

        for($i = 0; $i < $count_of_mat1; $i++){
            $column = [];
            for($k = 0; $k < $count_of_mat2; $k++) {
                $product = 0;
                for($j = 0; $j < count($first_matrix[$i]); $j++){
                    $product += $first_matrix[$i][$j] * $second_matrix[$j][$k];
                }
                $column[] =  $alpha && $product > 0 ? self::printAlpha($product) : $product;
            }
            $result[] = $column;
        }
        return $result;
    }

    public static function printAlpha($number)
    {
        $alpha = range('a','z');
        $mod = $number % 26;
        $rem = floor($number/26);
        if($mod == 0){
            $mod = 26;
            $rem = $rem - 1;
        }

        if($rem > 26) {
            return self::printAlpha($rem) . strtoupper($alpha[$mod - 1]);
        }

        if(isset($alpha[$rem - 1])){
            $mod = $alpha[$rem - 1].$alpha[$mod -1];
        }else{
            $mod = $alpha[$mod - 1];
        }
        return strtoupper($mod);
    }

}