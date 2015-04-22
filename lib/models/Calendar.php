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
	private $timeFormat;
	private $room;
	private $userRole;

	public function setFirstDay($var)
	{
		$this->startDay = $var;
		return true;
	}

	private function getCurrentData()
	{
		$this->currentDay = date('d');
		$this->currentMonth = date('n');
		$this->currentYear = date('Y');
	}

	public function setUserRole($var)
	{
		$this->userRole = $var;
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

		if('24h' == $this->timeFormat)
		{
			$this->timeFormat = false;
			$this->calendar['TIMEFORMAT'] = '12h';
			$this->calendar['TIMEFORMATB'] = '%LANG_12H%';
		}
		else
		{
			$this->timeFormat = true;
			$this->calendar['TIMEFORMAT'] = '24h';
			$this->calendar['TIMEFORMATB'] = '%LANG_24H%';
		}
		$session = Session::getInstance();
		$this->room = $session->getSession('room');

		//if(false === $this->userRole)
		//{
		//	$this->calendar['ADMIN'] = 'disabled';
		//}

		$this->calendar['HEADCALENDAR'] = $head;
		$this->calendar['LOWER'] = 'year/'.$this->subYear.'/month/'
			.$this->subMonth;
		$this->calendar['HIGHER'] = 'year/'.$this->nextYear.'/month/'
			.$this->nextMonth;
		$this->calendar['CURRENT'] = '%LANG_'.$this->newMonth.'% - '
			.$this->newYear;
		$this->calendar['CONTENT'] = $data;
		$this->calendar['NAME_EMPL']= $session->getSession('name_employee');
		$this->calendar['ROOM'] = $this->room;

		$this->getAppointments();
		$this->getDataToBookIt();

	return $this->calendar;
	}

	public function setFlagParams($var)
	{
		$this->flagParams = $var;
	}

	public function setTimeFormat($var)
	{
		$this->timeFormat = $var;
	}

	private function getAppointments()
	{
		$session = Session::getInstance();
		$myPdo = MyPdo::getInstance();
    $arr = $myPdo->select('*')
      ->table('appointments')
      ->where(array('start' => $this->firstDayTimeStampChoiseMonth,
										'end'=> $this->lastDayTimeStampChoiseMonth,
										'id_room'=> $this->room),
				array('>=','<=','='))
			->order('start ASC')
      ->query()
      ->commit();




      foreach($arr as $key=>$val)
      {
				if(true === $this->userRole
					|| $val['id_employee'] == $session->getSession('id_employee'))
				{
					$role = '';
				}
				else
				{
					$role = 'id = "roleC"';
				}
		$day = (int)date('d',$val['start']);
				$timeForm = 12;
		$startTime = 	date('H', $val['start']).':'.date('i', $val['start']);
				$startTimeFormat = 	date('h', $val['start']).':'.date('i',
						$val['start']);
		$endTime = date('H', $val['end']).':'.date('i', $val['end']);
				$endTimeFormat = date('h', $val['end']).':'.date('i', $val['end']);
				if(true === $this->timeFormat)
				{
					if($timeForm > $startTime)
					{
						$startTime = $startTime.'AM';
					}
					if($timeForm > $endTime)
					{
						$endTime = $endTime.'AM';
					}
					if($timeForm <= $startTime)
					{
						$startTime = $startTimeFormat.'PM';
					}
					if($timeForm <= $endTime)
					{
						$endTime = $endTimeFormat.'PM';
					}
				}

	 $this->calendar['EVENT'.$day].= '<br><a href="" name="'
		 .$val['id_appointment'].'"
	  class="event" '.$role.'>'.$startTime.' - '.$endTime.'</a>';
		}
	}

	private function getDataToBookIt()
	{
		$myPdo = MyPdo::getInstance();
		$employee = $myPdo->select('name_employee, id_employee')
			->table('employee')
			->where(array('name_employee' => 'root'), array('!='))
			->query()
			->commit();

		$session = Session::getInstance();
		if(false === $this->userRole)
		{
			$this->calendar['USER'] = '<option value="'.$session->getSession
			('id_employee').'">'.$session->getSession('name_employee').'</option>';
		}
		else
		{
			foreach($employee as $key => $value)
			{
				$this->calendar['USER'].= '<option value="'.$value['id_employee'].'">'
			.$value['name_employee'].'</option>';
			}
		}
	}
}
?>
