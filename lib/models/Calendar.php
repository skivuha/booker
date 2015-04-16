<?php
class Calendar
{
	private $currentMonth;
	private $newMonth;
	private $currentYear;
	private $newYear;
	private $currentDay;
	private $countDayOfCurrentMonth;
	private $nextMonth;
	private $nextYear;
	private $subMonth;
	private $subYear;
	private $startDay;
	private $flagParams;
	private $saturday;
	private $sunday;
	private $headTable;
	private $disable;
	private $calendar;
	private $firstDayTimeStampChoiseMonth;
	private $lastDayTimeStampChoiseMonth;
	private $currentDayTimeStamp;

	public function setFirstDay($var)
	{
		$this->startDay = $var;
	}

	private function getCurrentData()
	{
		$this->currentDay = date('d');
		$this->currentMonth = date('n');
		$this->currentYear = date('Y');
	}

	private function getNewData()
	{
		$this->getCurrentData();
		if(true === $this->flagParams)
		{
			$data = Router::getInstance();
			$getParam = $data->getParams();
			$this->newMonth = abs((int)$getParam['month']);
			$this->newYear = abs((int)$getParam['year']);
		}
		else
		{
			$this->newMonth = $this->currentMonth;
			$this->newYear = $this->currentYear;
		}
		$this->subYear = $this->newYear;
		$this->subMonth = $this->newMonth - 1;
		if(0 >= $this->subMonth)
		{
			$this->subYear = $this->subYear - 1;
			$this->subMonth = 12;
		}
		$this->nextMonth = $this->newMonth + 1;
		$this->nextYear = $this->newYear;
		if ($this->nextMonth > 12)
		{
			$this->nextYear = $this->nextYear + 1;
			$this->nextMonth = 1;
		}
	}

	private function getTimeStamp()
	{
		$this->countDayOfCurrentMonth = date('t',
			strtotime($this->newYear.'-'.$this->newMonth));
		$this->firstDayTimeStampChoiseMonth = mktime(0, 0, 0, $this->newMonth, 1,
			$this->newYear);
		$this->lastDayTimeStampChoiseMonth = mktime(23, 59, 59, $this->newMonth,
			$this->countDayOfCurrentMonth, $this->newYear);
		$this->currentDayTimeStamp = time();
	}

	private function getCalendar()
	{
		$this->getNewData();
		$this->getTimeStamp();
		$day_count = 0;
		for($j=1; $j<=6; $j++)
		{
			for ($i = 0; $i < 7; $i++) {
				$dayOfWeek = date('w', mktime(0, 0, 0, $this->newMonth, $day_count,
					$this->newYear));
				$this->saturday = 6;
				$this->sunday = 0;
				$this->disable = false;
				$this->headTable = array(0,1,2,3,4,5,6);
				if('monday' === $this->startDay)
				{
					$this->disable = true;
					$this->saturday = 5;
					$this->sunday = 6;
					$this->headTable = array(1,2,3,4,5,6,0);
					$dayOfWeek = $dayOfWeek - 1;
					if (- 1 == $dayOfWeek)
					{
						$dayOfWeek = 6;
					}
				}
				if ($i == $dayOfWeek && $day_count <= $this->countDayOfCurrentMonth)
				{
					$week[$j][$i] = $day_count;
					if($day_count <= $this->countDayOfCurrentMonth)
					{
						$day_count ++;
					}
				}
				else
				{
					$week[$j][$i] = '';
				}
			}
		}
	return $week;
	}

	public function printCalendar()
	{
		$var = $this->getCalendar();
		$data = $head = '';
		foreach($this->headTable as $val)
		{
			$head .= '<th>%LANG_HEAD_'.$val.'%</th>';
		}

		foreach($var as $key=>$val)
		{
			$data .= '<tr>';
			foreach($val as $key2=>$value)
			{
				if(!empty($value))
				{
						if ($this->saturday == $key2 || $this->sunday == $key2)
						{
							$data .= '<td style="color: red">' . $value . '<br>&nbsp;</td>';
						}
					else
					{
						$data .= '<td>' . $value . '<div>&nbsp;{{EVENT'.$value.'}}</div></td>';
					}
				}
				else
				{
					$data .= '<td class="active"> &nbsp;<br>&nbsp;</td>';
				}
			}
			$data.= '</tr>';
		}
		$this->getCurrentData();
		if(true === $this->disable)
		{
			$this->calendar['FIRSTDAY'] = 'sunday';
			$this->calendar['FIRSTDAYB'] = '%LANG_SUNDAY%';
		}
		else
		{
			$this->calendar['FIRSTDAY'] = 'monday';
			$this->calendar['FIRSTDAYB'] = '%LANG_MONDAY%';
		}
		$this->calendar['HEADCALENDAR'] = $head;
		$this->calendar['LOWER'] = 'year/'.$this->subYear.'/month/'
			.$this->subMonth;
		$this->calendar['HIGHER'] = 'year/'.$this->nextYear.'/month/'
			.$this->nextMonth;
		$this->calendar['CURRENT'] = '%LANG_'.$this->newMonth.'% - '
			.$this->newYear;
		$this->calendar['CONTENT'] = $data;
		$this->getAppointments();
		$this->getDataToBookIt();

	return $this->calendar;
	}

	public function setFlagParams($var)
	{
		$this->flagParams = $var;
	}

	private function getAppointments()
	{
		$myPdo = MyPdo::getInstance();
    $arr = $myPdo->select('*')
      ->table('appointments')
      ->where(array('start' => $this->firstDayTimeStampChoiseMonth,
										'end'=> $this->lastDayTimeStampChoiseMonth ),
				array('>','<'))
      ->query()
      ->commit();

      foreach($arr as $key=>$val)
      {
	 $this->calendar['EVENT'.(int)date('d',$val['start'])].= '<br><a href="'.PATH.'"
	  class="event">'.date('H', $val['start']).':'.date('i', $val['start']).'
	  - '.date('H', $val['end']).':'.date('i', $val['end']).'</a>';
	}
	}

	private function getDataToBookIt()
	{
		$session = Session::getInstance();
		$this->calendar['BOOKIT_USERNAME'] = $session->getSession('name_employee');
		$leftDayInMonth = $this->countDayOfCurrentMonth - $this->currentDay;
	}
}
?>
