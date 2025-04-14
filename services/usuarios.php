<?php
include_once '../lib/helpers.php';
$errorMessages = array();

    if(isPost()){
        include_once '../lib/database.php';

        $username = $_POST['username'];
        $email = $_POST['txt_email'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        $validationPassed = true;

        if($password1 !== $password2){
            $errorMessages[] = "Las contraseñas no coinciden.";
            $validationPassed = false;

        }

        if(!isValidEmail($email)){
            $errorMessages[] = "El correo electrónico no es válido.";
            $validationPassed = false;

        }

        if(!isValidUsername($username)){
            $errorMessages[] = "El nombre de usuario no es válido.";
            $validationPassed = false;

        }

        if(!isValidPassword($password1)){
            $errorMessages[] = "La contraseña no es válida.";
            $validationPassed = false;

        }

        if($validationPassed){
            $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
        
            $db = new Database();
            $conn = $db->getConnection();
            
            registerUser($username, $email, $hashedPassword) ? displaySuccessMessage("Usuario registrado exitosamente.") : displayErrorMessage();
        }else{
            displayErrorMessage();
        }
        
    } else {
        echo json_encode(array("status" => "error", "message" => "Acceso no permitido."));
    }

    function displaySuccessMessage($message)
    {
        include '../inc/header.php';
        echo "<div class='container'><div class='alert alert-success position-absolute top-50 start-50 translate-middle text-center'>$message</div></div>";
        include '../inc/footer.php';
    }

    function displayErrorMessage()
    {
        global $errorMessages;
        include '../inc/header.php';
        foreach ($errorMessages as $error) {
            echo "<div class='container'><div class='alert alert-danger position-absolute top-50 start-50 translate-middle text-center'>$error</div></div>";
        }
        include '../inc/footer.php';
    }


    function registerUser($username, $email, $hashedPassword)
    {
        global $conn;
        global $errorMessages;
        try{
            $stmt = $conn->prepare("CALL Usuario_Add(?, ?, ?)"); 
            $stmt->bind_param("sss", $email, $username, $hashedPassword );
            
            if($stmt->execute()) {
                return true;
            } else {
                $errorMessages[] = "Error al registrar el usuario: " . $stmt->error;
                return false;
            }
        }catch (Exception $e) {
            if ($e->getCode() === 1062) {
                $errorMessages[] = "Nombre de usuario o correo electrónico ya existe";
            } else {
                $errorMessages[] = "Error al registrar el usuario: " . $e->getMessage();
            }
            return false;
        } finally {
            $stmt->close();
            $conn->close();
        }
    }

    function getUserByEmail($email)
    {
        global $conn;
        $stmt = $conn->prepare("CALL Usuario_GetByEmail(?)"); 
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
?>