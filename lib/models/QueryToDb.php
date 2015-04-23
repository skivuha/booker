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
			->where(array('name_employee' => $name), array('='))
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
			->query()
			->commit();

		return $result;
	}

 /*
 * Delete selected employee by id
 *
 * @return: boolean
 */
	public function deleteEmployee($id_employee)
	{
		$result = $this->myPdoObj
			->delete()
			->table('employee')
			->where(array('id_employee' => $id_employee), array('='))
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
			->select('mail_employee, name_employee')
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

}
?>