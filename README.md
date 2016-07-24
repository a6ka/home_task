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

## 1) Первое задание (SSH)
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
