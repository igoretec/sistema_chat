<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="img/icon.png" >
		<meta charset="utf-8">
		<title>Cadastro</title>
	<head>
	<?php
		session_start();
		$endereco = "localhost";
		$login = "root";
		$senha = "usbw";
		$banco = "db_chat";
		$mysqli = new mysqli($endereco, $login, $senha, $banco);
		if(mysqli_connect_errno()){
			echo $mysqli -> mysql_error();
		}
		else{
		if(!empty($_SESSION['cod'])){
			header('location: mensagem.php');	
		}
	?>
	<body>
		<form method="post" enctype="multipart/form-data">
			<center><fieldset>
				<legend align="center"><img id="cadastro" src="img/cadastro6.png"></legend>
				<b>Usuário: </b><input type="text" name="usuario" size="13" required>
				<b>Senha: </b><input type="password" name="senha" size="8" required><br><br><br>
				<b>Escolha seu avatar:</b><br><br>
				<table>	
					<tr>
						<td><label for="av1"><img class="avatar" src="img/ciro.jpg"></label></td>
						<td><label for="av2"><img class="avatar" src="img/bolsonaro.jpg"></label></td>
						<td><label for="av3"><img class="avatar" src="img/marina.jpeg"></label></td>
						<td><label for="av4"><img class="avatar" src="img/rey.jpg"></label></td>
						<td><label for="av5"><img class="avatar" src="img/geraldo.jpg"></label></td>
					</tr>
					<tr>
						<td><input id="av1" type="radio" name="boneco" value=1></td>
						<td><input id="av2" type="radio" name="boneco" value=2></td>
						<td><input id="av3" type="radio" name="boneco" value=3></td>
						<td><input id="av4" type="radio" name="boneco" value=4></td>
						<td><input id="av5" type="radio" name="boneco" value=5></td>
					</tr>
				</table><br>
				<b>Ou então<br><br>Escolha outro da sua preferência:<br></b><br>
				<center><label for="file"><img id="nenhum" src="img/nenhum.png"></label></center>
				<input id="file" type="file" name="avatar"><br><br><br>
				<input type="submit" value="Cadastrar">
				<input type="reset" value="Limpar"></p>
			</fieldset></center>
		</form>
		<?php
			}
			if(isset($_POST['usuario'])){
				if($_FILES['avatar']['size'] > 0){
					$usuario = $_POST['usuario'];
					$_SESSION['usuario'] = $usuario;
					$senha = $_POST['senha'];
					date_default_timezone_set("Brazil/East");
					$ext = strtolower(substr($_FILES['avatar']['name'],-4));
					$new_name = date("Y.m.d-H.i.s") . $ext;
					$dir = "img/";
					move_uploaded_file($_FILES['avatar']['tmp_name'], $dir.$new_name);
					$sql1 = "insert into tb_avatar values (null, '".$dir.$new_name."')";
					if(!$mysqli->query($sql1)){
						printf("error %s\n" , $mysqli->error);
					}
					$sql2 = "select cd_avatar from tb_avatar where ds_endereco = '".$dir.$new_name."'";
					$result = $mysqli->query($sql2);
					if($result->num_rows > 0){
						$row = $result->fetch_object();
						$sql3 = "insert into tb_usuario values (null, '$usuario', '$senha', '".$row->cd_avatar."');";
						if(!$mysqli -> query($sql3)){
							printf("error %s\n" , $mysqli->error);
						}
						else{
							$sql = "select * from tb_usuario where ds_senha = '".$_POST['senha']."' and nm_usuario = '".$_POST['usuario']."'";
							$result = $mysqli->query($sql);
							if($result->num_rows > 0){
								$row = $result->fetch_object();
								$_SESSION['cod'] = $row->cd_usuario;
								echo "<script type='text/javascript'>window.location.href='mensagem.php';</script>";
							}
						}
					}
				}
				else{
					$usuario = $_POST['usuario'];
					$_SESSION['usuario'] = $usuario;
					$senha = $_POST['senha'];
					$boneco = $_POST['boneco'];
					$sql = "insert into tb_usuario values (null, '$usuario', '$senha', '$boneco');";
					if(!$mysqli -> query($sql)){
						printf("error %s\n" , $mysqli->error);
					}
					else{
						$sql = "select * from tb_usuario where ds_senha = '".$_POST['senha']."' and nm_usuario = '".$_POST['usuario']."'";
						$result = $mysqli->query($sql);
						if($result->num_rows > 0){
							$row = $result->fetch_object();
							$_SESSION['cod'] = $row->cd_usuario;
							echo "<script type='text/javascript'>window.location.href='mensagem.php';</script>";
						}
					}
				}
			}
		?>
	</body>
	<style type="text/css">
		body
		{
			font-family: helvetica;
			background-image: url(img/wall.jpg);
			background-size: 130%;
		}
		.avatar
		{
			width: 105px;
			height: 105px;
			border-radius: 100%;
			transition: 1s;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		input[type=text], input[type=password]
		{
			border-radius: 5px;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		input[type=submit]:hover, input[type=reset]:hover
		{
			border-color: blue;
			color: blue;
			border-radius: 5px;
			transition: 0.25s;
		}
		input[type=submit], input[type=reset]
		{
			border-radius: 5px;
			width: 15%;
			height: 23px;
			transition: 0.25s;
			font-weight: bold;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		input[type=submit]:hover
		{
			background: green;
			color: white;
			border-color: green;
		}
		input[type=reset]:hover
		{
			background: red;
			color: white;
			border-color: red;
		}
		fieldset
		{
			margin-top: 100px;
			width: 60%;
			border: none;
			border-radius: 50px;
			background-image: url(img/fundox.jpg);
			background-size: 1200px;
			padding-top: 30px;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		#cadastro
		{
			position: relative;
		}
		td
		{
			text-align: center;
			width: 1%;
		}
		#nenhum
		{
			width: 20%;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
			border-radius: 100%;
		}
	</style>
</html>