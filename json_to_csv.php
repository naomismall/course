<?php

if (empty($argv[1])) die("The json file name or URL is missed\n");
$jsonFilename = $argv[1];

$json = file_get_contents($jsonFilename);
$array = json_decode($json, true);
$f = fopen('output.csv', 'w');

$firstLineKeys = false;
foreach ($array as $line)
{
    if (empty($firstLineKeys))
    {
        $firstLineKeys = array_keys($line);
        fputcsv($f, $firstLineKeys);
        $firstLineKeys = array_flip($firstLineKeys);
    }
    $line_array = array($line['type']);
    foreach ($line['conversion'] as $value)
    {
        array_push($line_array,$value);
    }
    array_push($line_array,$line['stream_type']);
    fputcsv($f, $line_array);

}