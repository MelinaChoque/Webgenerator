<?php
	$con=mysqli_connect($_ENV['HOST'], $_ENV['USER'], $_ENV['PASS'], $_ENV['DB'], $_ENV['PORT']);
	session_start();

	if(isset($_SESSION['id'])){
		header("location:panel.php");
	}

	if(isset($_POST["submit"])) {
		$email=filter_input(INPUT_POST,"email");
    	$password=filter_input(INPUT_POST,"contra");
		
		$consulta="SELECT * FROM `usuarios` WHERE `email`='$email' AND `password`='$password'";
		$ssql= mysqli_query($con,$consulta);

		$consulta2="SELECT * FROM `usuarios` WHERE `email`='$email'";
		$ssql2= mysqli_query($con,$consulta2);

		if(mysqli_num_rows($ssql2)==0){
			echo "Email no registrado";
		}else if(mysqli_num_rows($ssql)==0){
			echo "Contraseña invalida";
		}else{
			while($fila = mysqli_fetch_array($ssql,MYSQLI_ASSOC)){
				$usuario=$fila['idUsuario'];
				$email=$fila['email'];
			}
			$_SESSION["id"]=$usuario;
			$_SESSION["email"]=$email;

			header("location:panel.php");
		}	
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>webgenerator Choque Melina</title>
</head>
<body>
	<form method="POST">
		Ingrese su mail:<input type="email" name="email" required><br><br>
		Ingrese su contraseña:<input type="password" name="contra" required>
		<br><br>
		<input type="submit" name="submit" value="ingresar">
	</form>
	<a href="register.php">Ir a registrarme</a>
	<br><br>
</body>
</html>