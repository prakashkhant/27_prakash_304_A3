<?php // Task 5: call Express REST API from PHP (start express_api/server.js first)
function call($method, $url, $data = null) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_CUSTOMREQUEST => $method, CURLOPT_HTTPHEADER => ['Content-Type: application/json']]);
    if ($data) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $res = curl_exec($ch);
    if ($res === false) die('Error: ' . curl_error($ch));
    return json_decode($res, true);
}
$new = call('POST', 'http://localhost:3000/api/students', ['name' => 'Neha Joshi', 'course' => 'BBA']);
echo '<h3>Created</h3><pre>' . print_r($new, true) . '</pre>';
echo '<h3>All students from Express</h3><pre>' . print_r(call('GET', 'http://localhost:3000/api/students'), true) . '</pre>';
