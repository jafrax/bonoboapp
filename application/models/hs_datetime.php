<?php
class hs_datetime extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}
//--------------------------------- DATE SOURCE --------------------------------------------------//
	/*
		/ DAY LANGUAGE
		/ getDaylang return as string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 23 Januari 2014
	*/
	private function getDayLang($day){
		switch($day){
			case"Monday":return "Senin";break;
			case"Tuesday":return "Selasa";break;
			case"Wednesday":return "Rabu";break;
			case"Thusday":return "Kamis";break;
			case"Friday":return "Jumat";break;
			case"Saturday":return "Sabtu";break;
			case"Sunday":return "Minggu";break;
			case"Mon":return "Senin";break;
			case"Tue":return "Selasa";break;
			case"Wed":return "Rabu";break;
			case"Thu":return "Kamis";break;
			case"Fri":return "Jumat";break;
			case"Sat":return "Sabtu";break;
			case"Sun":return "Minggu";break;
			default:return "Senin";break;
		}
	}
	
	/*
		/ MONTH LANGUAGE
		/ getDaylang return as string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 23 Januari 2014
	*/
	private function getMonthLang($month){
		switch($month){
			case"01":return "Januari";break;
			case"02":return "Februari";break;
			case"03":return "Maret";break;
			case"04":return "April";break;
			case"05":return "Mei";break;
			case"06":return "Juni";break;
			case"07":return "Juli";break;
			case"08":return "Agustus"; break;
			case"09":return "September"; break;
			case"10":return "Oktober"; break;
			case"11":return "November"; break;
			case"12":return "Desember"; break;
			case"January":return "Januari";break;
			case"February":return "Februari";break;
			case"March":return "Maret";break;
			case"April":return "April";break;
			case"May":return "Mei";break;
			case"June":return "Juni";break;
			case"July":return "Juli";break;
			case"August":return "Agustus"; break;
			case"September":return "September"; break;
			case"October":return "Oktober"; break;
			case"November":return "November"; break;
			case"Descember":return "Desember"; break;
			case"Jan":return "Januari";break;
			case"Feb":return "Februari";break;
			case"Mar":return "Maret";break;
			case"Apr":return "April";break;
			case"May":return "Mei";break;
			case"Jun":return "Juni";break;
			case"Jul":return "Juli";break;
			case"Aug":return "Agustus"; break;
			case"Sep":return "September"; break;
			case"Oct":return "Oktober"; break;
			case"Nov":return "November"; break;
			case"Dec":return "Desember"; break;
			default:return "Januari";break;
		}
	}
	
	private function getDateLang($date){
		$date = explode(" ",$date);
		$Tanggal = $date[0];
		$Bulan = $this->getMonthLang($date[1]);
		$Tahun = $date[2];
		return "$Tanggal $Bulan $Tahun";
	}
	
	/*
		/ CRETE DATE
		/ createDate return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	public function createDate($date=null){
		if(empty($date)){
			$date = date("Y-m-d H:i:s");
		}else{
			$date = date_create($date);
		}
		return $date;
	}
	
	
	/*
		/ DATE FORMAT TIME
		/ getTime return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	public function getTime($date=null){
		return date_format($this->createDate($date),"H:i:s"); //H:i:s
	}
	
	public function getTime4String($time=null){
		return date_format($this->createDate($time),"H:i");
	}
	
	/*
		/ DATE FORMAT DAY
		/ getDay return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getDay($date=null,$type=null){
		if(!empty($type)){
			return $this->getDayLang(date('l', strtotime($date)));
		}else{
			return $this->getDayLang(date('D', strtotime($date)));
		}
	}
	
	/*
		/ DATE FORMAT DATE
		/ getDate return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getDate($date=null){
		return date_format($this->createDate($date),"d");
	}
	
	/*
		/ DATE FORMAT MONTH INTEGER
		/ getMonth return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getMonth($date=null){
		return date_format($this->createDate($date),"m");
	}
	
	/*
		/ DATE FORMAT MONTH STRING
		/ getMonth4String return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getMonth4String($date=null, $type=null){
		if(!empty($type)){
			return $this->getMonthLang(date_format($this->createDate($date),"F"));
		}else{
			return $this->getMonthLang(date_format($this->createDate($date),"M"));
		}
	}
	
	/*
		/ DATE FORMAT YEAR
		/ getYear return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getYear($date=null){
		return date_format($this->createDate($date),"Y");
	}
	
	/*
		/ DATE FORMAT 4 ViEW STRING
		/ getDate4String return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getDate4String($date=null){
		return $this->getDateLang(date_format($this->createDate($date),"d M Y"));
	}
	
	/*
		/ DATE FORMAT 4 ViEW INTEGER
		/ getDate4Integer return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getDate4Integer($date=null){
		return date_format($this->createDate($date),"d-m-Y");
	}
	
	/*
		/ DATE FORMAT 4 ViEW DATABASE
		/ getDate4Integer return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 29 November 2013
	*/
	
	public function getDate4Database2($date=null){
		return date_format($this->createDate($date),"Y-m-d");
	}
	
	/*
		/ DATE FORMAT 4 ViEW DATABASE
		/ getDate4Database return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getDate4Database($date=null){
		return date_format($this->createDate($date),"Y-m-d H:i:s");
	}
	
	/*
		/ NEXT DATE
		/ getNextDate return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getNextDate($date=null){
		$dateNew = date("Y-m-d H:i:s",strtotime("+1 day", strtotime($date)));
		return $dateNew;
	}
	
	/*
		/ PREVIEW DATE
		/ getNextDate return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getPrevDate($date=null){
		$dateNew = date("Y-m-d H:i:s",strtotime("-1 day", strtotime($date)));
		return $dateNew;
	}
	
	/*
		/ INCREASE DATE
		/ getIncDate return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getIncDate($date=null,$inc){
		$dateNew = date("Y-m-d H:i:s",strtotime("+".$inc." day", strtotime($date)));
		return $dateNew;
	}
	
	/*
		/ DESCEND DATE
		/ getIncDate return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getDescDate($date=null,$desc){
		$dateNew = date("Y-m-d H:i:s",strtotime("-".$desc." day", strtotime($date)));
		return $dateNew;
	}
	
	/*
		/ NEXT MONTH
		/ getNextMonth return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getNextMonth($date=null){
		$dateNew = date("Y-m-d H:i:s",strtotime("+1 month", strtotime($date)));
		return $dateNew;
	}
	
	/*
		/ PREVIEW DATE
		/ getNextDate return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getPrevMonth($date=null){
		$dateNew = date("Y-m-d H:i:s",strtotime("-1 month", strtotime($date)));
		return $dateNew;
	}
	
	/*
		/ INCREASE MONTH
		/ getIncMonth return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getIncMonth($date=null,$inc){
		$dateNew = date("Y-m-d H:i:s",strtotime("+".$inc." month", strtotime($date)));
		return $dateNew;
	}
	
	/*
		/ DESCEND MONTH
		/ getIncDate return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getDescMonth($date=null,$desc){
		$dateNew = date("Y-m-d H:i:s",strtotime("-".$desc." month", strtotime($date)));
		return $dateNew;
	}
	
	/*
		/ NEXT WEEK
		/ getNextWeek return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getNextWeek($date=null){
		$dateNew = date("Y-m-d H:i:s",strtotime("+1 week", strtotime($date)));
		return $dateNew;
	}
	
	/*
		/ PREVIEW WEEK
		/ getNextWeek return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getPrevWeek($date=null){
		$dateNew = date("Y-m-d H:i:s",strtotime("-1 week", strtotime($date)));
		return $dateNew;
	}
	
	/*
		/ INCREASE WEEK
		/ getIncWeek return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getIncWeek($date=null,$inc){
		$dateNew = date("Y-m-d H:i:s",strtotime("+".$inc." week", strtotime($date)));
		return $dateNew;
	}
	
	/*
		/ DESCEND WEEK
		/ getIncWeek return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 07 Oktober 2013
	*/
	
	public function getDescWeek($date=null,$desc){
		$dateNew = date("Y-m-d H:i:s",strtotime("-".$desc." week", strtotime($date)));
		return $dateNew;
	}
	
	/*
		/ PREVIEW START TIME
		/ getStartTime return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 19 November 2013
	*/
	
	public function getStartTime($date=null){
		$dateNew = new DateTime($date);
		$dateNew->setTime(0,0);
		$dateNew = date_format($dateNew,"Y-m-d H:i:s");
		return $dateNew;
	}
	
	/*
		/ PREVIEW END TIME
		/ getEndTime return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 19 November 2013
	*/
	
	public function getEndTime($date=null){
		$dateNew = new DateTime($date);
		$dateNew->setTime(24,59);
		$dateNew = date_format($dateNew,"Y-m-d H:i:s");
		return $dateNew;
	}
	
	/*
		/ PREVIEW COUNT LONG FROM BEGIN DATE AND END DATE
		/ countDate return as component string
		/ Author : Heri Siswanto Bayu Nugroho
		/ Create : 2 Januari 2014
	*/
	
	public function countDate($beginDate=null,$endDate){
		$timeDiff = abs($endDate - $beginDate);
		$numberDays = $timeDiff/86400;  // 86400 seconds in one day

		$numberDays = ceil($numberDays);
		return $numberDays;
	}
}
?>