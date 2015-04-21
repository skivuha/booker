<?php

/**
 * Class: Validator
 *
 */
class Validator
{
  private $value;

  public function __construct()
  {
  }

  public function clearData($data)
  {
    if (is_array($data)) {
      return $this->clearDataArr($data);
    } else {
      $data = trim(strip_tags($data));
      return $data;
    }
  }

  public function clearDataArr(array $arr)
  {
    if (!empty($arr) && is_array($arr)) {
      foreach ($arr as $key => $value) {
        $data[$key] = $this->clearData($value);
      }
      return $data;
    } else {
      return false;
    }
  }

  public function checkForm($val)
  {
    $this->value = '';
    $val = $this->clearData($val);
    if (!preg_match("/^[a-zA-Z0-9]*$/", $val)) {
      return false;
    } else {
      return true;
    }
  }

  public function checkPass($val)
  {
    $this->value = '';
    $val = $this->clearData($val);
    if (!preg_match("/^[a-zA-Z0-9_-]{6,18}$/", $val)) {
      return false;
    } else {
      return true;
    }
  }

  public function numCheck($val)
  {
      return $this->value = abs((int)($val));
  }

  public function getValue()
  {
    return $this->value;
  }

  public function checkEmail($val)
  {
    $this->value = '';
    $val = $this->clearData($val);
    if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
      return false;
    } else {
      return true;
    }
  }

}

?>
