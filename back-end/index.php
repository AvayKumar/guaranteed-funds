<?php
	
$date1=date_create();
echo $date1->format('Y-m-d h:i:s').'</br>';
$date2=date_create("2017-03-20 10:43:20");
echo $date2->format('Y-m-d h:i:s').'</br>';
$diff=date_diff($date1, $date2);
echo $diff->format('%d.%m.%Y %h:%i:%s');