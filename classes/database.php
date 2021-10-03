<?php
// All the queries are dynamic (Developed by Abdul Razzaq -- ab.razzaq32@yahoo.com) 
class Database{
	//properties for connection
	public $con;
	public $db;
	public $username;
	public $password;

	public function __construct(){
		$this->open_db_con();
	}

	public function open_db_con(){
		try{
			$this->db = "blog";
			$this->username = "root";
			$this->password = "";
			$this->con = new PDO("mysql:host=localhost;dbname=$this->db",$this->username,$this->password);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}

	


	public function insert_query($tb_name,$columns,$values){
		$length = count($values);
		$valueplaceholder = "";
		//loop for value place holders
		for ($i=0; $i < $length; $i++) {
			$valueplaceholder.= $i<$length-1 ? ":val".$i."," : ":val".$i;
		}

		$cols = implode(", ", array_values($columns)); //fetch array columns names seprated by comma
		$stmt = $this->con->prepare("INSERT INTO $tb_name($cols) VALUES($valueplaceholder)");

		//loop for remove html tags, backslahses and white spaces from values and bind values to placeholders
		for ($i=0; $i < $length; $i++) { 
			// $val = htmlspecialchars(stripcslashes(trim($values[$i])));
			$val = stripcslashes(trim($values[$i]));
			$stmt->bindValue(":val".$i,$val);
		}
		$res = $stmt->execute();
		$lastid = $this->con->lastInsertId();
		return array($res,$lastid);
	}




	public function find_query($tbl_name,$id,$col=null){
		if (isset($id) AND !isset($col)) {
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name WHERE id=?");
		}elseif(isset($id) AND isset($col)){
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name WHERE $col=?");
		}else{
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name WHERE id=?");	
		}
		$stmt->execute([$id]);
		return $stmt;
	}


	public function where_query($tbl_name,$col,$opr,$val,$sep,$col2,$opr2,$val2,$ordercol,$ordersort,$limit){
		if ($sep=="" AND $limit=="") {
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name WHERE $col $opr ? ORDER BY $ordercol $ordersort");
			$stmt->execute([$val]);
			return $stmt;
			
		}
		elseif($sep!="" AND $limit==""){
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name WHERE $col $opr ? $sep $col2 $opr2 ? ORDER BY $ordercol $ordersort");
			$stmt->execute([$val,$val2]);
			return $stmt;
		}
		elseif($sep=="" AND $limit!=""){
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name WHERE $col $opr ?  ORDER BY $ordercol $ordersort LIMIT $limit");
			$stmt->execute([$val]);
			return $stmt;
		}
		else{
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name WHERE $col $opr ? $sep $col2 $opr2 ? ORDER BY $ordercol $ordersort LIMIT $limit");
			$stmt->execute([$val,$val2]);
			return $stmt;
		}

	}



	public function select_query($tbl_name,$ordercol=null,$ordersort=null,$limit=null){
		if (isset($ordercol) AND isset($ordersort) AND isset($limit)) {
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name ORDER BY $ordercol $ordersort LIMIT $limit");
		}elseif(isset($ordercol) AND isset($ordersort)){
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name ORDER BY $ordercol $ordersort");
		}
		elseif ($ordercol=="" AND $ordersort=="" AND isset($limit)) {
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name LIMIT $limit");
		}
		else{
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name");
		}
		$stmt->execute();
		return $stmt;
	}


	public function search_query($tbl_name,$col,$value,$odercol=null,$ordersort=null,$limit=null){
		$search_value = "%$value%";
		if (isset($ordercol) AND isset($ordersort)) {
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name WHERE $col LIKE :value ORDER BY $ordercol $ordersort");
		}elseif (isset($ordercol) AND isset($ordersort) AND isset($limit)) {
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name WHERE $col LIKE :value ORDER BY $ordercol $ordersort LIMIT $limit");
		}else{
			$stmt = $this->con->prepare("SELECT * FROM $tbl_name WHERE $col LIKE :value");
		}
		$stmt->execute([':value'=>$search_value]);
		return $stmt;
	}


	public function update_query($tb_name,$columns,$values,$id,$col=null){
		$placeholders = "";
		$length = count($values);
		for ($i=0; $i<$length; $i++) { 
			$placeholders.= $i<$length-1 ? $columns[$i]."=".":val".$i."," : $columns[$i]."=".":val".$i;
		}
		if ($col==null) {
			$stmt = $this->con->prepare("UPDATE $tb_name SET $placeholders WHERE id=:id");
		}else{
			$stmt = $this->con->prepare("UPDATE $tb_name SET $placeholders WHERE $col=:id");
		}

		for ($i=0; $i < $length; $i++) { 
			$val = stripcslashes(trim($values[$i]));
			$stmt->bindValue(":val".$i,$val);
		}
		$stmt->bindValue(":id",$id);
		$res = $stmt->execute();
		return $res;
	}




	public function delete_query($tbl_name,$id,$col=null){
		if (isset($col)) {
			$stmt = $this->con->prepare("DELETE FROM $tbl_name WHERE $col=?");
		}else{
			$stmt = $this->con->prepare("DELETE FROM $tbl_name WHERE id=?");
		}
		$res = $stmt->execute([$id]);
		return $res;
	}




}

$database = new Database();


// Developed by Abdul Razzaq -- ab.razzaq32@yahoo.com

?>