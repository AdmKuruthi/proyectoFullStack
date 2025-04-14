<?php
// Initializa la sesion
session_start();
 
// Verifica si los usuarios están realmente logueados, si lo están, los redirecciona a la página de index.php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Incluye el archivo config
require_once "./lib/database.php";
require_once "./lib/helpers.php";
 
// Define Variables y las inicializa
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Procesa los datos del formulario cuando el formulario es enviado
if(isPost()){
 
    // Verifica si el username está vacío
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese su nombre de usuario.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Verifica si el password está vacío
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor ingrese su contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Valida las credentiales
    if(empty($username_err) && empty($password_err)){
        $db = new Database();
        $link = $db->getConnection();
        // Prepara una sentencia de SELECT
        $sql = "SELECT id, username, password FROM usuarios WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Vincula variables a la sentencia preparada como parámetros
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Parámetros enviados
            $param_username = $username;
            
            // Intento de ejecutar la sentencia preparada
            if(mysqli_stmt_execute($stmt)){
                // Almarena el resultado
                mysqli_stmt_store_result($stmt);
                
                // Verifica si el username existe, SI existe entonces verifica el password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Prepara resultados de variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

                    if(mysqli_stmt_fetch($stmt)){
                        $password = trim($password);
                        $hashed_password = trim($hashed_password);
                        
                        if (mb_check_encoding($password, 'UTF-8') && mb_check_encoding($hashed_password, 'UTF-8')) {
                                // Proceed with password_verify
                            if(password_verify($password, $hashed_password)){
                                // Password no es correcto, inicia una nueva sesión
                                session_start();
                                
                                // Almacena datos de sesión en variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
    
                                // Redirecciona al usuario a la página del index
                                //header("location: menuprincipal.php");
                                //header("location: index.php");
    
    
                            } else{
                                // Password no es válido, despliega un mensaje de error genérico
                                $login_err = "Nombre de usuario o contraseña incorrectos.";
                            }
                        }
                    }
                } else{
                    // Username no existe, despliega un error genérico
                    $login_err = "Nombre de usuario o contraseña incorrectos.";
                }
            } else{
                echo "Oops! Algo salió mal. Por favor intenta nuevamente más tarde.";
            }

            // Cierre
            mysqli_stmt_close($stmt);
        }
    }
    
    // Cierre de conneccion
    mysqli_close($link);
}
?>
 
 <?php 
    include 'inc/header.php'; 
    include 'inc/container.php';
 ?>
        <h2>Inicio de sesion</h2>
        <p>Por favor ingrese sus credenciales de la cuenta.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>No tienes una cuenta aún? <a href="registroUsuario.php">Regístrate ahora</a>.</p>
        </form>
    </div>
<?php include 'inc/footer.php'; ?>
