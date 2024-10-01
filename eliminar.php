<?php
	session_start();
	$con=mysqli_connect($_ENV['HOST'], $_ENV['USER'], $_ENV['PASS'], $_ENV['DB'], $_ENV['PORT']);
	$dominio=filter_input(INPUT_GET,"dominio");
	
	shell_exec("rm -r $dominio");
	$id_usuario=$_SESSION['id'];
	$consulta="SELECT * FROM `webs` WHERE idUsuario=$id_usuario";
	$ssql= mysqli_query($con,$consulta);

	if(mysqli_num_rows($ssql)>0){
		while($fila = mysqli_fetch_array($ssql,MYSQLI_ASSOC)){
			$consulta1="DELETE FROM `webs` WHERE dominio='$dominio'";
			$ssql1= mysqli_query($con,$consulta1);
		}
	}
	header("location:panel.php");
?>