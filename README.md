# Задание:

1) Command line:

- Write a one-line command that displays the first 20 characters of a user's ssh public key

- Write a one-line command that checks the syntax of all php files in the current folder


2) Git:

- Write a git command that displays the hash of the current revision

- Write a git command that displays the code changes of the last 5 commits for the file index.php (in the current folder)


3) PHP:

This is a quick test to see how you think and write code.
Please DO NOT copy/paste code found on other sites; it's pretty obvious when you do and then we cannot evaluate you.
Apply yourself and write clean, efficient code.
The solution must be written in core PHP (no framework).

The problem:

Write a function that takes a directory name as an optional parameter.
If no value is passed, it should take the current working directory by default.
This will be considered the parent directory.

The function must return an associative array containing a sorted list of all directories present in the parent directory.
The list must be sorted by total size (in bytes) of the directory.

For each directory in the list, we must be able to access the following data:
- total size
- number of files
- number of duplicate files (duplicate = 2 files in the directory have the same content)

The format of the return value of the function must be configurable (Array or JSON) by passing a parameter.

# Решение:

### 1) Консоль: чтение публичных SSH-ключей
Проект в папке **ssh**
При запуске проекта в браузере выдаст сообщение о ошибке ("Запускать только через консоль").  
В консоле выполняется командой: 
```sh
php index.php 
```
**Логика:**  
1) При запуске скрипт анализирует папку **~/.ssh** в поисках публичных ключей (файлов с расширением *.pub).  
2) Если файлов нет - выводится сообщение об отсутствии публичных SSH-ключей  
3) Если файлы есть, то выводится имя файла и первые 20 символов файла:  
```sh
C:\wamp\www\home_task\ssh>php index.php
string(32) "id_rsa.pub: ssh-rsa AAAAB3NzaC1y"
```

### 2) Консоль: проверка синтаксиса всех *.php файлов в текущей директории
Проект в папке **checker**  
Скрипт проверки: checker.php

**Порядок запуска:**  
1. Поместить файл checker.php в проверяемую директорию  
2. Открыть консоль в проверяемой папке
3. Запустить файл checker.php командой:
```sh
php checker.php 
```
**Логика:**  
1) Получается массив файлов/папок в текущей директории (scandir)  
2) Из массива удаляется исполняющий файл checker.php  
3) Удаляются все элементы, кроме файлов .php  
4) Для каждого файла выполняется консольная команда проверки синтаксиса:
```sh
php -l filename.php
```

**Результат для существующих файлов:**  
```sh

C:\wamp\www\home_task\checker>php checker.php
string(49) "C:\wamp\www\home_task\checker - directory exists;"
string(27) "file_with_error.php - ERROR"
string(14) "hello.php - OK"
string(14) "index.php - OK"

C:\wamp\www\home_task\checker>
```

### 3) Git: Хеш текущей доработки
Запускать в Git Bash:
```sh
$ git rev-parse --verify HEAD
```
**Результат:**  
```sh
Alex@a6ka MINGW64 /c/wamp/www/home_task/checker (master)
$ git rev-parse --verify HEAD
6dbb09fd8a89ed709813cfb0fd628aa921c752fc
```

### 4) Git: Показать изменения последних 5 коммитов файла index.php
Запускать в Git Bash:
```sh
$ git log -p -5 --reverce index.php
```
где:
* _git log_ - показать лог
* _-p_ - показать кодом
* _-5_ - Сколько коммитов назад (от последнего) смотрим
* _--reverce_ - Чисто для удобства показать от самого первого коммита к более поздним
* _index.php_ - указываем файл, лог изменений которого смотрим

### 5) PHP: Написать функцию получения информации о вложенных директориях
Проект в папке **skan_project**  
Скрипт запуска: index.php  
  
**Главная функция:** showDirectoriesInfo([$dir, $format])  
* $dir - Не обязательный параметр. Принимает путь к анализируемой папке. Если не задан - сканирует директорию проекта
* $format = Не обязательный параметр. Принимает на вход следующие значения: **ARRAY** или **JSON** (регистронезависим). Если параметр не передан, по умолчанию вернет ответ в формате JSON  

**Дополнительные функции:**
* dirList($dir) - возвращает массив 
