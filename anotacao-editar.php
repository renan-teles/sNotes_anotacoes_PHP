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
    <script src="js/scriptAnotacaoEditar.js" defer></script>
</head>
<body class="bg-low-gray">
    <?php include('elementos/navbar.php');?>
    <main class="container d-flex justify-content-center my-5">
        <section class="justify-content-center">
            <div class="col-12 col-sm-8">
                <?php $usuario->mostrarMensagem(); ?>
            </div>   
        </section>
        <?php $anotacao->formEditarAnotacao($_POST['anotacaoID']); ?>
    </main>
</body>
</html>