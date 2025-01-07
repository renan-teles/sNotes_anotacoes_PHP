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
    <script src="js/scriptAnotacaoLixeira.js" defer></script>
    <?php include('bootstrap/bootstrap.php');?>
</head>
<body class="bg-low-gray">
    <?php include('elementos/navbar.php');?>
    <main class="container my-4 p-4 rounded shadow bg-white">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <h4><i class="bi-trash me-2"></i>Lixeira</h4>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="anotacoes.php" class="btn btn-danger">Voltar</a>
            </div>
        </div>
        <hr>
        <section class="d-flex justify-content-center">
            <div class="col-12">
                <?php $anotacao->mostrarMensagem(); ?>
            </div>   
        </section>
        <section>
            <div class="col-12">
                <?php $anotacao->mostrarAnotacoesLixeira($_SESSION['userId']);?>
            </div>
        </section>
    </main>
</body>
</html>