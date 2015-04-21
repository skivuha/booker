<?php
class Event
{
	private $data;
	private $error;
	private $id;
	private $dArray;
	private $userRole;
	private $recurent;


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
					else
					{
						$this->error['ERROR_DATA'] ='Sorry, this time alredy busy!';
					}
				}
			}
			else
			{
				$this->error['ERROR_DATA'] ='Wrong date!';
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
				return true;
			}
			else
			{
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
					$selectedMonth + $period*$i, $selectedDay + $interval*$i, $selectedYear);
				$endTime[$i] = mktime($selectedEndHour, $selectedEndMinute, 0,
					$selectedMonth + $period*$i, $selectedDay + $interval*$i,
					$selectedYear);
				$startDay = mktime(0, 0, 0, $selectedMonth + $period*$i,
					$selectedDay + $interval*$i, $selectedYear);
				$endDay = mktime(23, 59, 59, $selectedMonth + $period*$i,
					$selectedDay + $interval*$i, $selectedYear);

				if(6 == date('w', $startTime[$i]))
				{
					$startTime[$i] = mktime($selectedStartHour, $selectedStartMinute, 0,
						$selectedMonth + $period*$i, $selectedDay + 2, $selectedYear);
					$endTime[$i] = mktime($selectedEndHour, $selectedEndMinute, 0,
						$selectedMonth + $period*$i, $selectedDay + 2, $selectedYear);
					$startDay = mktime(0, 0, 0, $selectedMonth + $period*$i,
						$selectedDay + 2, $selectedYear);
					$endDay = mktime(23, 59, 59, $selectedMonth + $period*$i,
						$selectedDay + 2, $selectedYear);
				}elseif(0 == date('w', $startTime[$i]))
				{
					$startTime[$i] = mktime($selectedStartHour, $selectedStartMinute, 0,
						$selectedMonth + 1*$i, $selectedDay + 1, $selectedYear);
					$endTime[$i] = mktime($selectedEndHour, $selectedEndMinute, 0,
						$selectedMonth + 1*$i, $selectedDay + 1, $selectedYear);

					$startDay = mktime(0, 0, 0, $selectedMonth + $period*$i,
						$selectedDay + 1, $selectedYear);
					$endDay = mktime(23, 59, 59, $selectedMonth + $period*$i,
						$selectedDay + 1, $selectedYear);
				}



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
					else
					{
						$this->error['ERROR_DATA'] ='Wrong date!';
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
					$this->error['ERROR_DATA'] ='Wrong time on '.$i.' recursion!';
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
		return $this->error;
	}



	public function detailsEvent()
	{
		$myPdo = MyPdo::getInstance();
		$id_appointment = $this->data;
		$currentEvent = $myPdo->select('*')
			->table('appointments')
			->where(array('id_appointment' => $id_appointment),
				array('='))
			->query()
			->commit();

		$name_employee = $myPdo->select('name_employee')
			->table('employee')
			->where(array('id_employee' => $currentEvent[0]['id_employee']),
				array('='))
			->query()
			->commit();

		$startTime = date('H', $currentEvent[0]['start']).
		':'.date('i', $currentEvent[0]['start']);

		$endTime = date('H', $currentEvent[0]['end']).
			':'.date('i', $currentEvent[0]['end']);

		$currentTime = time();

		if(0 == $currentEvent[0]['recursion']){
			$this->dArray['RECURRENCE'] = 'style="display: none;"';
		}
		else
		{
			$this->dArray['RECURRENCE'] = '';
			$this->dArray['RECURID'] = $currentEvent[0]['recursion'];

		}
		$this->dArray['EMPLOYEEID'] = $currentEvent[0]['id_employee'];
		$this->dArray['START'] = $currentEvent[0]['start'];
		$this->dArray['TITLE'] = $startTime.' - '. $endTime;
		$this->dArray['STARTTIME'] = $startTime;
		$this->dArray['ENDTIME'] = $endTime;
		$this->dArray['WHO'] = '<option>'.$name_employee[0]['name_employee'].'</option>';
		$this->dArray['NOTES'] = $currentEvent[0]['description'];
		$this->dArray['SUBMITTED'] = $currentEvent[0]['submitted'];
		$this->dArray['ID'] = $id_appointment;
		if($currentTime > $currentEvent[0]['start'])
		{
			$this->dArray['ACTIVE'] = 'disabled';
		}
		else
		{
			$this->dArray['ACTIVE'] = '';
		}

		return $this->dArray;
	}

	public function deleteEvent()
	{
		$currentTime = time();
		$myPdo = MyPdo::getInstance();
		$id_appointment = $this->data;
		if(!isset($this->recurent))
		{
			$rez = $myPdo->delete()
				->table('appointments')
				->where(array('id_appointment'=>$id_appointment, 'start'=>$currentTime)
				,array('=', '>='))
				->query()
				->commit();
			return $rez;
		}
		else
		{
			/*$allRecurEvent = $myPdo->select('id_appointment')
				->table('appointments')
				->where(array('recursion' => $this->recurent, 'start' => $currentTime),
					array('=', '>='))
				->query()
				->commit();
			foreach($allRecurEvent as $value)
			{
				$myPdo->delete()
					->table('appointments')
					->where(array('id_appointment'=>$value['id_appointment']),array('='))
					->query()
					->commit();
			}
			return true;*/
			$myPdo->delete()
				->table('appointments')
				->where(array('recursion'=>$this->recurent,
											'start'=>$currentTime),array('=','>='))
				->query()
				->commit();

		return true;
		}
	}

	public function updateEvent()
	{
		$currentTime = time();
		$myPdo = MyPdo::getInstance();
		$updateData = $this->data;
		if(!isset($this->recurent))
		{
			$currentDay = $updateData['start'];
			$day = date('j', $currentDay);
			$mon = date('m', $currentDay);
			$year = date('Y', $currentDay);

			$arrayStartTime = explode(':', $updateData['starttime']);
			$arrayEndTime = explode(':', $updateData['endtime']);


			$startTimeUpdate = mktime($arrayStartTime[0], $arrayStartTime[1], 0, $mon, $day, $year);
			$endTimeUpdate = mktime($arrayEndTime[0], $arrayEndTime[1], 0, $mon, $day, $year);
			$startDay = mktime(0, 0, 0, $mon, $day, $year);
			$endDay = mktime(23, 59, 59, $mon, $day, $year);

			$check = $myPdo->select('*')
				->table('appointments')
				->where(array('start' => $startDay, 'end' => $endDay,
						'id_appointment'=>$updateData['update']),
					array('>=', '<=', '!='))
				->query()
				->commit();
			if (isset($check))
			{
				$cnt = 0;
				foreach ($check as $key => $value)
				{
					if ($value['end'] <= $startTimeUpdate || $value['start'] >= $endTimeUpdate)
					{
						$cnt ++;
					}
				}
			}

			if (count($check) != $cnt)
			{
				$this->error['ERROR_DATA'] = 'Sorry, this time alredy busy!';
			}
			else
			{
				if ($currentTime < $startTimeUpdate && $currentTime < $currentDay && $startTimeUpdate < $endTimeUpdate)
				{
					$myPdo->update()->table("appointments")
						->set(array('description' => $updateData['description'],
												'id_employee' => $updateData['empl'],
												'start' => $startTimeUpdate,
												'end' => $endTimeUpdate))
						->where(array('id_appointment' => $updateData['update']),
							array('='))
						->query()
						->commit();

					return true;
				}
				else
				{
					$this->error['ERROR_DATA'] = 'Wrong date!';
				}
			}
		}
		return $this->error;
	}




	public function setRecurent($var)
	{
		$this->recurent = $var;
	}

	public function userRole($var)
	{
		$this->userRole = $var;
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