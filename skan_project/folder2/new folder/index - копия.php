<?php
//--------- Вспомогательные функции ----------
//Функция получения массива из директорий
function dirList($dir){ 
       foreach(array_diff(scandir($dir),array('.','..')) as $f){
           if(is_dir($dir.'/'.$f)){
               $l[]=$f;
           }
       } 
       return $l; 
} 
//Функция преобразования данных в нужный формат
function formatEncode(array $output, $format) {
    switch ($format) {
//Вардамп массива
        case 'array':
            return var_dump($output);
            break;
//При неизвестном формате вернет JSON
        default:
            return json_encode($output);
            break;
    }
}
//Функция расчета размера директории (использована библиотека SPL - http://php.net/spl )
function dirSize($dir) {
    $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
    );

    $size = 0;
    foreach ($it as $fi) {
        $size += $fi->getSize();
    }
    return $size;
}
//Функция расчета количества файлов (использована библиотека SPL)
function filesCount($dir) {
    $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
    );

    $count = 0;
    foreach ($it as $fi) {
        $count += 1;
    }
    return $count;
}
//Функция поиска дубляжа контента
function dublicateCount($dir) {
    $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
    );
    //Список файлов
    $fileList = []; 
    foreach ($it as $fi) {
        $fileList[] = $fi->getRealPath();
    }
    //Массив хешей
    $hashList = []; 
    foreach ($fileList as $file) {
        $hashList[]=  md5_file($file);
    }
    //Количество уникальных хешей
    $countHash = array_count_values($hashList);
    
    //Подсчитываем количество дубляжей
    $count = 0;
    foreach ($countHash as $val) {
        $count+= $val-1;
    }
    return $count;
}

//--------- Главная функция ----------
function showDirectoriesInfo($dir = '*', $format = 'json') {
    $output = [];
    $format = strtolower($format);
    if($dir == '*'){
        $dir = getcwd(); //Устанавливаем текущую директорию, если не передан параметр
    }else{
        $dir = getcwd().'/'.$dir; //Получаем полный путь к директории
    }
    
    //Проверяем на существование директории
    if(!is_dir($dir)){
        $output['errorMessage'] = 'Директория не найдена';
        goto end; //Если директории не существует - выполнять дальше нет смысла
    }
    
    $dirList = dirList($dir);
    
//Формируем каркас - ассоциативный массив с информацией о директориях
    $assocDirList = [];
    foreach ($dirList as $dirName) {
        $assocDirList[$dirName] = [
            "dirSize" => dirSize($dir.'/'.$dirName),
            "filesCount" => filesCount($dir.'/'.$dirName),
            "dublicateCount" => dublicateCount($dir.'/'.$dirName),
        ];
    }
//Сортировка массива
    uasort($assocDirList, function($a, $b){
    return ($a['dirSize'] - $b['dirSize']);
});
    
    $output = $assocDirList;
//Возврат результата
    end:
    return formatEncode($output, $format);
}

echo showDirectoriesInfo('','json');


    
