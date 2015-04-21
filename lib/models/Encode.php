<?php
/**
 * Class: Encode
 *
 */
class Encode
{
  public function generateCode($var) {
    if(is_string($var) || is_int($var))
    {
        $var = md5($var).SALT;
        $shifr = "";
        $clen = strlen($var) - 1;
        while (strlen($shifr) < 10) {
            $shifr .= $var[mt_rand(0,$clen)];
        }
        return $shifr;
    }
    else
    {
      return false;
    }
    }
}
?>
