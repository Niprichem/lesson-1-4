<?php
$csv_filename = "maney.csv";
$date_format = 'Y-m-d';
if (count($argv) == 2 && $argv[1] == '--today') {
    $fp = fopen($csv_filename, "r");
    if (!$fp) {
        throw new Exception('Error: file does not exist');
    }

    $row = fgetcsv($fp, 0, ",");
    $sum_price = 0.;
    while ($row) {
        list($date, $price, $description) = $row;
        if ((string) $date == (string) date($date_format)) {
            $sum_price += $price;
        }
        $row = fgetcsv($fp, 0, ",");
    }
    echo date($date_format) . ' расход за день: ' . $sum_price;
}
else {
    if (count($argv) < 3) {
        throw new Exception('Ошибка! Аргументы не заданы. Укажите флаг --today или запустите скрипт с аргументами {цена} и {описание покупки}');
    }

    if (!is_numeric($argv[1])) {
        throw new Exception('Error: first parameter should be numeric');
    }

    $price = floatval($argv[1]);
    $description = implode(' ', array_slice($argv, 2));

    $fp = fopen($csv_filename, "a");
    $record = [date($date_format), $price, $description];
    fputcsv($fp, $record);
    fclose($fp);
}
?>
