<?php
	include "../../class/connect.class.php";
	include "../../class/accountNum.class.php";
	
	$con = new getConnection();
	$processNext = new getNextNum();
	
	$db = $con->PDO();
	$id = $_SESSION["userId"];

	if(isset($_POST["cid"])){
		$cid = $_POST["cid"];
		$acctNum = $_POST["acct"];
		$appId = $_POST["appId"];
		$tid = $_POST["tid"];
		
		$query = $db->query("SELECT *FROM consumers WHERE AccountNumber = $acctNum");
		$query2 = $db->query("SELECT *FROM tbl_temp_consumers WHERE AccountNumberT = $acctNum");
		if($query->rowCount()>0 || $query2->rowCount()>0)
			echo "Account Number Exist";
		else{
			try{
				$db->beginTransaction();
				$insert = $db->prepare("UPDATE tbl_temp_consumers SET AccountNumberT = ? WHERE cid = ?");
				$insert->execute(array($acctNum, $cid));

				$processed = 0;
				$q = $db->query("SELECT *FROM tbl_transactions where tid = $tid");
				foreach ($q as $r) {
					$processed = $r["processedBy"];
				}

				$update = $db->prepare("UPDATE tbl_transactions SET action = ?, approvedBy = ?, dateApproved = ?, remarks = ? WHERE tid = ?");
				$update->execute(array(1, $id, date("Y-m-d H:i:s"), null, $tid));

				$insert = $db->prepare("INSERT INTO tbl_transactions (appId, cid, status, processedBy, dateProcessed)
									VALUES(?, ?, ?, ?, ?)");
				$insert->execute(array($appId, $cid, 4, $processed, date("Y-m-d H:i:s")));
				$db->commit();
				echo "1"; 
			} catch(PDOException $e){
				$db->rollBack();
				echo $e;
			}
		}
	}
?>