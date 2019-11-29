
<?php
$body = file_get_contents('php://input'); //Получаем в $body json строку
$arr = json_decode($body, true); //Разбираем json запрос на массив в переменную $arr
  
function cir_strrev($stroka){ //Так как функция strrev не умеет нормально переворачивать кириллицу, нужен костыль через массив. Создадим функцию
    preg_match_all('/./us', $stroka, $array); 
    return implode('',array_reverse($array[0]));
}
 
include_once ('tgclass.php'); //Меж дела подключаем наш tg.class.php
  
//Сразу и создадим этот класс, который будет написан чуть позже
//Сюда пишем токен, который нам выдал бот
$tg = new tg('886329664:AAEW_zt6mgSZ8gq6SJfEQmgki6KnbHs6-Lw ');
  
$sms = $arr['message']['text']; //Получаем текст сообщения, которое нам пришло.
//О структуре этого массива который прилетел нам от телеграмма можно узнать из официальной документации.
  
//Сразу и id получим, которому нужно отправлять всё это назад
$tg_id = $arr['message']['chat']['id'];
  
//Перевернём строку задом-наперёд используя функцию cir_strrev
$sms_rev = cir_strrev($sms);
  
//Используем наш ещё не написанный класс, для отправки сообщения в ответ
$tg->send($tg_id, $sms_rev);
 
exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл
?>