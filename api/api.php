<?php
header('Content-Type: application/json');

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "quiz";

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(["error" => "Ошибка подключения к базе данных: " . $e->getMessage()]));
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['endpoint']) && $_GET['endpoint'] === 'users') {
        getAllUsers($pdo);
    } elseif (isset($_GET['endpoint']) && $_GET['endpoint'] === 'questions') {
        getAllQuestions($pdo);
    } else {
        http_response_code(404);
        die(json_encode(["error" => "Неизвестный эндпоинт"]));
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['endpoint']) && $_GET['endpoint'] === 'users'){
        addNewUser($pdo, $_POST['name'], $_POST['score']);
    } else {
        http_response_code(404);
        die(json_encode(["error" => "Неизвестный эндпоинт"]));
    }
} else {
    http_response_code(405);
    die(json_encode(["error" => "Недопустимый метод запроса"]));
}


function getAllUsers($pdo) {
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
}

function getAllQuestions($pdo) {
    $stmt = $pdo->query("SELECT * FROM questions");
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($questions);
}

function addNewUser($pdo, $name, $score){
    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, score) VALUES (?, ?)");
        $stmt->execute([$name, $score]);
        echo json_encode(["message" => "Пользователь добавлен"]);
    } catch (PDOException $e){
        http_response_code(500);
        die(json_encode(["error" => "Ошибка добавления пользователя: " . $e->getMessage()]));
    }
}

?>
