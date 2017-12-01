<?php
	require_once '../../model/DB.class.php';
	require_once '../../model/classes/availability.class.php';

	if(isset($_POST['action'])){
		$action = $_POST['action'];

		if($action == 'generateBusDriverSchedule'){
			$data = generateBusDriverSchedule();
			print_r($data);
		}
	}

	function generateBusDriverSchedule(){
		$DB = new DB('./../');

		//get all availability.
		$availabilities = $DB->getAllAvailability();

		/**
		 *  getRotationDates - method shall receive the start date for the rotation
		 * the bus driver schedule is beign made for. After it receives the date it
		 * will create another date with the end date, then create datetime objects
		 * with these dates. Then clycle through the dates one by one, and add these
		 * dates into an array.
		 * @param  string $date - [description]
		 * @return [Datetime] $rotDates - Array containing datetime objects that
		 *                              represent the rotation dates for the next
		 *                              bus driver schedule.
		 **/
		//function getRotationDates($date){
			$dateStart = DateTime::createFromFormat('Y-m-d','2017-09-03'); //curDate
			$dateEnd = DateTime::createFromFormat('Y-m-d','2017-09-03');	//curDate
			date_add($dateEnd,date_interval_create_from_date_string("91 days")); //91 days

			$interval = DateInterval::createFromDateString("1 days");
			$period = new DatePeriod($dateStart,$interval,$dateEnd);

			$rotDates = array();
			$counter = 1;
			foreach ($period as $date) {
				$rotDates[$counter] = $date;
				$counter++;
			}
		// }

		/**
		 *  getDriverPossibilities - method shall take in the 2
		 * @return [string] $possibilitesArr  - 
		 **/
		//function getDriverPossibilities(){
			$rotDatesArr = array();
			$possibilitiesArr = array();
			for($i=1; $i<=count($rotDates);$i++){
				$curDate = $rotDates[$i]->format('Y-m-d');
				$rotDatesArr[$curDate] = array();
				$congs = array("Any"=>"","Morning"=>"","Afternoon"=>"");
				$possibilitiesArr[$curDate] = $congs;
				foreach($availabilities as $availability){
					if($availability->getAvailability() == $curDate){
						$possibilitiesArr[$curDate][$availability->getTimeOfDay()] .= ",".$availability->getBusDriverID();
						$possibilitiesArr[$curDate][$availability->getTimeOfDay()] = trim($possibilitiesArr[$curDate][$availability->getTimeOfDay()],",");
					}
				}
			}
		//}

		// echo "<pre>";
		// print_r($rotDates);
		// echo "<pre>";

		// echo "<pre>";
		// print_r($possibilitiesArr);
		// echo "<pre>";

		foreach($rotDatesArr as $date => $blah){
			foreach ($possibilitiesArr as $possibilityDate => $possibilities) {
				if($date == $possibilityDate){
					if($possibilities["Any"] != "" && $possibilities["Morning"] != "" && $possibilities["Afternoon"] != ""){
						$anyTime = explode(',',$possibilities["Any"]);
						$morningOnly = explode(',',$possibilities["Morning"]);
						$afternoonOnly = explode(',',$possibilities["Afternoon"]);

						if(count($morningOnly) >= 2 && count($afternoonOnly) >= 2){
							//Have enough drivers from morning and afternoon to fill
							//primary and backup roles
							$morningNum = count($morningOnly);
							$morningRadomNumber1 = rand(0,($morningNum-1));
							$morningRadomNumber2 = $morningRadomNumber1;
							while($morningRadomNumber2 == $morningRadomNumber1){
								$morningRadomNumber2 = rand(0,($morningNum-1));
							}

							$afternoonNum = count($afternoonOnly);
							$afternoonRadomNumber1 = rand(0,($afternoonNum-1));
							$afternoonRadomNumber2 = $afternoonRadomNumber1;
							while($afternoonRadomNumber2 == $afternoonRadomNumber1){
								$afternoonRadomNumber2 = rand(0,($afternoonNum-1));
							}

							$rotDatesArr[$date] = array("Morning"=>array(
															"Primary"=>$morningOnly[$morningRadomNumber1],
															"Backup"=>$morningOnly[$morningRadomNumber2]),
														"Afternoon"=>array(
															"Primary"=>$afternoonOnly[$afternoonRadomNumber1],
															"Backup"=>$afternoonOnly[$afternoonRadomNumber2])
														);
							
						}
						else if(count($morningOnly) < 2 && count($afternoonOnly) >= 2){
							//	Only enough afternoon drivers to fill primary and backup,
							//morning should be aggregated with anytime drivers to compensate
							$morningWithAnyTime = array_merge($morningOnly,$anyTime);

							$morningNum = count($morningWithAnyTime);
							$morningRadomNumber1 = rand(0,($morningNum-1));
							$morningRadomNumber2 = $morningRadomNumber1;
							while($morningRadomNumber2 == $morningRadomNumber1){
								$morningRadomNumber2 = rand(0,($morningNum-1));
							}

							$afternoonNum = count($afternoonOnly);
							$afternoonRadomNumber1 = rand(0,($afternoonNum-1));
							$afternoonRadomNumber2 = $afternoonRadomNumber1;
							while($afternoonRadomNumber2 == $afternoonRadomNumber1){
								$afternoonRadomNumber2 = rand(0,($afternoonNum-1));
							}

							$rotDatesArr[$date] = array("Morning"=>array(
															"Primary"=>$morningWithAnyTime[$morningRadomNumber1],
															"Backup"=>$morningWithAnyTime[$morningRadomNumber2]),
														"Afternoon"=>array(
															"Primary"=>$afternoonOnly[$afternoonRadomNumber1],
															"Backup"=>$afternoonOnly[$afternoonRadomNumber2])
														);
						}
						else if(count($morningOnly) >= 2 && count($afternoonOnly) < 2){
							//	Only enough morning drivers to fill primary and backup,
							//afternoon should be aggregated with anytime drivers to compensate
							$afternoonWithAnyTime = array_merge($afternoonOnly,$anyTime);
							
							$morningNum = count($morningOnly);
							$morningRadomNumber1 = rand(0,($morningNum-1));
							$morningRadomNumber2 = $morningRadomNumber1;
							while($morningRadomNumber2 == $morningRadomNumber1){
								$morningRadomNumber2 = rand(0,($morningNum-1));
							}

							$afternoonNum = count($afternoonWithAnyTime);
							$afternoonRadomNumber1 = rand(0,($afternoonNum-1));
							$afternoonRadomNumber2 = $afternoonRadomNumber1;
							while($afternoonRadomNumber2 == $afternoonRadomNumber1){
								$afternoonRadomNumber2 = rand(0,($afternoonNum-1));
							}

							$rotDatesArr[$date] = array("Morning"=>array(
															"Primary"=>$morningOnly[$morningRadomNumber1],
															"Backup"=>$morningOnly[$morningRadomNumber2]),
														"Afternoon"=>array(
															"Primary"=>$afternoonWithAnyTime[$afternoonRadomNumber1],
															"Backup"=>$afternoonWithAnyTime[$afternoonRadomNumber2])
														);
						}
						else if(count($morningOnly) < 2 && count($afternoonOnly) < 2 && count($anyTime) >= 2){
							//both have less than 2, so anytime will be split between them
							$alwaysNum = count($anyTime);

							$firstHalf = array_splice($anyTime, 0, $alwaysNum / 2);
							$secondHalf = array_splice($anyTime, $alwaysNum / 2);

							$morningWithAnyTime = array_merge($morningOnly,$firstHalf);
							$$afternoonWithAnyTime = array_merge($afternoonOnly,$secondHalf);

							$morningNum = count($morningWithAnyTime);
							$morningRadomNumber1 = rand(0,($morningNum-1));
							$morningRadomNumber2 = $morningRadomNumber1;
							while($morningRadomNumber2 == $morningRadomNumber1){
								$morningRadomNumber2 = rand(0,($morningNum-1));
							}

							$afternoonNum = count($afternoonWithAnyTime);
							$afternoonRadomNumber1 = rand(0,($afternoonNum-1));
							$afternoonRadomNumber2 = $afternoonRadomNumber1;
							while($afternoonRadomNumber2 == $afternoonRadomNumber1){
								$afternoonRadomNumber2 = rand(0,($afternoonNum-1));
							}

							$rotDatesArr[$date] = array("Morning"=>array(
															"Primary"=>$morningWithAnyTime[$morningRadomNumber1],
															"Backup"=>$morningWithAnyTime[$morningRadomNumber2]),
														"Afternoon"=>array(
															"Primary"=>$afternoonWithAnyTime[$afternoonRadomNumber1],
															"Backup"=>$afternoonWithAnyTime[$afternoonRadomNumber2])
														);
						}
					}
					// else{
					// 	echo "availability missing to complete schedule";
					// 	break 2;
					// }
					// echo "<pre>";
					// print_r($possibilities);
					// echo "<pre>";
				}
			}
		}

		// echo "<pre>";
		// print_r($possibilitiesArr);
		// echo "<pre>";
		
		echo "<pre>";
		print_r($rotDatesArr);
		echo "<pre>";
	}