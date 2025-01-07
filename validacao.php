<?php

session_start();

require_once 'classes/Anotacao.php'; 

require_once 'classes/Usuario.php'; 

//LOGIN USUÁRIO - OK
if(isset($_POST['btnLogar'])){
    if(isset($_POST['logUsuarioEmail'], $_POST['logUsuarioSenha'])){
        $email = trim($_POST['logUsuarioEmail']);
        $senha = trim($_POST['logUsuarioSenha']);
        if(!empty($email) && !empty($senha)){
            $usuario->logar($email, $senha);
            header('Location: anotacoes.php');
        } else{
            $_SESSION['msg-usuario'] = "Por Favor, Preecha Todos os Campos Durante o Login!";
            header('Location: index.php');
        }
    } else{
        $_SESSION['msg-usuario'] = "Por Favor, Preecha Todos os Campos Durante o Login!";
        header('Location: index.php');
    }  
}

//CADASTRO USUÁRIO - OK
if(isset($_POST['btnCadastrar'])){
    if(isset($_POST['cadUsuarioNome'], $_POST['cadUsuarioEmail'], $_POST['cadUsuarioSenha'])){
        if(strlen(trim($_POST['cadUsuarioSenha'] < 6))){
            $_SESSION['msg-usuario'] = 'Sua Senha Deve Conter no Mínimo 6 Caracteres!';
            header('Location: index.php');
        } else{
            $nome = trim($_POST['cadUsuarioNome']);
            $email = trim($_POST['cadUsuarioEmail']);
            $senha = password_hash(trim($_POST['cadUsuarioSenha']), PASSWORD_DEFAULT);
            if(!empty($nome) && !empty($email) && !empty($senha)){
                $usuario->criarUsuario($nome, $email, $senha);
                header('Location: index.php');
                $_SESSION['msg-usuario'] = "Usuário Cadastrado Com Sucesso!";
            } else{
                $_SESSION['msg-usuario'] = "Por Favor, Preecha Todos os Campos Durante o Cadastro!";
                header('Location: index.php');
            }
        }
    } else{
        $_SESSION['msg-usuario'] = 'Dados Insuficientes Para Realizar a Edição!';
        header('Location: index.php');
    }
}

//LOGOUT - OK
if(isset($_GET['logout'])){
    $usuario->logout();
    header('Location: index.php');
}

//EDITAR USUÁRIO - OK
if (isset($_POST['editarInformacoes'])) {
    if (isset($_POST['editUsuarioId'], $_POST['editUsuarioNome'], $_POST['editUsuarioEmail'], $_POST['editSenhaAtual'], $_POST['editNovaSenha'])) {
       
        if(!empty($_POST['editSenhaAtual']) && !empty($_POST['editNovaSenha']) && strlen(trim($_POST['editNovaSenha'] < 6))){
            $_SESSION['msg-usuario'] = 'Sua Senha Deve Conter no Mínimo 6 Caracteres!';
            header('Location: painel-usuario.php');
        } else {
            $id = $_POST['editUsuarioId'];
            $nome = trim($_POST['editUsuarioNome']);
            $email = trim($_POST['editUsuarioEmail']);
            $senhaAtual = trim($_POST['editSenhaAtual']);
            $novaSenha = trim($_POST['editNovaSenha']);
            if (!empty($id) && !empty($nome) && !empty($email)) {
                $usuario->editarUsuario($id, 'nome', $nome);
                $usuario->editarUsuario($id, 'email', $email);

                if (!empty($novaSenha) && !empty($senhaAtual)) {
                    $senhaOriginal = $usuario->retornarSenha($_SESSION['userId']);
                    if (password_verify($senhaAtual, $senhaOriginal)) {
                        $usuario->editarUsuario($id, 'senha', password_hash($novaSenha, PASSWORD_DEFAULT));
                        $_SESSION['msg-usuario'] = 'Usuário Editado Com Sucesso! Senha Atualizada.';
                    } else {
                        $_SESSION['msg-usuario'] = 'Senha Atual Incorreta. O Restante das Informações Foram Atualizadas.';
                    }
                } else {
                    $_SESSION['msg-usuario'] = 'Usuário Editado Com Sucesso! A Senha Não Foi Alterada.';
                }
            header('Location: painel-usuario.php');
            } else {
                $_SESSION['msg-usuario'] = 'Preencha Todos os Campos Obrigatórios (Nome, Email).';
                header('Location: painel-usuario.php');
            }
        }
    } else {
        $_SESSION['msg-usuario'] = 'Dados Insuficientes Para Realizar a Edição.';
        header('Location: painel-usuario.php');
    }
}

//ADICIONAR ANOTACAO - OK
if(isset($_POST['addAnotacao'])){
    if(isset($_POST['anotacaoTitulo'], $_POST['anotacaoTexto'], $_POST['anotacaoData'], $_POST['anotacaoHora'])){
        $idUser = $_SESSION['userId'];
        $titulo = trim($_POST['anotacaoTitulo']);
        $texto = trim($_POST['anotacaoTexto']);
        $hora = trim($_POST['anotacaoHora']);
        $data = trim($_POST['anotacaoData']);
        if(!empty($idUser) && !empty($titulo) && !empty($texto) && !empty($data) && !empty($hora)){
            $anotacao->criarAnotacao($idUser, $titulo, $texto, $data, $hora);
            $_SESSION['msg-anotacao'] = 'Anotação Criada Com Sucesso!';
            header('Location: anotacoes.php');
        } else{
            $_SESSION['msg-anotacao'] = 'Por Favor, Preecha Todos os Campos Para Criar Uma Anotação!';
            header('Location: anotacoes.php');
        }
    } else{
        $_SESSION['msg-usuario'] = 'Dados Insuficientes Para Criar Uma Anotação.';
        header('Location: anotacoes.php');
    }
}

//EXCLUIR ANOTACAO - OK
if(isset($_POST['excluirAnotacao'])){
    if(isset($_POST['idAnotacao'])){
        $id = $_POST['idAnotacao'];
        if(!empty($id)){
            $anotacao->deletarAnotacao($id);
            $_SESSION['msg-anotacao'] = 'Anotação Deletada Com Sucesso!';
            header('Location: anotacao-lixeira.php');
        } else{
            $_SESSION['msg-anotacao'] = 'Erro ao Deletar Anotação';
            header('Location: anotacao-lixeira.php');
        }
    } else{
        $_SESSION['msg-anotacao'] = 'Dados Insuficientes Para Excluir a Anotação!';
        header('Location: anotacao-lixeira.php');
    }
}

//RESTAURAR ANOTAÇÃO - OK
if(isset($_POST['btnAnotacaoRestaurar'])){
    if(isset($_POST['anotacaoID'])){
        $id = $_POST['anotacaoID'];
        if(!empty($id)){
            $anotacao->editarAnotacao($id, 'naLixeira', 'n');
            $_SESSION['msg-anotacao'] = 'Anotação Restaurada Com Sucesso!';
            header('Location: anotacoes.php');
        } else{
            $_SESSION['msg-anotacao'] = 'Erro ao Restaurar a Anotação';
            header('Location: anotacao-lixeira.php');
        }
    } else{
        $_SESSION['msg-anotacao'] = 'Dados Insuficientes Para Restaurar a Anotação!';
        header('Location: anotacao-lixeira.php');
    }
}

//EDITAR ANOTACAO - OK
if(isset($_POST['editarAnotacao'])){
    if(isset($_POST['anotacaoId'],$_POST['anotacaoTitulo'], $_POST['anotacaoTexto'])){
        $id = $_POST['anotacaoId'];
        $titulo = trim($_POST['anotacaoTitulo']);
        $texto = trim($_POST['anotacaoTexto']);
        if(!empty($id) && !empty($titulo) && !empty($texto)){
            $anotacao->editarAnotacao($id, 'titulo', $titulo);
            $anotacao->editarAnotacao($id, 'anotacao', $texto);
            $_SESSION['msg-anotacao'] = 'Anotação Editada Com Sucesso!';
            header('Location: anotacoes.php');
        } else{
            $_SESSION['msg-anotacao'] = 'Para Editar a Anotação, Não Deixe Campos Vazios!';
            header('Location: anotacoes-editar.php');
        }
    } else{
        $_SESSION['msg-anotacao'] = 'Dados Insuficientes Para Realizar a Edição da Anotação!';
        header('Location: anotacoes-editar.php');
    }
}

//MOVER ANOTAÇÃO PARA A LIXEIRA - OK
if(isset($_POST['moverAnotacao'])){
    if(isset($_POST['idAnotacao'])) {
        $id = $_POST['idAnotacao'];
        if(!empty($id)){
            $anotacao->editarAnotacao($id, 'naLixeira', 's');
            $_SESSION['msg-anotacao'] = 'Anotação Movida Para a Lixeira!';
            header('Location: anotacoes.php');
        } else{
            $_SESSION['msg-anotacao'] = 'Erro ao Mover Para a Lixeira!';
            header('Location: anotacoes.php');
        }
    } else{
        $_SESSION['msg-anotacao'] = 'Dados Insuficientes Para Mover Para a Lixeira!';
        header('Location: anotacoes.php');
    }
}
?>