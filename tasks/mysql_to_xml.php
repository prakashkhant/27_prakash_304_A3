<?php // Task 3: MySQL students table -> students.xml
require_once __DIR__ . '/../includes/config.php';
$rows = $pdo->query('SELECT name,email,course FROM students')->fetchAll();
$xml = new SimpleXMLElement('<students/>');
foreach ($rows as $r) {
    $s = $xml->addChild('student');
    foreach ($r as $k => $v) $s->addChild($k, htmlspecialchars($v));
}
$dom = new DOMDocument('1.0', 'UTF-8'); $dom->preserveWhiteSpace = false; $dom->formatOutput = true;
$dom->loadXML($xml->asXML());
$dom->save(__DIR__ . '/students_export.xml');
echo count($rows) . ' students exported to students_export.xml';
