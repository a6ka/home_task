<?php

$dir = getcwd();   //задаём имя директории
    if(is_dir($dir)) {   //проверяем наличие директории
        var_dump($dir.' - directory exists;');
        $files = scandir($dir);    //сканируем (получаем массив файлов)
        array_shift($files); // удаляем из массива '.'
        array_shift($files); // удаляем из массива '..'
	array_splice($files, array_search(basename($_SERVER["SCRIPT_FILENAME"]), $files), 1); //удаляю из массива исполняемый файл
        $files = preg_grep('/\.php$/i', $files); //Оставляем только файлы с расширением *.php
// Проверяем файлы на наличие ошибок
        for($i=0; $i<sizeof($files); $i++){
            if(substr(`php -l $files[$i]`, 0, 16) == 'No syntax errors') {
                var_dump($files[$i].' - OK');
            } else {
                var_dump($files[$i].' - ERROR');
            }
        }
    } else var_dump($dir.' -directory not exists;');

//Почему для вывода использован var_dump, а не echo? - вардамп делает перенос на новую строку :) 
//Через эхо в консоле мне не удавалось получить красивый ответ - все было в одну строку
?>
