<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="img/icon.png" >
		<meta charset="utf-8">
		<title>Chat</title>
	<head>
	<?php
		session_start();
		$endereco = "localhost";
		$login = "root";
		$senha = "usbw";
		$banco = "db_chat";
		$mysqli = new mysqli($endereco, $login, $senha, $banco);
		if(mysqli_connect_errno()){
			echo $mysqli->mysql_error();
		}
		if(empty($_SESSION['cod'])){
			header('location: index.php');	
		}
	?>
	<body>
		<form method="post">
			<div id="barra">
				<center>
					<legend><b id="nometi">
						<?php
							$sql = "select usu.nm_usuario, ava.ds_endereco from tb_usuario usu, tb_avatar ava where usu.id_avatar = ava.cd_avatar and usu.cd_usuario = ".$_SESSION['cod'];
							$resultado = $mysqli->query($sql);
							if($resultado->num_rows > 0){
								$row1 = $resultado->fetch_object();
								echo $row1->nm_usuario;
						?>
					</b></legend><br>
						<?php
							echo "<img class='perfil' src='".$row1->ds_endereco."'>";
							}
						?>
				</center><br>
				<hr>
				<center><b id="fic">Envie uma mensagem:</b></center><br>
				<b>Destinatário: </b>
				<select name="destinatario" required>
					<option>Selecione...</option>
					<?php
						$sql4 = "select nm_usuario, cd_usuario from tb_usuario where nm_usuario <> ".$_SESSION['cod']." and cd_usuario <> ".$_SESSION['cod'];
						$resultado = $mysqli->query($sql4);
						if($resultado->num_rows > 0){
							while($row = $resultado->fetch_object()){
								echo "<option value='".$row->cd_usuario."'>".$row->nm_usuario."</option>";
							}
						}
					?>
				</select><br><br>
				<b>Tipo: </b>
				<select name="tipo" required>
					<option>Selecione...</option>
					<?php
						$sql = "select * from tb_tipo";
						$resultado = $mysqli->query($sql);
						if($resultado->num_rows > 0){
							while($row = $resultado->fetch_object()){
								echo "<option value='".$row->cd_tipo."'>".$row->ds_tipo."</option>";
							}
						}
					?>
				</select>
				<br><br>
				<textarea name="mensagem" placeholder="Digite sua mensagem..." required></textarea><br><br>
				<div id="emojis">
					<?php
						$sql = "select * from tb_emoji";
						$resultado = $mysqli->query($sql);
						$c = 1;
						while($row = $resultado->fetch_object()){
							echo '<input id="'.$row->cd_emoji.'" type="radio" name="emoji" value="'.$row->cd_emoji.'"><label for="'.$row->cd_emoji.'"><img class="emoji" src="'.$row->ds_emoji.'"></label>';
							if ($c%3 == 0) {
								echo "<br>";
							}
							$c++;
						}
					?>
					<center>
						<input id="x" type="button" onclick="EscondeEmoji()">
					</center>
				</div>
				<center>
					<input id="enviar" type="submit" value="">
				</center>
			</div>
			<input id="icone" type="button" value="" onclick="MostraEmoji()">
			<div id="mensagens">
				<div id="legend1" align="center">
					<h2>Mensagens trocadas</h2>
					<a href="mensagem.php?id=0"><img title="Sair" id="sair" class="coisinhas" src="img/sair.png"></a>
					<input type="button" title="Contatos" value="" id="contatos" class="coisinhas" onclick="MostrarContatos()">
					<div id="contatinhos">
						<?php
							$mostrar = "select usu.cd_usuario, usu.nm_usuario, ava.ds_endereco from tb_usuario usu, tb_avatar ava where ava.cd_avatar = usu.id_avatar";
							$resultado = $mysqli->query($mostrar);
							if($resultado->num_rows > 0){
								echo "<table>";
								while($linha = $resultado->fetch_object()){
									if($linha->cd_usuario != $_SESSION['cod']){
										echo "<tr><td><img id='contats' src='".$linha->ds_endereco."'></td><td>".$linha->nm_usuario."</td><td><img class='status' src='img/on.png'><td></tr><tr></tr>";
									}	
								}
								echo "</table>";
							}
						?>
							<br>
							<input type="button" value="" id="fechar" onclick="EsconderContatos()">
						</div>
					</div><br><br><br><br><br>
					<?php
						$sql = "select * from tb_mensagem";
						$result = $mysqli->query($sql);
						if($result->num_rows > 0){
							while($row = $result->fetch_object()){
								$sql1 = "select usu.nm_usuario, ava.ds_endereco from tb_usuario usu, tb_avatar ava where ava.cd_avatar = usu.id_avatar and usu.cd_usuario = '".$row->id_remetente."'";
								$result1 = $mysqli->query($sql1);
								$row1 = $result1->fetch_object();
								$sql2 = "select usu.nm_usuario, ava.ds_endereco from tb_usuario usu, tb_avatar ava where ava.cd_avatar = usu.id_avatar and usu.cd_usuario = '".$row->id_destinatario."'";
								$result2 = $mysqli->query($sql2);
								$row2 = $result2->fetch_object();
								$sql3 = "select ds_emoji from tb_emoji where cd_emoji = '".$row->id_emoji."'";
								$result3 = $mysqli->query($sql3);
								$row3 = $result3->fetch_object();
								if(!is_null($row->id_emoji)){
									$imagem = " <img class='emojichat' src='".$row3->ds_emoji."'>"; 
								}
								else{
									$imagem = null;
								}
								if($row->id_remetente == $_SESSION['cod']){
									if($row->id_tipo == 1){
										echo "<fieldset class='mensagempadrao1'><legend id='alinhado' align='right'><table><tr><td id='de'>De: </td><td><img class='fotochat' src='".$row1->ds_endereco."'></td><td><b>".$row1->nm_usuario."</b></td><td> | </td><td id='para'>Para: </td><td><img class='fotochat' src='".$row2->ds_endereco."'></td><td><b>".$row2->nm_usuario."</b></td</tr></table></legend><span class='fonte'>".$row->ds_mensagem."</span>".$imagem."</fieldset><br>";
									}
									else if($row->id_tipo == 2){
										echo "<fieldset class='mensagemsussurro1'><legend id='alinhado' align='right'><table><tr><td id='de'>De: </td><td><img class='fotochat' src='".$row1->ds_endereco."'></td><td><b>".$row1->nm_usuario."</b></td><td> | </td><td id='para'>Para: </td><td><img class='fotochat' src='".$row2->ds_endereco."'></td><td><b>".$row2->nm_usuario."</b></td</tr></table></legend><span class='fonte'>".$row->ds_mensagem."</span>".$imagem."</fieldset><br>";
									}
									else{
										echo "<fieldset class='mensagemgrito1'><legend id='alinhado' align='right'><table><tr><td id='de'>De: </td><td><img class='fotochat' src='".$row1->ds_endereco."'></td><td><b>".$row1->nm_usuario."</b></td><td> | </td><td id='para'>Para: </td><td><img class='fotochat' src='".$row2->ds_endereco."'></td><td><b>".$row2->nm_usuario."</b></td</tr></table></legend><span class='fonte'>".$row->ds_mensagem."</span>".$imagem."</fieldset><br>";
									}
								}
								else{
									if($row->id_tipo == 1){
										echo "<fieldset class='mensagempadrao'><legend id='alinhado' align='right'><table><tr><td id='de'>De: </td><td><img class='fotochat' src='".$row1->ds_endereco."'></td><td><b>".$row1->nm_usuario."</b></td><td> | </td><td id='para'>Para: </td><td><img class='fotochat' src='".$row2->ds_endereco."'></td><td><b>".$row2->nm_usuario."</b></td</tr></table></legend><span class='fonte'>".$row->ds_mensagem."</span>".$imagem."</fieldset><br>";
									}
									else if($row->id_tipo == 2){
										echo "<fieldset class='mensagemsussurro'><legend id='alinhado' align='right'><table><tr><td id='de'>De: </td><td><img class='fotochat' src='".$row1->ds_endereco."'></td><td><b>".$row1->nm_usuario."</b></td><td> | </td><td id='para'>Para: </td><td><img class='fotochat' src='".$row2->ds_endereco."'></td><td><b>".$row2->nm_usuario."</b></td</tr></table></legend><span class='fonte'>".$row->ds_mensagem."</span>".$imagem."</fieldset><br>";
									}
									else{
										echo "<fieldset class='mensagemgrito'><legend id='alinhado' align='right'><table><tr><td id='de'>De: </td><td><img class='fotochat' src='".$row1->ds_endereco."'></td><td><b>".$row1->nm_usuario."</b></td><td> | </td><td id='para'>Para: </td><td><img class='fotochat' src='".$row2->ds_endereco."'></td><td><b>".$row2->nm_usuario."</b></td</tr></table></legend><span class='fonte'>".$row->ds_mensagem."</span>".$imagem."</fieldset><br>";
									}
								}
							}
						}
						else{
							echo "Nenhuma mensagem enviada ou recebida.";
						}
					?>
				</div>
		</form>
		<?php
			if(isset($_POST['destinatario'])){
				$destinatario = $_POST['destinatario'];
				$tipo = $_POST['tipo'];
				if(isset($_POST['emoji'])){
					$emoji = $_POST['emoji'];
				}
				else{
					$emoji = 'null';
				}
				$mensagem = $_POST['mensagem'];
				$sql = "insert into tb_mensagem values (null, '$mensagem', '".$_SESSION['cod']."', '$destinatario', '$tipo', ".$emoji.")";
				if(!$mysqli->query($sql)){
					printf("error %s\n" , $mysqli->error);
				}
				else{
					echo "<script type='text/javascript'>window.location.href='mensagem.php';</script>";
				}
			}
			if(isset($_GET['id']) && $_GET['id'] == 0){
				session_destroy();
				echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
			} 
		?>		
	</body>
	<script type="text/javascript">
		document.getElementById('emojis').style.display = "none";
		document.getElementById('contatinhos').style.display = "none";
		function MostraEmoji(){
			document.getElementById('emojis').style.display = "block";
		}
		function EscondeEmoji(){
			document.getElementById('emojis').style.display = "none";
		}
		function MostrarContatos(){
			document.getElementById('contatinhos').style.display = "block";
		}
		function EsconderContatos(){
			document.getElementById('contatinhos').style.display = "none";
		}

	</script>
	<style type="text/css">
		#x
		{
			width: 14.5%;
			height: 20px;
			background-image: url('img/x1.png');
			background-color: none;
			background-size: 21px;
			border-radius: 100%;
			border: none;
		}
		select
		{
			padding-left: 10px;
			border-radius: 0px 0px 0px 20px;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		.emoji
		{
			width: 23px;
			height: 23px;
		}
		#emojis
		{
			position: absolute;
			margin-top: -205px;
			margin-left: 50%;
			padding: 10px;
			height: 70px;
			overflow: auto;
			z-index: 99;
			border-radius: 5px 0px 0px 5px;
			border: 2px groove lightgray;
		}
		body
		{
			font-family: helvetica;
			background-image: url(img/igor.jpg);
			background-size: 130%;
			background-repeat: no-repeat;
		}
		#barra
		{
			width: 26%;
			height: 690px;
			background: white;
			position: absolute;
			padding: 10px;
			border-radius: 10px 0px 0px 10px;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
			border: 5px solid lightgray;
		}
		#mensagens
		{
			background-image: url("img/fundinho.jpg");
			background-repeat: repeat;
			width: 66.5%;
			height: 710px;
			margin-left: 29%;
			position: relative;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
			border-radius: 0px 10px 10px 0px;
			border: 5px solid lightgray;
			padding-left: 1%;
			padding-right: 1%;
			overflow: auto;
		}
		.perfil
		{
			width: 120px;
			height: 120px;
			border: none;
			border-radius: 100%;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		textarea
		{
			width: 89.1%;
			height: 200px;
			padding: 5px;
			font-family: comic sans MS;
			border-radius: 10px;
			padding-right: 25px;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		#enviar
		{
			margin-top: -65px;
			margin-left: 32%;
			width: 16.5%;
			height: 73px;
			border-radius: 100%;
			background-image: url("img/send1.png");
			background-size: 72px;
			border: none;
			position: absolute;
			transition: 0.20s;
		}
		#enviar:active
		{
			background-image: url("img/send2.png");
			transition: 0.20s;
		}
		#icone
		{
			background-image: url("img/icone1.png");
			background-size: 20px;
			width: 20px;
			height: 20px;
			border: none;
			border-radius: 100%;
			position: absolute;
			margin-left: 24.4%;
			margin-top: 333px;
		}
		#icone:active
		{
			background-image: url("img/icone2.png");
		}
		#icone1
		{
			background-image: url("img/icone1.png");
			background-size: 20px;
			width: 20px;
			height: 20px;
			border: none;
			border-radius: 100%;
			position: absolute;
			margin-left: 24.4%;
			margin-top: 333px;
		}
		#icone1:active
		{
			background-image: url("img/icone2.png");
		}
		.fotochat
		{
			width: 45px;
			height: 45px;
			border-radius: 100%;
		}
		.emojichat
		{
			width: 15px;
			height: 15px;
			border-radius: 100%;
		}
		.mensagempadrao
		{
			border-radius: 80px 100px 100px 0px;
			padding-top: 5px;
			border-style: solid;
			max-width: 25%;
			background: white;
			border-width: 3px;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		.mensagemgrito
		{
			border-radius: 80px 100px 100px 0px;
			padding-top: 5px;
			max-width: 25%;
			background: white;
			border-style: solid;
			border-color: darkgray;
			border-width: 4px;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		.mensagemsussurro
		{
			border-radius: 80px 100px 100px 0px;
			max-width: 25%;
			background: white;
			padding-top: 5px;
			border-color: gray;
			border-style: dashed;
			border-width: 3px;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		.mensagempadrao1
		{
			border-radius: 100px 80px 0px 100px;
			float: right;
			max-width: 25%;
			padding-top: 5px;
			background: white;
			float: right;
			margin-left: 73%;
			border-style: solid;
			border-width: 3px;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		.mensagemgrito1
		{
			border-radius: 100px 80px 0px 100px;
			max-width: 25%;
			background: white;
			padding-top: 5px;
			margin-left: 73%;
			border-style: solid;
			float: right;
			border-color: darkgray;
			border-width: 4px;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		.mensagemsussurro1
		{
			border-radius: 100px 80px 0px 100px;
			max-width: 25%;
			background: white;
			padding-top: 5px;
			border-color: gray;
			margin-left: 73%;
			float: right;
			border-style: dashed;
			border-width: 3px;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		.fonte
		{
			font-family: comic sans ms;
			font-weight: none;
		}
		#nometi
		{
			font-size: 21px;
		}
		#legend
		{
			background: white;
			margin-top: 0px;
			border-radius: 5px 5px 0px 0px;
			margin-left: -1%;
			width: 67.8%;
			position: fixed;
			border-bottom: 5px solid lightgray;
		}
		#legend1
		{
			background: white;
			margin-top: 0px;
			border-radius: 5px 5px 0px 0px;
			margin-left: -1%;
			width: 67.8%;
			position: fixed;
			border-bottom: 5px solid lightgray;
		}
		#de
		{
			color: blue;
		}
		#para
		{
			color: red;
		}
		.coisinhas
		{
			width: 40px;
			height: 40px;
			position: absolute;
		}
		#sair
		{
			margin-top: -54px;
			margin-left: 44%;
		}
		#contatos
		{
			margin-top: -54px;
			margin-left: -46%;
			border-radius: 5px;
			background-image: url("img/contatos.png");
			background-size: 40px 40px;
			border: none;
		}
		#contatinhos
		{
			position: absolute;
			background: white;
			padding: 10px;
			max-height: 300px;
			overflow: auto;
			z-index: 99;
			border-radius: 5px 0px 0px 5px;
			border: 2px groove lightgray;
		}
		#contats
		{
			width: 50px;
			height: 50px;
			border-radius: 100%;

		}
		#linha 
		{
			border-bottom: 2px solid black;
		}
		.status
		{
			width: 15px;
			height: 15px;
		}
		#fechar
		{
			width: 11%;
			height: 20px;
			background-image: url('img/x1.png');
			background-color: none;
			background-size: 21px;
			border-radius: 100%;
			border: none;
		}
		#fic
		{
			font-size: 17.2px;
		}
	</style>
</html>