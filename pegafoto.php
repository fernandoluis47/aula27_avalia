<?php
$idproduto = isset($_GET["idproduto"]) ? $_GET["idproduto"]:null;
$op = isset($_GET["op"]) ? $_GET["op"]: null;
include "menu.php";

try {
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $bd = "bdblog";
    $con = new PDO("mysql:host=$servidor;dbname=$bd",$usuario,$senha);

    if($idproduto){
      //estou buscando os dados do cliente no BD
      $sql = "SELECT * FROM  tblprodutos where idproduto= :idproduto";
      $stmt = $con->prepare($sql);
      $stmt->bindValue(":idproduto",$idproduto);
      $stmt->execute();
      $produto = $stmt->fetch(PDO::FETCH_OBJ);
      //var_dump($cliente);
  }
    

    if ($op=="del") {
      $sql = "DELETE from tblprodutos where idproduto= :idproduto";
      $stmt = $con->prepare($sql);
      $stmt->bindValue(":idproduto",$idproduto);
      $stmt->execute();
      header("Location:listar.php");
    }

    if ($_POST) {
      if ($_POST["idproduto"]) {
        $sql = "UPDATE tblprodutos set nome=:nome,imagem=:imagem,valor=:valor,estoque=:estoque,especificacoes=:especificacoes where idproduto=:idproduto ";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":nome", $_POST["nome"]);
        $stmt->bindValue(":imagem", $_POST["imagem"]);
        $stmt->bindValue(":valor",$_POST["valor"]);
        $stmt->bindValue(":estoque",$_POST["estoque"]);
        $stmt->bindValue(":especificacoes",$_POST["especificacoes"]);
        $stmt->bindValue(":idproduto",$_POST["idproduto"]);
        $stmt->execute();
      } else {
        $sql = "INSERT into tblprodutos(nome,valor,estoque,especificacoes) values(:nome,:valor,:estoque,:especificacoes)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":nome",$_POST["nome"]);
        $stmt->bindValue(":valor",$_POST["valor"]);
        $stmt->bindValue(":estoque",$_POST["estoque"]);
        $stmt->bindValue(":especificacoes",$_POST["especificacoes"]);
        
        $stmt->execute();
      }
      header("Location:listar.php");
    }
} catch (PDOException $e) {
    echo "Erro: ".$e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Formulário de Produtos</title>
</head>
<body>
   
    
    <div class="container">
    <h1>Formulário de Cadastro de Produtos</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nome do Produto</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo isset($produto) ? $produto->nome : null ?>" name="nome">
            
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Foto do Produto</label>
            <input type="file" class="form-control" value="<?php// echo isset($produto) ? $produto->imagem : null ?>" name="fileToUpload" id="fileToUpload">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Valor do Produto</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo isset($produto) ? $produto->valor : null ?>" name="valor">
            
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Especificações</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo isset($produto) ? $produto->estoquemax : null ?>" name="estoquemax">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Estoque</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo isset($produto) ? $produto->estoque : null ?>" name="estoque">
            
        </div>
       
        <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
        <!--input type submit value cadastrar-->
        </form>
        
            
            
        
        
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>