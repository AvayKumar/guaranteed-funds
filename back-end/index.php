<?php
		die('Access Denied');
		$date = date_create();
		$db_date = date_create('2017-03-23 15:14:25');
		//$window = 5;
		$newDate = $db_date->add(new DateInterval('PT50M'));

		echo $date->format('Y m d h i s').'</br>';
		echo $newDate->format('Y m d h i s').'</br>';

		if($date < $db_date) {
				$diff = date_diff($db_date, $date);
		} else {
			// TODO block user
		}


		echo $diff->format('%Y %m %d %h %i %s');