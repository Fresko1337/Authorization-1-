<?php
include($_SERVER['DOCUMENT_ROOT'] . '/class.php');

/*
	Авторизация игрока без использования шифрования md5 в базе данных.
		admin - логин
		123456 - пароль
		false - md5 шифрование пароля в базе данных
		false - sha256 шифрование пароля в базе данных
		false - вывод дополнительных полей из базы данных
*/
$auth = json_decode(auth('admin', '123456', false, false, false), true);
print_r($auth);

/*
	Авторизация игрока с использованием шифрования md5 в базе данных.
		admin - логин
		123456 - пароль
		false - md5 шифрование пароля в базе данных
		false - sha256 шифрование пароля в базе данных
		id,pass - вывод дополнительных полей из базы данных
*/
$auth = json_decode(auth('admins', '123456', true, false, 'id,pass'), true);
print_r($auth);

/*
	Авторизация игрока с использованием шифрования sha256 в базе данных.
		admin - логин
		123456 - пароль
		false - md5 шифрование пароля в базе данных
		true - sha256 шифрование пароля в базе данных
		id,pass - вывод дополнительных полей из базы данных
*/
$auth = json_decode(auth('adm', '123456', false, true, 'id,pass'), true);
print_r($auth);

?>