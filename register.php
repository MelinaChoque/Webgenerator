<?php
		$con=mysqli_connect($_ENV['HOST'], $_ENV['USER'], $_ENV['PASS'], $_ENV['DB'], $_ENV['PORT']);
	session_start();
	$usu_rep=0;
	if(isset($_SESSION['id'])){
		header("location:panel.php");
	}
	if(isset($_POST["submit"])) {
		$email=filter_input(INPUT_POST,"email");
		$contra1=filter_input(INPUT_POST,"contra1");
		$contra2=filter_input(INPUT_POST,"contra2");
 		$fechaRegistro=date("y/m/d-h:i:s");

		$consulta="SELECT * FROM usuarios";
		$ssql= mysqli_query($con,$consulta);
		if(mysqli_num_rows($ssql)>0){
			while($fila = mysqli_fetch_array($ssql,MYSQLI_ASSOC)){
				if($fila['email']==$email){
					$usu_rep=1;
				}
			}
		}

		if($contra1!=$contra2){
			echo "Las contraseñas no coinciden";
		}
		if($usu_rep==1){
			echo "Ese email ya esta registrado";
		}

		if($contra1==$contra2 && $usu_rep==0){
			$consulta="INSERT INTO `usuarios`(`email`, `password`, `fechaRegistro`) VALUES ('$email','$contra2','$fechaRegistro')";
			$ssql= mysqli_query($con,$consulta);     
			header("location:login.php");
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Registrarte es simple</title>
</head>
<body>
	<form method="POST">
		Ingrese su mail:<input type="email" name="email" required><br><br>
		Ingrese su contraseña:<input type="password" name="contra1" required>	
		Ingrese su contraseña nuevamente:<input type="password" name="contra2">	
		<input type="submit" name="submit" value="ingresar">
	</form>
</body>
</html>