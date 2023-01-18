<?php
require_once 'pessoa.php';
$p = new Pessoa("crudpdo","localhost","root","");
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cadastro Pessoa</title>
	<link rel="stylesheet" href="estilo.css"
</head>
<body>
	<?php
	if(isset($_POST['nome'])){//CLICOU NO BOTÃO CADASTRAR OU NO BOTÃO EDITAR
		if(isset($_GET['id_up']) && !empty($_GET['id_up'])){
			$id_upd = addslashes($_GET['id_up']);
			$nome = addslashes($_POST['nome']);
			$telefone = addslashes($_POST['telefone']);
			$email = addslashes($_POST['email']);
			if(!empty($nome) && !empty($telefone) && !empty($email)){
				//EDITAR
			!$p->atualizarDados($id_upd,$nome,$telefone,$email);
			header("location: index.php");		
				
			} else{
				?>
				<div>
				<img src="aviso.jpg">
				<h4>Preencha todos os campos!</h4>
				</div>
				<?php
			}

		//--------CADASTRAR------	
		} else{
			$nome = addslashes($_POST['nome']);
			$telefone = addslashes($_POST['telefone']);
			$email = addslashes($_POST['email']);
			if(!empty($nome) && !empty($telefone) && !empty($email)){
				//cadastrar
				if(!$p->cadastrarPessoas($nome,$telefone,$email));{		
					?>
					<div>
					<img src="aviso.jpg">
					<h4>E-mail já está cadastrado!</h4>
					</div>
					<?php
				}
			} else{
				?>
				<div>
					<img src="aviso.jpg">
					<h4>Preencha todos os campos</h4>
				</div>
				<?php
			}
		}

	}
	?>
	<?php
		if(isset($_GET['id_up'])){//SE A PESSOA CLICOU NO BOTÃO EDITAR
			$id_update = addslashes($_GET['id_up']);
			$res = $p->buscarDadosPessoa($id_update);
		}
	?>
	<section id="esquerda">
		<form method="POST">
			<h2>Cadastrar Pessoa</h2>
			<label for="nome">Nome</label>
			<input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res['nome'];}?>">
			<label for="telefone">Telefone</label>
			<input type="text" name="telefone" id="telefone" value="<?php if(isset($res)){echo $res['telefone'];}?>">
			<label for="email">E-mail</label>
			<input type="email" name="email" id="email" value="<?php if(isset($res)){echo $res['email'];}?>">
			<input type="submit" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
		</form>
	</section>
	
	<section id="direita">
		<table>
			<tr id="titulo">
				<td>NOME</td>
				<td>TELEFONE</td>
				<td colspan="2">EMAIL</td>
			</tr>
		<?php
			$dados = $p->buscarDados();
			if(count($dados)> 0){
				for($i=0;$i < count($dados); $i++){
					echo "<tr>";
					foreach($dados[$i] as $k => $v){
						if($k != "id"){		
							echo "<td>".$v."</td>";
						}
					}
					?> 
					<td>
						<a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
						<a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
					</td> 
					<?php
					echo "</tr>";
				}
			} else {
				?>
					<div class="aviso">
						<h4>Ainda não há pessoas cadastradas!</h4>
					</div>
				
				<?php
			}
		?>
		
			<tr>

				
			</tr>
		</table>
	</section>
</body
</html>

<?php
	if(isset($_GET['id'])){
		$id_pessoa = addslashes($_GET['id']);
		$p->excluirPessoa($id_pessoa);
		header("location: index.php");
	}

?>

