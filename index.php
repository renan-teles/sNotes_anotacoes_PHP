<?php
    session_start();
    require_once 'classes/Usuario.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNOTES - Login</title>
    <link rel="stylesheet" href="css/estilo.css">
    <?php include('bootstrap/bootstrap.php');?> 
    <script src="js/scriptLogCad.js" defer></script>
</head>
<body class="bg-img">
    <main class="container">
        <div class="row hgt-100">
            <!--LOGIN-->
            <div id="divLogin" class="col d-flex justify-content-center align-items-center">
                <form action="validacao.php" method="POST" class="col-12 col-md-5 p-4 shadow rounded" style="background-color: white;">
                    <div class="mb-3 text-center">
                        <h2>SNOTES - Entrar</h2>
                        <p>Entre e tenha suas anotações em um só lugar!</p><hr>
                        <?php $usuario->mostrarMensagem(); ?>
                    </div>
                    <div class="mb-3 form-floating">
                        <input required type="email" name="logUsuarioEmail" placeholder=" " class="form-control">
                        <label><i class="bi-envelope-at me-2"></i>Email</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input required type="password" name="logUsuarioSenha" placeholder=" " class="form-control">
                        <label><i class="bi-lock me-2"></i>Senha</label>
                    </div><hr>
                    <div class="mb-3">
                        <button type="submit" name="btnLogar" class="btn btn-primary w-100">Entrar</button>
                    </div>
                    <div class="text-center">
                        <span>Não tem conta? Então cadastrece!
                            <button name="btnToggleLogCad" type="button" class="btn text-primary w-100">Cadastrar</button>
                        </span>
                    </div>
                </form>
            </div>
            <!--CADASTRO-->
            <div id="divCadastro" class="col d-flex justify-content-center align-items-center d-none">
                <form action="validacao.php" method="POST" class="col-12 col-md-5 p-4 shadow rounded" style="background-color: white;">
                    <div class="mb-3 text-center">
                        <h2>SNOTES - Cadastrar</h2>
                        <p>Cadastre-se e tenha suas anotações em só lugar!</p><hr>
                    </div>
                    <div class="mb-3">
                        <label><i class="bi-person me-2 ms-1"></i>Nome de Usuário</label>
                        <input required type="text" id="usuarioNome" name="cadUsuarioNome" placeholder="Digite Seu Nome" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label><i class="bi-envelope-at me-2 ms-1"></i>Email</label>
                        <input required type="email" id="usuarioEmail" name="cadUsuarioEmail" placeholder="Digite Seu Email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label><i class="bi-lock me-2 ms-1"></i>Senha</label>
                        <input required id="usuarioSenha" type="password" name="cadUsuarioSenha" placeholder="Crie Sua Senha" class="form-control">
                        <div class="form-text">OBS: Mínimo de 6 caracteres!</div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" id="btnCadastrar" name="btnCadastrar" class="btn btn-primary w-100">Cadastrar</button>
                    </div>
                    <div class="text-center">
                        <span>Já tem conta? Então entre com ela!
                            <button name="btnToggleLogCad" type="button" class="btn text-primary w-100">Logar</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>

