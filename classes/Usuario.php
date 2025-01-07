<?php

require_once 'Conexao.php';

class Usuario extends Conexao {
    private  $id, $nome, $email;

    public function getId(){return $this->id;}

    public function getNome(){return $this->nome;}

    public function getEmail(){return $this->email;}

    public function setId($id){$this->id = $id;}

    public function setNome($nome){$this->nome = $nome;}

    public function setEmail($email){$this->email = $email;}

    public function criarUsuario($nome, $email, $senha){
        $sql = 'INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)';
        $result = $this->getConexao()->prepare($sql);
        $result->bindParam(':nome', $nome);
        $result->bindParam(':email', $email);
        $result->bindParam(':senha', $senha);
        $result->execute();
    }

    public function editarUsuario($id, $campo, $conteudo){
        $sql = "UPDATE usuarios SET $campo = :conteudo WHERE id = :id";
        $result = $this->getConexao()->prepare($sql);
        $result->bindParam(':id', $id);
        $result->bindParam(':conteudo', $conteudo);
        $result->execute();
    }

    public function deletarUsuario($id){
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $result = $this->getConexao()->prepare($sql);
        $result->bindParam(':id', $id);
        $result->execute();
    }

    public function logar($email, $senha){
        session_start();
        $sql = 'SELECT * FROM usuarios WHERE email = :email';
        $result = $this->getConexao()->prepare($sql);
        $result->bindParam(':email', $email);
        $result->execute();
        if ($result->rowCount() > 0) {
            $user = $result->fetch(PDO::FETCH_ASSOC);
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['userName'] = $user['nome'];
                $_SESSION['userId'] = $user['id'];
            } else{
                $_SESSION['msg-usuario'] = 'Senha incorreta!';
            }
        } else{
            $_SESSION['msg-usuario'] = 'Usuário não encontrado!';
        }
    }

    public function retornarSenha($id){
        $sql = 'SELECT senha FROM usuarios WHERE id = :id';
        $result = $this->getConexao()->prepare($sql);
        $result->bindParam(':id', $id);
        $result->execute();
        $senha = $result->fetch(PDO::FETCH_ASSOC);        
        return $senha['senha'];
    }

    public function logout(){session_start(); session_destroy();}

    public function verificarLogin(){
        session_start();    
        if(!isset($_SESSION['userName'])){
            header('Location: index.php');
        }
    }

    public function mostrarPainel($idUsuario){
        $this->preencherAtributosObjeto($idUsuario);
        echo '
        <form action="validacao.php" method="POST" class="col-12 col-md-8 rounded p-4 shadow bg-white">
      
        <div class="row">
            <div class="col-12 col-sm-9 text-center text-sm-start">
                <h3>Editar Suas Informações</h3>
            </div>
            <div class="col-12 col-sm-3 text-center text-sm-end">
                <a href="anotacoes.php" class="btn btn-danger">Voltar</a>
            </div>
        </div>
        <hr>
        <div class="mb-3">
            <label for="editNome">Nome</label>
            <textarea id="editNome" type="text" class="form-control" name="editUsuarioNome" rows="1">'.$this->getNome().'</textarea>
        </div>
 
        <div class="mb-3">
            <label for="editEmail">Email</label>
            <textarea id="editEmail" class="form-control" name="editUsuarioEmail" rows="1">'.$this->getEmail().'</textarea>
        </div>

        <div class="mb-3">
            <hr>
            <p class="fs-5">Editar Senha:</p>
        </div>

        <input type="hidden" name="editUsuarioId" value='.$this->getId().'>

        <div class="mb-3">
            <label for="">Senha Atual</label>
            <input id="editSenhaAtual" type="password" placeholder="Digite Sua Senha Atual" class="form-control" name="editSenhaAtual">
        </div>

        <div class="mb-3">
            <label for="">Nova Senha</label>
            <input id="editNovaSenha" type="password" placeholder="Digite Sua nova Senha" class="form-control" name="editNovaSenha">
            <div class="form-text">OBS: Mínimo de 6 caracteres!</div>
        </div>

        <div class="mb-1 text-end"> 
            <button type="submit" id="btnEditarUsuario" name="editarInformacoes" class="btn btn-success">Editar Informações</button>
        </div></form>';
    }

    public function mostrarMensagem(){
        if(isset($_SESSION['msg'])){  
                echo '
                <div class="col-12">
                        <div class="text-start alert alert-info alert-dismissible fade show" role="alert"><i class="bi-info-circle me-1"></i>'.$_SESSION['msg'].'
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button> 
                        </div>
                </div>
                ';
                unset($_SESSION['msg']);
        }
    }

    public function preencherAtributosObjeto($id){
        $sql = 'SELECT * FROM usuarios WHERE id = :id';
        $result = $this->getConexao()->prepare($sql);
        $result->bindParam(':id', $id);
        $result->execute();
        $dados = $result->fetch(PDO::FETCH_ASSOC);
        if ($dados) {
            $this->setId($dados['id']);
            $this->setNome($dados['nome']);
            $this->setEmail($dados['email']);
        }
    }
}
?>

<?php $usuario = new Usuario(); ?>