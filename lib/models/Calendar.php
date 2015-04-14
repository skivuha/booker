<?php
class Calendar
{
	private $dayofmonth;
	private $currentMonth;
	private $newMonth;
	private $currentYear;
	private $newYear;
	private $currentDay;
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
	
	public function getCalendar()
	{
		$this->getNewData();
		$day_count = 0;
		$this->dayofmonth = date('t', mktime(0, 0, 0, $this->newMonth, date('d'),
			$this->newYear));
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
				if ($i == $dayOfWeek && $day_count <= $this->dayofmonth)
				{
					$week[$j][$i] = $day_count;
					if($day_count <= $this->dayofmonth)
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
						$data .= '<td>' . $value . '<br>&nbsp;{{EVENT_
'.$value.'}}</td>';
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
			$calendar['DISABLEM'] = 'disabled="disabled"';
		}
		else
		{
			$calendar['DISABLES'] = 'disabled="disabled"';
		}
		$calendar['HEADCALENDAR'] = $head;
		$calendar['LOWER'] = 'year/'.$this->subYear.'/month/'.$this->subMonth;
		$calendar['HIGHER'] = 'year/'.$this->nextYear.'/month/'.$this->nextMonth;
		$calendar['CURRENT'] = '%LANG_'.$this->newMonth.'% - '
			.$this->newYear;
		$calendar['CONTENT'] = $data;
	return $calendar;
	}

	public function setFlagParams($var)
	{
		$this->flagParams = $var;
	}
}
?>