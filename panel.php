<?php
	session_start();
	$con=mysqli_connect($_ENV['HOST'], $_ENV['USER'], $_ENV['PASS'], $_ENV['DB'], $_ENV['PORT']);
	$name_web=filter_input(INPUT_POST,"web_name");
	if(empty($_SESSION['id'])){
		header("location:login.php");
	}
	if(isset($_POST["submit"])) {
		$idUsuario=$_SESSION['id'];
		$name_dominio=$idUsuario.$name_web;
		$fechaCreacion=date("y/m/d-h:i:s");
		$consulta="SELECT * FROM `webs` WHERE `dominio`='$name_dominio'";
		$ssql= mysqli_query($con,$consulta);

		if(mysqli_num_rows($ssql)==0){
			$consulta2="INSERT INTO `webs` (`idUsuario`, `dominio`, `fechaCreacion`) VALUES ('$idUsuario','$name_dominio','$fechaCreacion')";
			$ssql2= mysqli_query($con,$consulta2);
			shell_exec("./wix.sh $name_dominio");
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
	<style >
		a{
			padding-right: 1.5rem;
		}
	</style>
<body>
	<h2>Bienvenido a tu panel <?php echo $_SESSION['email']; ?> </h2>
	<a href="logout.php">Cerra sesion de <?php echo $_SESSION['id'];?></a>
	<br><br>
	<form method="POST">
		Ingrese nombre de la nueva web: <input type="text" name="web_name" required>
		<input type="submit" name="submit" value="Crear web">
	</form><br><br>
	<?php
		$idUsuario=$_SESSION['id'];
		if($idUsuario==6){
			$consulta3="SELECT * FROM `webs`";
			$ssql3= mysqli_query($con,$consulta3);
		}else{
			$consulta3="SELECT * FROM `webs` WHERE `idUsuario`=$idUsuario";
			$ssql3= mysqli_query($con,$consulta3);
		}
		if(mysqli_num_rows($ssql3)>0){
			while($fila = mysqli_fetch_array($ssql3,MYSQLI_ASSOC)){
				$dominio=$fila['dominio'];
				echo "<a href='$dominio'>$dominio</a>";
				shell_exec("zip -r ".$dominio.".zip ".$dominio);
				echo "<a href='$dominio.zip'>Descargar web</a>";
				echo "<a href='eliminar.php?dominio=$dominio'>Eliminar</a><br>";
			}
		}
	?>
</body>
</html>