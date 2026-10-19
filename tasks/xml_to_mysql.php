<?php // Task 2: students.xml -> MySQL students table
require_once __DIR__ . '/../includes/config.php';
$xml = simplexml_load_file(__DIR__ . '/students.xml') or die('Cannot read XML');
$st = $pdo->prepare('INSERT INTO students (name,email,course) VALUES (?,?,?)');
$n = 0;
foreach ($xml->student as $s) { $st->execute([(string)$s->name, (string)$s->email, (string)$s->course]); $n++; }
echo "$n students imported into MySQL.";
