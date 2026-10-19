<?php // PHP REST API: /php_api/api.php  (GET list, GET ?id=1, POST json body)
require_once __DIR__ . '/../includes/config.php';
header('Content-Type: application/json');
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) { $s = $pdo->prepare('SELECT * FROM students WHERE id=?'); $s->execute([$_GET['id']]); $r = $s->fetch();
            if ($r) echo json_encode($r); else { http_response_code(404); echo json_encode(['error' => 'Not found']); } }
        else echo json_encode($pdo->query('SELECT * FROM students')->fetchAll());
        break;
    case 'POST':
        $d = json_decode(file_get_contents('php://input'), true);
        if (empty($d['name'])) { http_response_code(400); echo json_encode(['error' => 'name required']); break; }
        $pdo->prepare('INSERT INTO students (name,email,course) VALUES (?,?,?)')->execute([$d['name'], $d['email'] ?? '', $d['course'] ?? '']);
        http_response_code(201); echo json_encode(['id' => $pdo->lastInsertId(), 'message' => 'Created']);
        break;
    default: http_response_code(405); echo json_encode(['error' => 'Method not allowed']);
}
