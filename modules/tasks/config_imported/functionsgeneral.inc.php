<?php

require_once 'connect.inc.php';

function DropDownLookup($TableName, $IdFieldName, $DescriptionFieldName, $OrderOption = "Desc", $selected_value = "", $show_blank = true) {
	$outputstring = "";
	
	if ($show_blank) {
		$outputstring = "<option value=''>-</option>";
	}
	
	$qry_list_SQL = "Select ".$IdFieldName.", ".$DescriptionFieldName." 
					from ".$TableName;

	if ($OrderOption == "id") {
		$qry_list_SQL = $qry_list_SQL." Order by ".$IdFieldName;
	} else {
		$qry_list_SQL = $qry_list_SQL." order by ".$DescriptionFieldName;
	}
					
	//echo $qry_list_SQL;
	$qry_list_SQL_result = mysql_query($qry_list_SQL);

	if (!$qry_list_SQL_result) {
			exit('<p>Error performing drop down list query: '.mysql_error().'</p>');
	} else {
		While ($qry_list_row = mysql_fetch_array($qry_list_SQL_result)) {
			$outputstring = $outputstring."<option value='".$qry_list_row[$IdFieldName]."' "; 
			if ($qry_list_row[$IdFieldName] == $selected_value) {
					$outputstring = $outputstring.'selected="selected"';
			}
			$outputstring = $outputstring.">".$qry_list_row[$DescriptionFieldName]."</option>";
		}
	}
	return $outputstring;
}

function DropDownLookupFiltered($TableName, $IdFieldName, $DescriptionFieldName, $WhereClause, $OrderOption = "Desc", $selected_value = "") {
	$outputstring = "<option value=''>-</option>";

	$qry_list_SQL = "Select ".$IdFieldName.", ".$DescriptionFieldName." 
					from ".$TableName." 
					where ".$WhereClause;
		
	if ($OrderOption == "id") {
		$qry_list_SQL = $qry_list_SQL." Order by ".$IdFieldName;
	} else {
		$qry_list_SQL = $qry_list_SQL." order by ".$DescriptionFieldName;
	}	
					
	$qry_list_SQL_result = mysql_query($qry_list_SQL);

	if (!$qry_list_SQL_result) {
			exit('<p>Error performing drop down list query: '.mysql_error().'</p>');
	} else {
		While ($qry_list_row = mysql_fetch_array($qry_list_SQL_result)) {
						$outputstring = $outputstring."<option value='".$qry_list_row[$IdFieldName]."' "; 
			if ($qry_list_row[$IdFieldName] == $selected_value) {
					$outputstring = $outputstring.'selected="selected"';
			}
			$outputstring = $outputstring.">".$qry_list_row[$DescriptionFieldName]."</option>";
		}
	}
	return $outputstring;
}

function YesNoList($selected_value = "", $show_blank = true) {
	$outputstring = '';
	
	// blank
	if ($show_blank == true) {
		$outputstring = "<option value='0'>-</option>";
	}
	
	// no	
	$outputstring = $outputstring."<option value='0' ";
	if ($selected_value == 0) {
		$outputstring = $outputstring.'selected="selected"';
	}
	$outputstring = $outputstring.">No</option>";

	// yes
	$outputstring = $outputstring."<option value='-1' ";
	if ($selected_value == -1) {
		$outputstring = $outputstring.'selected="selected"';
	}
	$outputstring = $outputstring.">Yes</option>";
	
	
	return $outputstring;
}


function domain($DomainType, $Expr,$Domain,$Criteria = '') {
	
	
	$TheSQL = "SELECT ".$Expr." FROM ".$Domain;
	
	If ($Criteria <> '') {
		$TheSQL = $TheSQL." WHERE ".$Criteria;
	}
	
	switch ($DomainType) {
		case "dmax":
			$TheSQL = $TheSQL." ORDER BY ".$Expr." DESC";
			break;
		case "dmin":
			$TheSQL = $TheSQL." ORDER BY ".$Expr;
			break;
	}
	//echo $TheSQL;
	$Result = mysql_query($TheSQL);
	
	// echo mysql_num_rows($Result);
	
	if (!$Result) {
		exit('<p>Error performing report domain query: '.mysql_error().'</p>');
	}
	
	if ($DomainType == "dcount") {
		$TheValue = mysql_num_rows($Result);
	} else {
		$Row = mysql_fetch_array($Result);
		$TheValue = $Row[$Expr];
	}
	
	Return $TheValue;
}

function PrepareStringForInsert ($input) {
	// zero length string to word "null"
	if ($input == "") {
		return "null";
	} elseif(is_int($input)) {
		return $input;
	}else {
		return "'".mysql_real_escape_string($input)."'";
	}

}


function BooleanToYesNo($input) {
	if ($input == -1) {
		return "Yes";
	} else {
		return "No";
	}
}

function GetNextID8Dig($LeadingLetter,$IDfieldname,$TableName) {
		$maximum_used_id = domain('dmax',"cast(right(".$IDfieldname.",7) AS unsigned)",$TableName);

		if ($maximum_used_id == "" ) {
			$maximum_used_id = 0;
		}
		
		$next_id = $maximum_used_id + 1;
		return $LeadingLetter.sprintf("%07s", $next_id);

}

function GetNextIDNum($IDfieldname,$TableName) {
		$maximum_used_id = domain('dmax',$IDfieldname,$TableName);
		if ($maximum_used_id == "" ) {
			$maximum_used_id = 0;
		}
		
		$next_id = $maximum_used_id + 1;
		return $next_id;

}

function DropDownTo100($selected_value) {
	$outputstring = "<option value=''>-</option>";
	for ($i = 0; $i <= 100; $i++) {
    	if ($i == $selected_value) {
				$outputstring = $outputstring."<option value=".$i." selected>".$i."</option>";
			} else {
				$outputstring = $outputstring."<option value=".$i.">".$i."</option>";
			}
	}
	
	return $outputstring;
}

function NullToEarlyDate($TheDate) {
	if ($TheDate == "") {
		return '1899-12-30';
	} else {
		return $TheDate;
	}
}

function NullToLateDate($TheDate) {
	if ($TheDate == "") {
		return '3099-12-30';
	} else {
		return $TheDate;
	}
}

function TickBoxes($TableName, $IdField, $NameField, $NumberColumns, $PreTick = false, $DataTableName = "", $DataIdField = "", $DataWhereClause = "") {
	
	$the_SQL = "SELECT ".$IdField.", ".$NameField." FROM ".$TableName." ORDER BY ".$NameField;

	$OutputString = "<table class = 'smallneat'><tr>";

	$the_result = mysql_query("$the_SQL");
	if (!$the_result) {
		exit('<p>Error performing tick box query: '.mysql_error().'</p>');
	}
	$i = 0;
	While ($the_row = mysql_fetch_array($the_result)) {
		$i = $i+1;
		$OutputString = $OutputString.'<td><input type="checkbox" name="'.$IdField.'[]" value="'.$the_row[$IdField].'" onclick="'.$OnClickEvent.'"'; 
		
		if ($PreTick) {
			if (domain('dcount',$DataIdField, $DataTableName,$DataIdField." = '".$the_row[$IdField]."' and ".$DataWhereClause) ==1) {
				$OutputString = $OutputString.' checked ';
			}
		}
		
		$OutputString = $OutputString.'/></td>';
		$OutputString = $OutputString.'<td>'.$the_row[$NameField].'</td>';
		
		if ($i%$NumberColumns==0) {
			$OutputString = $OutputString.'</tr><tr class ="general">';
		}
	}

	$OutputString = $OutputString."</tr></table>";
	return $OutputString;

}
?>
