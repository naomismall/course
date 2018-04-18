<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Index page</title>
    </head>
    <body>

		<h1>Index page</h1>
		<?php 	




    function stats_standard_deviation(array $a, $sample = false) {
        $n = count($a);
        if ($n === 0) {
            trigger_error("The array has zero elements", E_USER_WARNING);
            return false;
        }
        if ($sample && $n === 1) {
            trigger_error("The array has only 1 element", E_USER_WARNING);
            return false;
        }
        $mean = array_sum($a) / $n;
        $carry = 0.0;
        foreach ($a as $val) {
            $d = ((double) $val) - $mean;
            $carry += $d * $d;
        };
        if ($sample) {
           --$n;
        }
        return sqrt($carry / $n);
    }




		
        $marks = array();
        $marks['ad1student'] = array(0,5,4,3,5);

        $marks['ad2student'] = array(5,0,3,3,5);

        $marks['ad3student'] = array(5,4,0,4,2);

        $marks['ad4student'] = array(5,4,3,0,1);

        $marks['ad5student'] = array(5,4,2,5,0);

        // foreach($marks as $mark)

        $trial = array(4,3,3,2);

        $result = round(stats_standard_deviation($trial), 2);

        echo $result;
        
        ?>


    </body>
</html>