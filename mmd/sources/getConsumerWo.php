<?php
    include "../../class/connect.class.php";

    $con = new getConnection();
    $db = $con->PDO();
    $ctr = 1;
    $list = array();
	
	if(isset($_GET["mr"])){
		$mr = $_GET["mr"];
		$ctr = 1;
		$query = $db->query("SELECT *FROM tbl_mr_wo a
							LEFT OUTER JOIN tbl_applications b ON a.appId = b.appId
							LEFT OUTER JOIN consumers c ON b.Entry_Number = c.Entry_Number
							WHERE mrNo = '$mr'");
		
		foreach($query as $row){
			$mReading = $mBrand = $mClass = $mSerial = $mERC = $mLabSeal = $mTerminal = $multiplier = "";
			foreach($db->query("SELECT *FROM tbl_meter_profile WHERE cid = '".$row["Entry_Number"]."' AND appId = '".$row["appId"]."'") as $r){
				$mReading = $r["mReading"];
				$mBrand = $r["mBrand"];
				$mClass = $r["mClass"];
				$mSerial = $r["mSerial"];
				$mERC = $r["mERC"];
				$mLabSeal = $r["mLabSeal"];
				$mTerminal = $r["mTerminal"];
				$multiplier = $r["multiplier"];
			}
			
			//approve mr by mmd
			
			$list[] = array(
				"ctr1" => $ctr,
				"acctNo" => $row["AccountNumber"],
				"consumerName" => $row["AccountName"],
				"address" => $row["Address"],
				"cid" => $row["Entry_Number"],
				"mReading" => $mReading,
				"mBrand" => $mBrand,
				"mClass" => $mClass,
				"mSerial" => $mSerial,
				"mERC" => $mERC,
				"mLabSeal" => $mLabSeal,
				"mTerminal" => $mTerminal,
				"multiplier" => $multiplier
			);
			
			$ctr++;
		}
		
		echo json_encode($list);
	}
	if(isset($_POST["cid"])){
		$cid = $_POST["cid"];
		$ctr = 1;
		foreach($db->query("SELECT *FROM tbl_applications a
							LEFT OUTER JOIN consumers b ON a.Entry_Number = b.Entry_Number
							WHERE a.Entry_Number = '$cid'") as $row){

			$mReading = $mBrand = $mClass = $mSerial = $mERC = $mLabSeal = $mTerminal = $multiplier = "";
			foreach($db->query("SELECT *FROM tbl_meter_profile WHERE cid = '$cid' AND appId = '".$row["appId"]."'") as $r){
				$mReading = $r["mReading"];
				$mBrand = $r["mBrand"];
				$mClass = $r["mClass"];
				$mSerial = $r["mSerial"];
				$mERC = $r["mERC"];
				$mLabSeal = $r["mLabSeal"];
				$mTerminal = $r["mTerminal"];
				$multiplier = $r["multiplier"];
			}
			
			
			$list = array(
				"acctNo" => $row["AccountNumber"],
				"consumerName" => $row["AccountName"],
				"address" => $row["Address"],
				"cid" => $row["Entry_Number"],
				"mReading" => $mReading,
				"mBrand" => $mBrand,
				"mClass" => $mClass,
				"mSerial" => $mSerial,
				"mERC" => $mERC,
				"mLabSeal" => $mLabSeal,
				"mTerminal" => $mTerminal,
				"multiplier" => $multiplier
			);
			
			echo json_encode($list);
		}
	}
?>