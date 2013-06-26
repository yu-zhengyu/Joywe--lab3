<?php
class DateT{
	public $year;
    public $month;
    public $day;
    public $hour;

	public function __construct($y,$m,$d,$h) {
		$this->year = $y;
        $this->month = $m;
        $this->day = $d;
        $this->hour = $h;
	}
	
	public function isLess( $y,$m,$d,$h) {
        if( $this->year>=$y && $this->month>=$m && $this->day>=$d && $this->hour>=$h) {
            return true;
        }
    }
    public function isMore( $y,$m,$d,$h) {
        if( $this->year<=$y && $this->month<=$m && $this->day<=$d && $this->hour<=$h) {
            return true;
        }
    }
}
?>