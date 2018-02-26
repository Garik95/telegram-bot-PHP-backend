<?php
include("src/Autoloader.php");
$token = '447080939:AAFVn76zbat7ngw08UOdhYNIjMIF6EI4fyk';
$bot = new Telegram\Bot($token, "novatio_diet_bot", "bot");
$tg = new Telegram\Receiver($bot);
$content = file_get_contents("php://input");
$update = json_decode($content, true);


if($tg->callback)
{
	$tg->send->text($tg->message)->send();
	$con = mysqli_connect('83.69.138.176', 'admin_novatio', '9UAeIFiJtf', 'admin_nova');
	mysqli_set_charset($con,"utf8");
	$sql = "select * from sp_questions where status = 1";
	$query  = mysqli_query($con, $sql);

	while ($row = mysqli_fetch_array($query))
    {
    	$res[] = $row['id'];
    }
  	foreach($res as $r=>$val)
  	{
  		if($tg->callback == (string)$val."ans")
  		{
			$tg->send->text("Ответ!")->send();
			$tg->answer_if_callback(""); break;
		}
	}
}
if($tg->text())
{
	// $arr = json_decode(json_encode($tg->))
	$tg->send->text(json_encode($tg->reply))->send();
}


?>