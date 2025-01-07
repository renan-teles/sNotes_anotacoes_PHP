<?php
    require_once 'classes/Anotacao.php';
    require_once 'classes/Usuario.php';
    $usuario->verificarLogin();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNOTES</title>
    <link rel="stylesheet" href="css/estilo.css">
    <?php include('bootstrap/bootstrap.php');?>
</head>
<body class="bg-low-gray">
    <?php include('elementos/navbar.php');?>
    <main class="container my-5"> 
        <section class="d-flex justify-content-center">
            <div class="col-12 col-md-8">
                <?php $usuario->mostrarMensagem(); ?>
            </div>   
        </section>
        <section class="d-flex justify-content-center">
            <?php $usuario->mostrarPainel($_SESSION['userId']); ?>
        </section>
    </main>
</body>
</html>