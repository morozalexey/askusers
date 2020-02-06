<?php
require_once 'init.php';
require_once 'authorization.php';

$user_id = $_SESSION['user']['id']; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
	$required_fields = ['name'];
	
    $user = array_intersect_key($_POST, array_flip($required_fields));
    
    $_SESSION['errors'] = [];
    
    foreach ($required_fields as $field) {
        if (empty($user[$field])) {
            $_SESSION['errors'][$field] = 'Поле не заполнено';
        }
    }   

    if(empty($_SESSION['errors'])){ 
        $newName = $_POST['name'];
        $sql_profile_info = "UPDATE users SET name = ? WHERE id = ?";
        $stmt_profile_info = $pdo->prepare($sql_profile_info);
        $stmt_profile_info->execute([$newName, $user_id]);
       
        $_SESSION['user']['name'] = $newName;

        $_SESSION ['messageProfileSucces'] = true;
			
    } else {
        $_SESSION ['messageProfileError'] = true;        
    }     

	Location: header('Location: /profile.php');
    
}