<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Index page</title>
    </head>
    <body>
        <?php
        
        // optionally include navigation here
        
        ?>
        <h1>Index page</h1>

<?php

// if (empty($argv[1])) die("The json file name or URL is missed\n");
// 

$jsonFilename = 'jsonfile.json';

$json = file_get_contents($jsonFilename);

$convert = explode("\n", $json); //create array separate by new line

for ($i=0;$i<count($convert);$i++) 
{
    $array = json_decode($convert[$i], true);
    print_r($array);
    echo PHP_EOL;
    echo '-------------------------------------------------------'.PHP_EOL;
    echo $i;
    echo '<br/>';
    echo '-------------------------------------------------------'.PHP_EOL;
    //echo PHP_EOL.$i.PHP_EOL;
    //print_r($convert[$i]).PHP_EOL; //write value by index
}
?>
</body>
</html>


// $array = json_decode($json, true);
// $f = fopen('output.csv', 'w');

// $firstrowKeys = false;
// foreach ($array as $row)
// {
//     if (empty($firstrowKeys))
//     {
//         $firstrowKeys = array_keys($row);
//         fputcsv($f, $firstrowKeys);
//         $firstrowKeys = array_flip($firstrowKeys);
//     }
//     $row_array = array($row['type']);
//     foreach ($row['conversion'] as $value)
//     {
//         array_push($row_array,$value);
//     }
//     array_push($row_array,$row['stream_type']);
//     fputcsv($f, $row_array);

// }