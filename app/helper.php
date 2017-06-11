<?php

	function dateConvertFormtoDB($date){
		if(!empty($date)){
			return date("Y-m-d",strtotime(str_replace('/','-',$date)));
		}
	}

	function dateConvertDBtoForm($date){
		if(!empty($date)){
			$date = strtotime($date);
			return date('d/m/Y', $date);
		}
	}


	function caseStatus(){
		return ['---- Please Select ----','Case Submit', 'Investigation', 'Charge Sheet', 'Coart', 'Complete'];
	 }


?>