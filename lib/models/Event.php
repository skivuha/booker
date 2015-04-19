<?php
class Event
{
	private $data;
	private $error;
	private $id;

	public function checkDateNoRecursion()
	{
		$employee = $this->data['employeename'];
		$selectedDay = (int)$this->data['selectedday'];
		$selectedMonth = ((int)$this->data['selectedmonth'])+1;
		$selectedYear = (int)$this->data['selectedyear'];
		$selectedStartHour = (int)$this->data['starthour'];
		$selectedStartMinute = (int)$this->data['startmin'];
		$selectedEndHour = (int)$this->data['endhour'];
		$selectedEndMinute = (int)$this->data['endmin'];
		$description = $this->data['desc'];

		$currentTime = time();
		$startTime = mktime($selectedStartHour, $selectedStartMinute, 0,
			$selectedMonth, $selectedDay, $selectedYear);
		$endTime = mktime($selectedEndHour, $selectedEndMinute, 0,
			$selectedMonth, $selectedDay, $selectedYear);
		$startDay = mktime(0, 0, 0,
			$selectedMonth, $selectedDay, $selectedYear);
		$endDay = mktime(23, 59, 59,
			$selectedMonth, $selectedDay, $selectedYear);

		$session = Session::getInstance();
		$room = $session->getSession('room');

		$myPdo = MyPdo::getInstance();
		$eventCurrentDay = $myPdo->select('*')
			->table('appointments')
			->where(array('start' => $startDay,
				'end'=> $endDay, 'id_room'=> $room),
				array('>=','<=','='))
			->query()
			->commit();

	if(empty($eventCurrentDay))
	{
		if($endTime > $startTime
			&& $currentTime < $startTime
			&& $startTime != $endTime)
		{
			 $arr = $myPdo->insert()
				->table("appointments")
				->set(array('description'=>$description, 'id_employee'=> $employee,
					'start'=>$startTime, 'end'=>$endTime,
						'id_room'=>$room,	'recursion'=>'0'))
				->query()
				->commit();
			return $arr;
		}
		else
		{
			$this->error['ERROR_DATA'] ='Wrong date!';
			return $this->error;
		}
	}
		else
		{
			$cnt = 0;
			if ($endTime > $startTime
				&& $currentTime < $startTime
				&& $startTime != $endTime)
			{
				foreach ($eventCurrentDay as $key => $value)
				{
					if($value['end'] <= $startTime || $value['start'] >= $endTime)
					{
						$cnt++;
					}
				}
			}
			if(count($eventCurrentDay) == $cnt)
			{
				$arr = $myPdo->insert()
					->table("appointments")
					->set(array('description'=>$description, 'id_employee'=> $employee,
											'start'=>$startTime, 'end'=>$endTime,
											'id_room'=>$room,	'recursion'=>'0'))
					->query()
					->commit();
				return $arr;
			}
			else
			{
				$this->error['ERROR_INTERVAL'] ='Sorry, this time alredy busy!';
				return $this->error;
			}
		}
	}

	public function checkDateRecursion()
	{
		$duration = (int)$this->data['duration'];
		$employee = $this->data['employeename'];
		$selectedDay = (int)$this->data['selectedday'];
		$selectedMonth = ((int)$this->data['selectedmonth']) + 1;
		$selectedYear = (int)$this->data['selectedyear'];
		$selectedStartHour = (int)$this->data['starthour'];
		$selectedStartMinute = (int)$this->data['startmin'];
		$selectedEndHour = (int)$this->data['endhour'];
		$selectedEndMinute = (int)$this->data['endmin'];
		$description = $this->data['desc'];
		$currentTime = time();
		$session = Session::getInstance();
		$room = $session->getSession('room');

		$myPdo = MyPdo::getInstance();
		if('weekly' == $this->data['recuring']
			|| 'bi-weekly' == $this->data['recuring']
			|| 'monthly' == $this->data['recuring'])
		{
			if('weekly' == $this->data['recuring'])
			{
				$interval = 7;
				$period = 0;
			}
			else
			{
				$interval = 14;
				$period = 0;
			}
			if('monthly' == $this->data['recuring'])
			{
				$interval = 0;
				$period = 1;
			}
			for($i = 0; $i <= $duration; $i++)
			{
				$startTime[$i] = mktime($selectedStartHour, $selectedStartMinute, 0,
					$selectedMonth + 1*$i, $selectedDay + $interval*$i, $selectedYear);
				$endTime[$i] = mktime($selectedEndHour, $selectedEndMinute, 0,
					$selectedMonth + 1*$i, $selectedDay + $interval*$i,
					$selectedYear);
				$startDay = mktime(0, 0, 0, $selectedMonth + $period*$i,
					$selectedDay + $interval*$i, $selectedYear);
				$endDay = mktime(23, 59, 59, $selectedMonth + $period*$i,
					$selectedDay + $interval*$i, $selectedYear);



				$eventCurrentDay = $myPdo->select('*')
					->table('appointments')
					->where(array('start' => $startDay,
												'end' => $endDay,
												'id_room' => $room),
						array('>=', '<=', '='))
					->query()
					->commit();

				$cnt = 0;
				if(!empty($eventCurrentDay))
				{
					if ($endTime[$i] > $startTime[$i]
						&& $currentTime < $startTime[$i]
						&& $startTime[$i] != $endTime[$i])
					{
						foreach ($eventCurrentDay as $key => $value)
						{
							if ($value['end'] <= $startTime[$i]
								|| $value['start'] >= $endTime[$i])
							{
								$cnt ++;
							}
						}
					}
				}
				else
				{
					if ($endTime[$i] < $startTime[$i]
						|| $currentTime > $startTime[$i]
						|| $startTime[$i] == $endTime[$i])
					{
						$cnt++;
					}
				}
				if(count($eventCurrentDay) != $cnt)
				{
					$i++;
					$this->error['ERROR_INTERVAL'] =
						'Wrong time on '.$i.' recursion!';
				}
			}

			$this->id = 0;
			if(empty($this->error))
			{
			for($i = 0; $i <= $duration; $i++)
			{
				$myPdo->insert()
					->table("appointments")
					->set(array('description' => $description,
											'id_employee' => $employee,
											'start' => $startTime[$i],
											'end' => $endTime[$i],
											'id_room' => $room,
											'recursion' => $this->id))
					->query()
					->commit();
				if(0 == $i)
				{
					$this->id = $myPdo->lastId;
				}
			}
				 $myPdo->update()
					->table("appointments")
					->set(array('recursion'=> $this->id))
					->where(array('id_appointment'=>$this->id), array('='))
					->query()
					->commit();
				return true;
			}
		}

	}









	public function setData($var)
	{
		$this->data = $var;
	}

	public function setRoom($var)
	{
		$this->room = $var;
	}
}
?>