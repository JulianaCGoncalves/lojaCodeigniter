<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title Loja Codeigniter></title>
</head>
<body>
	<h2>The Grocery Store Brazil.</h2>
	<h3>Confirmação de cadastro.</h3>
	<p>Olá:<?php echo $nome." ".$sobrenome?>.<br>
		Muito Obrigado por se cadastrar em nosso website.</p>
		<p> Para concluir seu cadastro e liberar sua conta para compras,clique no link abaixo.</p>
		<p> <a href="<?php echo base_url('cadastro/confirmar/'.md5($email))?>"> Confirmar cadastro no website!</a></p>
		<h4>Seja bem-vindo e boas compras!<br> The Grocery Brazil.</h4>
	</body>
	</html>