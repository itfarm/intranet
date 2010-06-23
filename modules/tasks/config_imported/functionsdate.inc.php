<?php
function DateDropDownDay($MaxDay) {
	$outputstring = "<option value=''>-</option>";
	For ($i = 1; $i <= $MaxDay; ++$i) {
		$outputstring = $outputstring."<option value='".$i."'>".$i."</option>";
	}
	return $outputstring;
}

function DateDropDownMonth() {
						return "<option value=''>-</option>
								<option value='01'>January</option>
								<option value='02'>February</option>
								<option value='03'>March</option>
								<option value='04'>April</option>
								<option value='05'>May</option>
								<option value='06'>June</option>
								<option value='07'>July</option>
								<option value='08'>August</option>
								<option value='09'>September</option>
								<option value='10'>October</option>
								<option value='11'>November</option>
								<option value='12'>December</option>";
	
}

function DateDropDownYear($MinYear, $MaxYear) {
	$outputstring = "<option value=''>-</option>";
	For ($i = $MinYear; $i <= $MaxYear; ++$i) {
		$outputstring = $outputstring."<option value='".$i."'>".$i."</option>";
	}
	return $outputstring;
}

function DateDropDownFinancialYear($MinYear, $MaxYear) {
	$outputstring = "<option value=''>-</option>";
	For ($i = $MinYear; $i <= $MaxYear; ++$i) {
		$outputstring = $outputstring."<option value='July ".$i."-June ".($i+1)."'>July ".$i."-June ".($i+1)."</option>";
	}
	return $outputstring;
}

function MonthName($MonthNumber) {
	switch ($MonthNumber) {
		case  1: $TheMonthName = 'January';break;
		case  2: $TheMonthName = 'February';break;
		case  3: $TheMonthName = 'March';break;
		case  4: $TheMonthName = 'April';break;
		case  5: $TheMonthName = 'May';break;
		case  6: $TheMonthName = 'June';break;
		case  7: $TheMonthName = 'July';break;
		case  8: $TheMonthName = 'August';break;
		case  9: $TheMonthName = 'September';break;
		case  10: $TheMonthName = 'October';break;
		case  11: $TheMonthName = 'November';break;
		case  12: $TheMonthName = 'December';break;
	}
	return $TheMonthName;
}


function ReturnDateForPeriod($ReportPeriod, $ReportFrequency, $FromOrTo) {
	
	$TheYear = substr($ReportPeriod,strlen($ReportPeriod)-4,4);
		
	switch ($ReportFrequency) {
		case "Quarterly":
			$TheQuarter = substr($ReportPeriod,0,strlen($ReportPeriod)-5);
			switch ($TheQuarter) {
				case "January-March":
					switch ($FromOrTo) {
						case "from":
							$TheDate = $TheYear.'-01-01';
							break;
						case "to":
							$TheDate = $TheYear.'-03-31';
							break;
					}
					break;
				case "April-June":
					switch ($FromOrTo) {
						case "from":
							$TheDate = $TheYear.'-04-01';
							break;
						case "to":
							$TheDate = $TheYear.'-06-30';
							break;
					}
					break;
				case "July-September":
					switch ($FromOrTo) {
						case "from":
							$TheDate = $TheYear.'-07-01';
							break;
						case "to":
							$TheDate = $TheYear.'-09-30';
							break;
					}
					break;
				case "October-December":
					switch ($FromOrTo) {
						case "from":
							$TheDate = $TheYear.'-10-01';
							break;
						case "to":
							$TheDate = $TheYear.'-12-31';
							break;
					}
					break;	
			}
			break;
			case "Annual":
				switch ($FromOrTo) {
					case "from":
						$TheStartYear = $TheYear-1;
						$TheDate = $TheStartYear.'-07-01';
						break;
					case "to":
						$TheDate = $TheYear.'-06-30';
						break;
				}
			break;
	}
	Return $TheDate;
}



?>
