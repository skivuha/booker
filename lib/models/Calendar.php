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
	private $nameMonth;
	
	private function getCurrentData()
	{
		$this->currentDay = date('d');
		$this->currentMonth = date('n');
		$this->currentYear = date('Y');
	}

	public function getNewData($var)
	{
		if(true === $var)
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
		$selectedMonth = mktime(0,0,0, $this->newMonth,1,$this->newYear);
		$this->nameMonth = (date('F', $selectedMonth));
		$this->subYear = $this->newYear;
		$this->subMonth = $this->newMonth -1;
		if(0 >= $this->subMonth)
		{
			$this->subYear = $this->subYear - 1;
			$this->subMonth = 12;
		}
		$this->nextMonth = $this->newMonth + 1;
		$this->nextYear = $this->newYear;
		if ($this->nextMonth > 12)
		{
			$this->nextYear = $this->nextYear +1;
			$this->nextMonth = 1;
		}
	}
	
	public function getCalendar()
	{
		$day_count = 1;
		$this->dayofmonth = date('t', mktime(0, 0, 0, $this->newMonth, date('d'),
			$this->newYear));
		for($j=1; $j<=6; $j++)
		{
			for ($i = 1; $i <= 7; $i ++)
			{
				$dayOfWeek = date('N', mktime(0, 0, 0, $this->newMonth, $day_count,
					$this->newYear));
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
		$this->getNewData(true);
		$var = $this->getCalendar();
		$data = '';
		foreach($var as $key=>$val)
		{
			$data .= '<tr>';
			foreach($val as $key2=>$value)
			{
				if(!empty($value))
				{
					if (6 == $key2 || 7 == $key2)
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

		$da['LOWER'] = 'year/'.$this->subYear.'/month/'.$this->subMonth;
		$da['HIGHER'] = 'year/'.$this->nextYear.'/month/'.$this->nextMonth;
		$da['CURRENT'] = $this->nameMonth. - $this->currentYear;
		$da['CONTENT'] = $data;
	return $da;
	}
	
	
}
?>