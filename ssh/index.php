<?php

//Столкнулся с тем, что в Линукс и в Винде достучаться до директории с SSH-клюями
//необходимо по разному, поэтому в скрипт добавлена функция проверки ОС.
//Тестировалось на Windows. 

//Проверяем не запущена ли страница с браузера (работает только в консоле)
if(isset($_SERVER['HTTP_USER_AGENT'])){
    echo 'Запустите через консоль!';
    die();
}
//Функция определения ОС
function getOS() {

    global $user_OS;

    $os_platform = "Unknown OS Platform";

    $os_array = array(
        '/win/i'       => 'win',
        '/mac/i'       => 'mac',
        '/linux/i'     => 'linux',
        '/ubuntu/i'    => 'linux',
    );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_OS)) {
            $os_platform = $value;
            break;
        }
    }

    return $os_platform;
}

$user_OS = strtolower($_SERVER['OS']);
$user_OS = getOS();

$dir = '';
switch ($user_OS) {
    case 'win':
        $dir = $_SERVER['HOMEDRIVE'].$_SERVER['HOMEPATH'].'/.ssh';
        break;
    case 'linux':
        $dir = $_SERVER['HOME'].'/.ssh';
        break;
    case 'mac':
        $dir = $_SERVER['HOME'].'/.ssh';
        break;
    default:
        break;
}

//Сообщение о ошибке, если не удалось определить ОС
if($dir == ''){
    echo 'Ups! Unknown OS Platform';
    die();
}
$files = scandir($dir);
$files = preg_grep('/\.pub$/i', $files); //Оставляем только файлы с расширением *.pub

//Сообщение, если нет публичных ключей
if(!count($files)){
    echo "Don't have public SSH keys";
    die();
}
//Вычитываем файлы публичных ключей
foreach ($files as $fileName) {
    $file = $dir.'/'.$fileName;
    var_dump($fileName.': '.file_get_contents($file, NULL, NULL, -1, 20));
}

