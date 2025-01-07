<?php
session_start();
require_once 'classes/Anotacao.php'; 
require_once 'classes/Usuario.php'; 

// Função para redirecionamento com mensagem
function redirecionar($url, $mensagem = null) {
    if ($mensagem) {
        $_SESSION['msg'] = $mensagem;
    }
    header("Location: $url");
    exit;
}

// LOGIN USUÁRIO
function loginUsuario($usuario) {
    if (isset($_POST['logUsuarioEmail'], $_POST['logUsuarioSenha'])) {
        $email = trim($_POST['logUsuarioEmail']);
        $senha = trim($_POST['logUsuarioSenha']);

        if (!empty($email) && !empty($senha)) {
            $usuario->logar($email, $senha);
            redirecionar('anotacoes.php');
        } else {
            redirecionar('index.php', "Por Favor, Preencha Todos os Campos Durante o Login!");
        }
    }
}

// CADASTRO USUÁRIO
function cadastrarUsuario($usuario) {
    if (isset($_POST['cadUsuarioNome'], $_POST['cadUsuarioEmail'], $_POST['cadUsuarioSenha'])) {
        $nome = trim($_POST['cadUsuarioNome']);
        $email = trim($_POST['cadUsuarioEmail']);
        $senha = trim($_POST['cadUsuarioSenha']);

        if (strlen($senha) < 6) {
            redirecionar('index.php', 'Sua Senha Deve Conter no Mínimo 6 Caracteres!');
        } elseif (!empty($nome) && !empty($email) && !empty($senha)) {
            $usuario->criarUsuario($nome, $email, password_hash($senha, PASSWORD_DEFAULT));
            redirecionar('index.php', "Usuário Cadastrado Com Sucesso!");
        } else {
            redirecionar('index.php', "Por Favor, Preencha Todos os Campos Durante o Cadastro!");
        }
    }
}

// LOGOUT
function logoutUsuario($usuario) {
    $usuario->logout();
    redirecionar('index.php');
}

// EDITAR USUÁRIO
function editarUsuario($usuario) {
    if (isset($_POST['editUsuarioId'], $_POST['editUsuarioNome'], $_POST['editUsuarioEmail'], $_POST['editSenhaAtual'], $_POST['editNovaSenha'])) {
        $id = $_POST['editUsuarioId'];
        $nome = trim($_POST['editUsuarioNome']);
        $email = trim($_POST['editUsuarioEmail']);
        $senhaAtual = trim($_POST['editSenhaAtual']);
        $novaSenha = trim($_POST['editNovaSenha']);

        if (strlen($novaSenha) > 0 && strlen($novaSenha) < 6) {
            redirecionar('painel-usuario.php', 'Sua Senha Deve Conter no Mínimo 6 Caracteres!');
        }

        if (!empty($id) && !empty($nome) && !empty($email)) {
            $usuario->editarUsuario($id, 'nome', $nome);
            $usuario->editarUsuario($id, 'email', $email);

            if (!empty($novaSenha) && password_verify($senhaAtual, $usuario->retornarSenha($_SESSION['userId']))) {
                $usuario->editarUsuario($id, 'senha', password_hash($novaSenha, PASSWORD_DEFAULT));
                $mensagem = 'Usuário Editado Com Sucesso! Senha Atualizada.';
            } elseif (!empty($novaSenha)) {
                $mensagem = 'Senha Atual Incorreta. O Restante das Informações Foram Atualizadas.';
            } else {
                $mensagem = 'Usuário Editado Com Sucesso! A Senha Não Foi Alterada.';
            }

            redirecionar('painel-usuario.php', $mensagem);
        } else {
            redirecionar('painel-usuario.php', 'Preencha Todos os Campos Obrigatórios (Nome, Email).');
        }
    }
}

// ADICIONAR ANOTACAO
function adicionarAnotacao($anotacao) {
    if (isset($_POST['anotacaoTitulo'], $_POST['anotacaoTexto'], $_POST['anotacaoData'], $_POST['anotacaoHora'])) {
        $idUser = $_SESSION['userId'];
        $titulo = trim($_POST['anotacaoTitulo']);
        $texto = trim($_POST['anotacaoTexto']);
        $hora = trim($_POST['anotacaoHora']);
        $data = trim($_POST['anotacaoData']);

        if (!empty($idUser) && !empty($titulo) && !empty($texto) && !empty($data) && !empty($hora)) {
            $anotacao->criarAnotacao($idUser, $titulo, $texto, $data, $hora);
            redirecionar('anotacoes.php', 'Anotação Criada Com Sucesso!');
        } else {
            redirecionar('anotacoes.php', 'Por Favor, Preencha Todos os Campos Para Criar Uma Anotação!');
        }
    }
}

// EXCLUIR ANOTACAO
function excluirAnotacao($anotacao) {
    if (isset($_POST['idAnotacao']) && !empty($_POST['idAnotacao'])) {
        $anotacao->deletarAnotacao($_POST['idAnotacao']);
        redirecionar('anotacao-lixeira.php', 'Anotação Deletada Com Sucesso!');
    } else {
        redirecionar('anotacao-lixeira.php', 'Erro ao Deletar Anotação');
    }
}

// RESTAURAR ANOTACAO
function restaurarAnotacao($anotacao) {
    if (isset($_POST['anotacaoID']) && !empty($_POST['anotacaoID'])) {
        $anotacao->editarAnotacao($_POST['anotacaoID'], 'naLixeira', 'n');
        redirecionar('anotacoes.php', 'Anotação Restaurada Com Sucesso!');
    } else {
        redirecionar('anotacao-lixeira.php', 'Erro ao Restaurar a Anotação');
    }
}

// EDITAR ANOTACAO
function editarAnotacao($anotacao) {
    if (isset($_POST['anotacaoId'], $_POST['anotacaoTitulo'], $_POST['anotacaoTexto'])) {
        $id = $_POST['anotacaoId'];
        $titulo = trim($_POST['anotacaoTitulo']);
        $texto = trim($_POST['anotacaoTexto']);

        if (!empty($id) && !empty($titulo) && !empty($texto)) {
            $anotacao->editarAnotacao($id, 'titulo', $titulo);
            $anotacao->editarAnotacao($id, 'anotacao', $texto);
            redirecionar('anotacoes.php', 'Anotação Editada Com Sucesso!');
        } else {
            redirecionar('anotacoes-editar.php', 'Para Editar a Anotação, Não Deixe Campos Vazios!');
        }
    }
}

// MOVER ANOTACAO PARA LIXEIRA
function moverParaLixeira($anotacao) {
    if (isset($_POST['idAnotacao']) && !empty($_POST['idAnotacao'])) {
        $anotacao->editarAnotacao($_POST['idAnotacao'], 'naLixeira', 's');
        redirecionar('anotacoes.php', 'Anotação Movida Para a Lixeira!');
    } else {
        redirecionar('anotacoes.php', 'Erro ao Mover Para a Lixeira!');
    }
}

if (isset($_POST['btnLogar'])) {
    loginUsuario($usuario);
} elseif (isset($_POST['btnCadastrar'])) {
    cadastrarUsuario($usuario);
} elseif (isset($_GET['logout'])) {
    logoutUsuario($usuario);
} elseif (isset($_POST['editarInformacoes'])) {
    editarUsuario($usuario);
} elseif (isset($_POST['addAnotacao'])) {
    adicionarAnotacao($anotacao);
} elseif (isset($_POST['excluirAnotacao'])) {
    excluirAnotacao($anotacao);
} elseif (isset($_POST['btnAnotacaoRestaurar'])) {
    restaurarAnotacao($anotacao);
} elseif (isset($_POST['editarAnotacao'])) {
    editarAnotacao($anotacao);
} else if(isset($_POST['moverAnotacao'])) {
    moverParaLixeira($anotacao);
} else{
    redirecionar("index.php");
}
?>