<?php 
# Koneksi 
require_once ("connections/CConnect.php");
$db= New Database();
$db->Connect();

$SQLmsg="SELECT * FROM kontrak_message WHERE status=0";
$RSmsg=$db->query($SQLmsg);

$body .= "Kontrak Pekerja berikut ini akan segera berahir, mohon untuk diperbarui \n\n\n";
if ($db->num_rows($RSmsg)>0) {
$status= "";
while($data = $db->fetch_array($RSmsg)) 
{
	if ($data[umur_kontrak]>0){
		$status="LEWAT";
	}
	else { 
		$status="KURANG";
	}
	echo "<br>".$data[emp_id];
		
	$body .= " | Nama: " .  $data[emp_name]  ." | Kontrak ke- ". $data[no_kontrak] ." | mulai : ". $data[start_kontrak] ." | s/d : ". $data[end_kontrak] ." | berakhir ".$status." : ". $data[umur_kontrak] ." hari .\n";
	$body .= "----------------------------------------------------------------------------------------------\n"; 
}
		
$kirimi ='Payroll';
$mailTo = 'joice_hw@lintech.co.id, ichwan_hakim@lintech.co.id, andre@lintech.co.id, fendi@lintech.co.id, hakam@lintech.co.id'; 
//$mailTo = 'hakam@lintech.co.id, andre@lintech.co.id'; //test email kirim lintech
$subject = "PAYROLL Warmning Contract";
$headers = 'From: <'.$mailTo.'> ' . "\r\n" . 'Reply-To: ' . $mailTo;
$headers = 'Form: <'.$kirimi.'> ' . "\r\n" . 'Reply-To: ' . $kirimi;
mail($mailTo, $subject, $body, $headers);
//mail("hakam@lintech.co.id", $subject, "Test", $headers);

}
//mail("hakam@lintech.co.id","Success","Great", "Localhost Mail works");//Test email gmail
?>
		
