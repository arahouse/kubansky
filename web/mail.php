<?php

require 'AmoApi.php';

$method = $_SERVER['REQUEST_METHOD'];
$admin_email  = "sales@gk-sky.com";

//Script Foreach
$c = true;
if ( $method === 'POST' ) {

	$project_name = trim($_POST["project_name"]);

	$form_subject = trim($_POST["form_subject"]);
    $name =  trim($_POST["Имя"]);
    $email =  trim($_POST["E-mail"]);
    $question =  trim($_POST["Вопрос"]);

    $toAmo = new AmoApi();
    $toAmo->setUnsortedBuy(
        $name,
        $email,
        $question,
        'КубаньSKY, заявка на покупку',
        'kubansky.club',
        'http://kubansky.club/',
        'Заявка с сайта kubansky.club'
    )->addUnsortedToRemoteServer();

	foreach ( $_POST as $key => $value ) {
		if ( $value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject" ) {
			$message .= "
			" . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
				<td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
				<td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
			</tr>
			";
		}
	}
} else if ( $method === 'GET' ) {

	$project_name = trim($_GET["project_name"]);
	$form_subject = trim($_GET["form_subject"]);
	$name =  trim($_GET["Имя"]);
    $email =  trim($_GET["E-mail"]);
    $question =  trim($_GET["Вопрос"]);

    $toAmo = new AmoApi();
    $toAmo->setUnsortedBuy(
        $name,
        $email,
        $question,
        'КубаньSKY, заявка на покупку',
        'kubansky.club',
        'http://kubansky.club/',
        'Заявка с сайта kubansky.club'
    )->addUnsortedToRemoteServer();


	foreach ( $_GET as $key => $value ) {
		if ( $value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject" ) {
			$message .= "
			" . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
				<td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
				<td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
			</tr>
			";
		}
	}
}

$message = "<table style='width: 100%;'>$message</table>";

function adopt($text) {
	return '=?UTF-8?B?'.Base64_encode($text).'?=';
}

$headers = "MIME-Version: 1.0" . PHP_EOL .
"Content-Type: text/html; charset=utf-8" . PHP_EOL .
'From: '.adopt($project_name).' <'.$admin_email.'>' . PHP_EOL .
'Reply-To: '.$admin_email.'' . PHP_EOL;

mail($admin_email, adopt($form_subject), $message, $headers );



