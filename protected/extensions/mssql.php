<?php
class mssql{
	 private $result=null;
	 private $record=null;
	 
	 public function mssqlconnect($host,$user,$pass){
	 	mssql_connect($host,$user,$pass) or die ("can't connection");
	 }
	 
	 public function mssqldb($db){
	 	mssql_select_db($db) or die ("can't database");
	 }
	 
	 public function msexecute($command){
	 	$this->result=mssql_query($command) or die(mssql_get_last_message());
	 }
	 
	public function fetchRow($command){
	 	$arr=array();
	 	$this->result=mssql_query($command) or die(mssql_get_last_message());
	 	$this->record=mssql_fetch_row($this->result);
	 	for($i=0;$i<count($this->record);$i++){
	 		$field=mssql_fetch_field($this->result,$i);
	 		$arr[$field->name]=$this->record[$i];
	 	}
	 	return $arr;
	 }
	 
	 public function fetchAll($command){
	 	$arr=array();
	 	$this->result=mssql_query($command) or die(mssql_get_last_message());
	 	while($this->record=mssql_fetch_assoc($this->result)){
	 		array_push($arr,$this->record);
	 	}
	 	return $arr;
	 }
}