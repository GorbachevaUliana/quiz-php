<?php
include "connection.php";
session_start();

$currentQuestionNo = isset($_GET['question_no']) ? intval($_GET['question_no']) : 0;
$userAnswer = $_POST['answer'];
$correctAnswer = $_POST['correct_answer'];
$questionNo = $_POST['question_no']; //Get question number from the hidden field

if ($userAnswer == $correctAnswer) {
    $_SESSION['score']++;
}

$nextQuestionNo = $questionNo + 1;
if ($nextQuestionNo > 10) {
    header("Location: result.php");
} else {
    header("Location: question_page.php?question_no=" . $nextQuestionNo);
}

mysqli_close($link);
?>