<?php

 /*
 * Class: QueryToDb
 *
 * All query to DB
 */

class QueryToDb
{
	private $myPdoObj;

	public function __construct()
	{
		$this->myPdoObj = MyPdo::getInstance();
	}

 /*
 * Select id, mail, password, key, name, role from employee
 *
 * @param name: name of user
 * @return: array
 */
	public function getUserAllDataByName($name)
	{
		$result = $this->myPdoObj
			->select('id_employee, mail_employee, passwd_employee,
			 key_employee, name_employee, role')
			->table('employee')
			->where(array('mail_employee' => $name), array('='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Set generate code for cookie session
 *
 * @param name: name of user
 * @param name: generate code of user
 * @return: boolean
 */
	public function setUserCodeCookie($name, $code_employee)
	{
		$result = $this->myPdoObj
			->update()
			->table('employee')
			->set(array('code_employee' => $code_employee))
			->where(array('mail_employee' => $name), array('='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Select id, mail, password, name, role from employee by code
 *
 * @param code_user: code in cookie must equals code in DB
 * @return: array
 */
	public function getUserAllDataByCode($code_user)
	{
	$result = $this->myPdoObj
		->select('id_employee, mail_employee, key_employee,
		 name_employee,	role')
		->table('employee')
		->where(array('code_employee' => $code_user), array('='))
		->query()
		->commit();

	return $result;
	}

 /*
 * Select all  id, mail, name from employee
 *
 * @return: array
 */
	public function getEmployeeList()
	{
		$result = $this->myPdoObj
			->select('id_employee, mail_employee, name_employee')
			->table('employee')
			->where(array('status' => '0'), array('!='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Set flag deleted employee by id
 *
 * @return: boolean
 */
	public function setDeleteEmployee($id_employee)
	{
		$result = $this->myPdoObj
			->update()
			->table('employee')
			->set(array('status'=> 0, 'mail_employee' => ''))
			->where(array('id_employee' => $id_employee), array('='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Delete event selected user
 *
 * @param id_employee: id_employee deleted employee
 * @param time: begin time for event deleted employee
 * @return: array
 */
	public function deleteAppointmentsCurrentEmployee($id_employee, $time)
	{
		$result = $this->myPdoObj
			->delete()
			->table('appointments')
			->where(array('id_employee' => $id_employee, 'start' => $time),
				array('=', '>='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Select employee by new e-mail
 *
 * @param email: e-mail new employee
 * @return: array
 */
	public function getEmployeeForCheckExists($email)
	{
		$result = $this->myPdoObj
			->select('name_employee, mail_employee')
			->table('employee')
			->where(array('mail_employee' => $email), array('='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Insert new employee to DB
 *
 * @param name: name new employee
 * @param pass: password new employee
 * @param key_employee: unique key new employee
 * @param email: e-mail new employee
 * @return: boolean
 */
	public function setNewEmployee($name, $pass, $email, $key_employee)
	{
		$result = $this->myPdoObj
			->insert()
			->table("employee SET name_employee = '$name',
			 passwd_employee = '$pass', mail_employee = '$email',
			 key_employee = '$key_employee'")
			->query()
			->commit();

		return $result;
	}

 /*
 * Update selected employee data
 *
 * @param array: array of data to commit change, can be password, e-mail, name
 * @param id_employee: id selected employee
 * @return: boolean
 */
	public function setEmployeeNewData($array, $id_employee)
	{
		$result = $this->myPdoObj
			->update()
			->table("employee")
			->set($array)
			->where(array('id_employee' => $id_employee), array('='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Select e-mail and name from employee
 *
 * @param id_employee: id selected employee
 * @return: array
 */
	public function getEmployeeById($id_employee)
	{
		$result = $this->myPdoObj
			->select('mail_employee, name_employee, id_employee')
			->table('employee')
			->where(array('id_employee' => $id_employee), array('='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Select number of room choise in config file
 *
 * @return: array
 */
	public function getCalendarRoomList()
	{
		$result = $this->myPdoObj
			->select('id_room, name_room')
			->table('rooms')
			->limit(START_ROOM, END_ROOM)
			->query()
			->commit();

		return $result;
	}

 /*
 * Select all appointments of current room
 *
 * @return: array
 */
	public function getCalendarAppointmentsSelectedMonth($first, $last, $room)
	{
		$result = $this->myPdoObj->select('id_appointment, description,
		id_employee, start, end, id_room, recursion, submitted')
			->table('appointments')
			->where(array('start' => $first,
						  'end'=> $last,
						  'id_room'=> $room),
				array('>=','<=','='))
			->order('start ASC')
			->query()
			->commit();

		return $result;
	}

 /*
 * Select all active employee
 *
 * @return: array
 */
	public function getCalendarListEmployee()
	{
		$result = $this->myPdoObj->select('name_employee, id_employee')
			->table('employee')
			->where(array('name_employee' => 'root', 'status' => '0'),
				array('!=', '!='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Select event selected day and room
 *
 * @param startDay: begin current day
 * @param endDay: end current day
 * @param room: selected room
 * @return: array
 */
	public function getEventSelectedDayAndRoom($startDay, $endDay, $room)
	{
		$result = $this->myPdoObj->select('id_appointment, description,
		id_employee, start, end, id_room, recursion, submitted')
			->table('appointments')
			->where(array('start' => $startDay,
						  'end'=> $endDay, 'id_room'=> $room),
				array('>=','<=','='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Add event without recurr.
 *
 * @param description: description
 * @param employee: selected employee
 * @param start: start time
 * @param end: end time
 * @param room: selected room
 * @return: boolean
 */
	public function setEvent($description, $employee, $start, $end, $room)
	{
		$result = $this->myPdoObj->insert()
			->table("appointments")
			->set(array('description'=>$description, 'id_employee'=> $employee,
						'start'=>$start, 'end'=>$end,
						'id_room'=>$room,	'recursion'=>'0'))
			->query()
			->commit();

		return $result;
	}

 /*
 * Add event with recurr.
 *
 * @param description: description
 * @param employee: selected employee
 * @param start: start time
 * @param end: end time
 * @param room: selected room
 * @param id: unique id recurr
 * @return: boolean
 */
	public function setEventWithRecur($description, $employee,
									  $start, $end, $room, $id)
	{
		$result = $this->myPdoObj->insert()
			->table("appointments")
			->set(array('description'=>$description, 'id_employee'=> $employee,
						'start'=>$start, 'end'=>$end,
						'id_room'=>$room,	'recursion'=>$id))
			->query()
			->commit();

		return $result;
	}

 /*
 * Get last inserting id
 *
 * @return: integer
 */
	public function getLastId()
	{
		return $this->myPdoObj->lastId;
	}

 /*
 * Set id recurr into first event
 *
 * @return: boolean
 */
	public function setParentRecur($id)
	{
		$result = $this->myPdoObj->update()
			->table("appointments")
			->set(array('recursion'=> $id))
			->where(array('id_appointment'=>$id), array('='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Get event by id
 *
 * @param id: recurr id
 * @return: array
 */
	public function getEventById($id)
	{
		$result = $this->myPdoObj->select('id_appointment, description,
		id_employee, start, end, id_room, recursion, submitted')
			->table('appointments')
			->where(array('id_appointment' => $id), array('='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Get employee list without root
 *
 * @return: array
 */
	public function getEmployeeListExeptRoot()
	{
		$result = $this->myPdoObj->select('name_employee, id_employee')
			->table('employee')
			->where(array('name_employee' => 'root', 'status' => '0'),
				array('!=', '!='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Delete event without recurr
 *
 * @param id: current id of event
 * @param currentTime: current timestamp
 * @return: boolean
 */
	public function deleteEventNoRecur($id,$currentTime)
	{
		$result = $this->myPdoObj->delete()
			->table('appointments')
			->where(array('id_appointment' => $id,
						  'start' => $currentTime), array('=', '>='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Delete event with recurr
 *
 * @param recur: current id of recurr
 * @param currentTime: current timestamp
 * @return: boolean
 */
	public function deleteEventWithRecur($recur,$currentTime)
	{
		$result = $this->myPdoObj->delete()
			->table('appointments')
			->where(array('recursion'=>$recur,
					'start'=>$currentTime, 
					'id_employee' => '$id'),array('=','>=', '='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Get all event of current day
 *
 * @param startDay: start timestamp of current day
 * @param endDay: end timestamp of current day
 * @param id: id details event
 * @param room: current room
 * @return: array
 */
	public function getEventFromDay($startDay, $endDay, $id, $room)
	{
		$result = $this->myPdoObj->select('id_appointment, description,
		id_employee, start, end, id_room, recursion, submitted')
			->table('appointments')
			->where(array('start' => $startDay,
						  'end' => $endDay,
						  'id_appointment' => $id,
						  'id_room' => $room),
				array('>=', '<=', '!=', '='))
			->query()
			->commit();

		return $result;
	}

 /*
 * Set new data in editing event without recurr
 *
 * @param start: new start timestamp
 * @param end: new end timestamp
 * @param id_a: id details event
 * @param desc: new description
 * @param id_e: current employee
 * @return: boolean
 */
	public function setNewDataInEventNoRecur($desc, $id_e, $start, $end, $id_a)
	{
		$this->myPdoObj->update()->table("appointments")
			->set(array('description' => $desc,
						'id_employee' => $id_e,
						'start' => $start,
						'end' => $end,
						'recursion' => '0'))
			->where(array('id_appointment' => $id_a),
				array('='))
			->query()
			->commit();
	}

 /*
 * Set new data in editing event with recurr
 *
 * @param start: new start timestamp
 * @param end: new end timestamp
 * @param id_a: id details event
 * @param desc: new description
 * @param id_e: current employee
 * @return: boolean
 */
	public function setNewDataInEvent($desc, $id_e, $start, $end, $id_a)
	{
		$this->myPdoObj->update()->table("appointments")
			->set(array('description' => $desc,
						'id_employee' => $id_e,
						'start' => $start,
						'end' => $end))
			->where(array('id_appointment' => $id_a),
				array('='))
			->query()
			->commit();
	}

 /*
 * Get all events of current recurr
 *
 * @param recur: number of current recurr
 * @return: array
 */
	public function getAllEvents($recur)
	{
		$result = $this->myPdoObj->select('id_appointment, description,
		id_employee, start, end, id_room, recursion, submitted')
			->table('appointments')
			->where(array('recursion' => $recur), array('='))
			->query()
			->commit();

		return $result;
	}
}
?>