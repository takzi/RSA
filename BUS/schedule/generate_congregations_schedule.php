<?php
	date_default_timezone_set("America/New_York");
	require_once '../../model/DB.class.php';
	require_once '../../model/classes/blackoutDate.class.php';
	require_once '../../model/classes/holiday.class.php';

	if(isset($_POST['action'])){
		$action = $_POST['action'];

		if($action == 'generateCongregationSchedule'){
			$data = generateCongregationSchedule();
			print_r($data);
		}
	}

	function generateCongregationSchedule(){
		$DB = new DB("./../");

		$lastRot = $DB->getLastRotationID();
		$lastRotID = $lastRot[0];

		$lastDate = $DB->getNextRotationDate();
		$lastDateStr = $lastDate[0];

		// get the blackout dates for the next rotattion period
		$blackouts = $DB->getAllBlackoutDates();
		$blackoutArr = array();
		foreach ($blackouts as $blackout) {
			$blackoutArr[$blackout->getCongregationID()] = "{$blackout->getFromDate()}";
		}

		//get next rotation dates
		$dateStart = DateTime::createFromFormat('Y-m-d',$lastDateStr);
		date_add($dateStart,date_interval_create_from_date_string("7 days"));
		$dateEnd = DateTime::createFromFormat('Y-m-d',$lastDateStr);
		date_add($dateEnd,date_interval_create_from_date_string("280 days"));

		$interval = DateInterval::createFromDateString("7 days");
		$period = new DatePeriod($dateStart,$interval,$dateEnd);

		$RotDatesArr = array();
		$counter = 1;
		foreach ($period as $date) {
			$RotDatesArr[$counter] = $date;
			$counter++;
		}


		$dateHolidayStart = $dateStart;
		date_sub($dateHolidayStart,date_interval_create_from_date_string("1 year"));
		$dateHolidayEnd = $dateEnd;
		date_sub($dateHolidayEnd,date_interval_create_from_date_string("1 year"));

		/**
		 * get holidays.. should be calling a new method to be made getHolidays between dates to
		 * get the holidays from the next rotation period from last year.
		 */ 
		$holidays = $DB->getCongregationsHolidaysForDates(date_format($dateHolidayStart, 'Y-m-d'),date_format($dateHolidayEnd, 'Y-m-d'));
		$holidayArr = array();
		if(!empty($holidays)){
			foreach ($holidays as $holiday) {
				$holidayArr[$holiday['date']] = $holiday['last_congregation'];
			}
		}

		//fill in posibility array(matrix)
		// - it needs to take into consideration past rotations in order to create the array
		$possibilitiesArr = array();
		for($i=1; $i<=count($RotDatesArr);$i++){
			$curDate = $RotDatesArr[$i]->format('Y-m-d');
			$blackOutCongs = "";
			foreach($blackoutArr as $blackoutCong => $date){
				if($date != $curDate){
					$blackOutCongs .= "$blackoutCong,";
				}
			}
			$holidayCongs = array();
			foreach ($holidayArr as $hDate => $hCong) {
				if($curDate == $hDate){
					$holidayCongs[] = $hCong;
				}
			}
			print_r($holidayCongs);
			if(!empty($holidayCongs)){
				$newCongs = "";
				foreach ($holidayCongs as $cong) {
					$pattern = "/(^|\D)".$cong."(\D|$)/";
					$newCongs = preg_replace($pattern,',',$blackOutCongs);
					print_r($newCongs);
				}
				$newHolidayCongs = trim($newCongs,',');
				$possibilitiesArr[$i] = $newHolidayCongs;
			}
			else{
				$possibilitiesArr[$i] = $blackOutCongs;
			}
		}

		$numberOfWeeks = 13;
		$numberOfCongregations = 13;
		$numberOfRotationsAtATime = 3;

		$counter = 1;
		// go through the possible schedule array and randomly select congregations for dates.
		$possibilitiesArrCopy = $possibilitiesArr;
		$possibleScheduleRot1 = array();
		$possibleScheduleRot2 = array();
		$possibleScheduleRot3 = array();
		foreach ($possibilitiesArrCopy as $rotNumber => $congsAvailable) {
			
			$search = 0;
			$num = 0;
			$radomNumber = 0;
			$randomSelection = 0;
			while(getType($search) == "integer"){
				$test = explode(',', $congsAvailable);
				$num = count($test);
				$radomNumber = rand(0,($num-1));
				$randomSelection = $test[$radomNumber];
				//check number is not repeating within possibleSchedule before deleting
				if($counter == 1){
					$search = array_search($randomSelection,array_column($possibleScheduleRot1,'congregation'));
				}
				else if ($counter == 2) {
					$search = array_search($randomSelection,array_column($possibleScheduleRot2,'congregation'));
				}
				else{
					$search = array_search($randomSelection,array_column($possibleScheduleRot3,'congregation'));
				}
			}

				// add to possibilityArr
			if($counter == 1){
				$possibleScheduleRot1[$rotNumber] = array("date" => $RotDatesArr[$rotNumber],
												  "congregation" => $randomSelection);
			}
			else if ($counter == 2) {
				$possibleScheduleRot2[$rotNumber] = array("date" => $RotDatesArr[$rotNumber],
												  "congregation" => $randomSelection);
			}
			else{
				$possibleScheduleRot3[$rotNumber] = array("date" => $RotDatesArr[$rotNumber],
												  "congregation" => $randomSelection);
			}

			//deleting selection
			for ($i=1; $i <= ($numberOfWeeks*$counter); $i++) { 
				$oldVal = $possibilitiesArrCopy[$i];
				$pattern = "/(^|\D)".$randomSelection."(\D|$)/";
				$newVal = preg_replace($pattern,',',$oldVal);
				$possibilitiesArrCopy[$i] = trim($newVal,',');
			}

			if($rotNumber%13 == 0){
				$counter ++;
			}
		}

		$possibleSchedule = array(($lastRotID+1)=>$possibleScheduleRot1, ($lastRotID+2)=>$possibleScheduleRot2, ($lastRotID+3)=>$possibleScheduleRot3);
		
		foreach ($possibleSchedule as $rotation => $rot) {
			foreach ($rot as $r => $info) {

				$rotationToDate = DateTime::createFromFormat('Y-m-d',date_format($info['date'], 'Y-m-d'));
				date_add($rotationToDate,date_interval_create_from_date_string("6 days"));

				if($r > 13 && $r < 27){
					$fixedR = $r-13;
					$DB->insertNewRotation($rotation,$fixedR,$info['congregation'],date_format($info['date'],'Y-m-d'),date_format($rotationToDate,'Y-m-d'));
				}
				else if($r >=27){
					$fixedR = $r-26;
					$DB->insertNewRotation($rotation,$fixedR,$info['congregation'],date_format($info['date'],'Y-m-d'),date_format($rotationToDate,'Y-m-d'));
				}
				else{
					$DB->insertNewRotation($rotation,$r,$info['congregation'],date_format($info['date'],'Y-m-d'),date_format($rotationToDate,'Y-m-d'));
				}
			}
		}
	}