<?php
if (isset($_POST["calendar"]) && isset($_POST["text"]) ) { 

	// Формируем массив для JSON ответа
    $result = array(
    	'data' => $_POST["calendar"],
        'text' => $_POST["text"],
        'time' => $_POST["time"]
    );
    $results = $_POST["calendar"].'time'.$_POST["time"].'='.$_POST["text"].';'; 
    file_put_contents('data_base.txt', print_r($results,true), FILE_APPEND);
    
    // Переводим массив в JSON
    echo json_encode($result); 
}
?> 