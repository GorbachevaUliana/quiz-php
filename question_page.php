<?php
include "connection.php";
session_start();

if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
    $_SESSION['name'] = $_POST['name'] ?? '';
}


$questionNo = isset($_GET['question_no']) ? (int)$_GET['question_no'] : 1;

if ($questionNo < 1 || $questionNo > 10) {
    header("Location: result.php");
    exit;
}

$sql = "SELECT * FROM questions WHERE question_no = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "i", $questionNo);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <title>Вопрос <?php echo $questionNo; ?></title>
		<style>
	body{
		background-color: #665446;
		font-family:"Rubik"
	}
	
	.content{
		height:100%;
		width:50%;
		border-radius: 20px;
		background-color:#DEF2C4;
		margin-left:25%;
		margin-top: 3%;
		padding-top: 2%;
		text-align: center;
		padding-bottom: 2%;
	}
	
	img{
		border-radius:20px;
	}
	
	input{
		height:55px;
		width: 250px;
		border:none;
		background-color:#AECCB6;
		border-radius:20px;
		margin-top: 10px;
		cursor:pointer;
		text-align:center;
	}
	
	.input{
		margin-top: 10px;
		background-color:#de8264;
		border: none;
		height:55px;
		width:250px;
		border-radius:20px;
		cursor:pointer;
	}
	</style>
    </head>
    <body>
    <div class="content">
        <h1><?php echo $questionNo . ". " . $row['question']; ?></h1>

        <?php if (!empty($row['image'])): ?>
            <img src="<?php echo $row['image']; ?>" alt="Изображение к вопросу" style="max-width: 300px; max-height: 300px;">
        <?php endif; ?>

        <form method="post" action="check_answer.php">
            <input type="hidden" name="correct_answer" value="<?php echo $row['answer']; ?>">
            <input type="hidden" name="question_no" value="<?php echo $questionNo; ?>">
            <input type="submit" id="opt1" name="answer" value="<?php echo $row['opt1']; ?>"><br/>
            <input type="submit" id="opt2" name="answer" value="<?php echo $row['opt2']; ?>"><br/>
            <input type="submit" id="opt3" name="answer" value="<?php echo $row['opt3']; ?>"><br/>
            <input class="input" type="submit" value="Next">
        </form>
    </div>
    </body>
    </html>
    <?php
} else {
    header("Location: result.php");
    exit;
}

mysqli_stmt_close($stmt);
mysqli_close($link);
?>