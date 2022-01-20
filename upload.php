<?php
header("Content-type: text/html; charset=utf-8");
include "conexao.php";

$target_dir="uploads/";
$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$uploadOk=1; //se for verdadeiro recebe 1 se for falso recebe 0
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$nome=$_POST["nome"];
$valor=$_POST["valor"];
$especificacoes=$_POST["especificacoes"];
$estoque=$_POST["estoque"];

//echo $target_file;   //exibe o endereçamento da imagem que será salva na pasta upload

//checar se a imagem é uma imagem
if(isset($_POST["submit"])){
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check!=false){
        echo "<br>é uma Imagem - ".$check["mime"];
        $uploadOk=1;
    } else {
        echo "<br>não é uma Imagem - ".$check["mime"];
        $uploadOk=0;
    }
}

#checar se arquivo já existe na pasta upload
if (file_exists($target_file)) {
    echo "<br>Arquivo já existe.";
    $uploadOk = 0;
}

#checar o tamanho do arquivo apra upload
//só permite o envio de aquivo até 500mb  
if ($_FILES["fileToUpload"]["size"] >25000000) {
    echo "<br>Arquivo muito grande";
    $uploadOk = 0;
}

#quais arquivos podem ser upados
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType!="jfif" ) {
    echo "<br>Sorry, apenas JPG, JPEG, PNG e GIF são permitidos.";
    $uploadOk = 0;
}

# se upload = 0 indica algum erro e não faz o upload
if ($uploadOk == 0) {
    echo "<br>Desculpe, Arquivo não upado.";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<br>O arquivo <b>". basename( $_FILES["fileToUpload"]["name"]). "</b> foi transferido.";
        $sql = "insert into tblblog (nome,imagem,valor,especificacoes,estoque) values ('$nome','$target_file','$valor','$especificacoes','$estoque')";
        $qry= mysqli_query($con,$sql);
        header("Location:listar.php");
    } else {
        echo "Desculpe, alg deu errado na transferência do arquivo.";
    }
}