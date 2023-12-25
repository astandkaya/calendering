<?php

require_once __DIR__ . '/vendor/autoload.php';

use Calendering\Calendering;



$calender = Calendering::make(2024, 1);
// $calender = Calendering::now();

foreach ($calender as $key => $week) {
    foreach ($week as $day) {
        dump($day->getDate()->format('Y-m-d'));
        dump($day->getIsCurrentMonth());
    }
    dump('---');
}
exit;



$calender = $calender->setSchedule(1, []);
$calender = $calender->getSchedule(1);



$calender->prevMonth(1);
$calender->nextMonth(1);
