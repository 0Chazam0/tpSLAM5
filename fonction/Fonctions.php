<?php
public static function fixObj(&$obj){
  if(!is_object($obj) && gettype($obj)=='object'){
    return ($obj = unserialize(serialize($obj)));
  }
  return $obj;
}
?>
