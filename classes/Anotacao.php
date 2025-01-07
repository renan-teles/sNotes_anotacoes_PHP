<?php

require_once 'Conexao.php';

class Anotacao extends Conexao {
    private $id, $idUsuario,$titulo, $anotacao, $dataCriada, $horaCriada;

    public function getId() {return $this->id;}

    public function getIdUsuario() {return $this->idUsuario;}

    public function getTitulo() {return $this->titulo;}

    public function getAnotacao() {return $this->anotacao;}

    public function getDataCriada() {return $this->dataCriada;}

    public function getHoraCriada() {return $this->horaCriada;}

    public function setId($id) {$this->id = $id;}

    public function setIdUsuario($idUsuario) {$this->idUsuario = $idUsuario;}

    public function setTitulo($titulo) {$this->titulo = $titulo;}

    public function setAnotacao($anotacao) {$this->anotacao = $anotacao;}

    public function setDataCriada($dataCriada) {$this->dataCriada = $dataCriada;}

    public function setHoraCriada($horaCriada) {$this->horaCriada = $horaCriada;}

    public function criarAnotacao($id_usuario, $titulo, $anotacao, $dataCriada, $horaCriada){
        $sql = 'INSERT INTO anotacoes (id_usuario, titulo, anotacao, dataCriada, horaCriada, naLixeira) VALUES (:idUser, :titulo, :anotacao, :dataCriada, :horaCriada, :status)';
        $result = $this->conexao->prepare($sql);
        $result->bindParam(':idUser', $id_usuario);
        $result->bindParam(':titulo', $titulo);
        $result->bindParam(':anotacao', $anotacao);
        $result->bindParam(':dataCriada', $dataCriada);
        $result->bindParam(':horaCriada', $horaCriada);
        $result->bindValue(':status', 'n');
        $result->execute();
    }

    public function editarAnotacao($id, $campo, $conteudo){
        $sql = "UPDATE anotacoes SET $campo = :conteudo WHERE id = :id";
        $result = $this->conexao->prepare($sql);
        $result->bindParam(':id', $id);
        $result->bindParam(':conteudo', $conteudo);
        $result->execute();
    }

    public function deletarAnotacao($id){
        $sql = "DELETE FROM anotacoes WHERE id = :id";
        $result = $this->conexao->prepare($sql);
        $result->bindParam(':id', $id);
        $result->execute();
    }

    public function mostrarAnotacoes($idUsuario){
        $sql = "SELECT * FROM anotacoes WHERE id_usuario = :id AND naLixeira = :status ORDER BY titulo ASC";
        $result = $this->conexao->prepare($sql);
        $result->bindParam(':id', $idUsuario);
        $result->bindValue(':status', 'n');
        $result->execute();
        $anotacoes = $result->fetchAll(PDO::FETCH_ASSOC);

        if ($anotacoes) {
            foreach ($anotacoes as $anotacao) {
             $this->setId($anotacao['id']);
             $this->setTitulo($anotacao['titulo']);
             $this->setAnotacao($anotacao['anotacao']);
             $this->setDataCriada($anotacao['dataCriada']);
             $this->setHoraCriada($anotacao['horaCriada']);
                echo '
                <div class="card mb-2 shadow-sm">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="card-body">
                            <h5 class="card-title">'.$this->getTitulo().'</h5>
                            <p class="card-text oneline">'.$this->getAnotacao().'</p>
                            <p class="card-text"><small class="text-body-secondary">Criado em '.date('d/m/Y', strtotime($this->getDataCriada())).', às '.date('H:i', strtotime($this->getHoraCriada())).'</small></p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 d-flex align-items-center justify-content-center mb-lg-0 mb-2">
                    <form action="anotacao-ver.php" method="POST">
                        <input name="anotacaoID" type="hidden" value='.$this->getId().'>
                        <button type="submit" class="btn btn-outline-success m-1"><i class="bi-eye-fill me-1"></i>Ver</button>
                    </form>
                    <form action="anotacao-editar.php" method="POST">
                        <input name="anotacaoID" type="hidden" value='.$this->getId().'>
                        <button class="btn btn-outline-secondary m-1"><i class="bi-pencil-fill me-1"></i>Editar</button>
                    </form>
                       <button name="btnAnotacaoJogarLixeira" class="btn btn-outline-danger m-1" value='.$this->getId().'><i class="bi-trash-fill me-1"></i>Excluir</button>
                    </div>
                </div>
            </div>';
            }
        } else {
            echo '<h5>Você não possui Anotacões.</h5>';
        }
    }

    public function mostrarAnotacao($idAnotacao){
        $this->preecherAtributosObjeto($idAnotacao);
        echo '
        <form action="validacao.php" method="POST" class="col-12 col-md-8 rounded p-4 shadow bg-white">
        <div class="row">
            <div class="col-12 col-sm-9 text-center text-sm-start">
                <h3>'.$this->getTitulo().'</h3>
            </div>
            <div class="col-12 col-sm-3 text-center text-sm-end">
                <a href="anotacoes.php" class="btn btn-danger">Voltar</a>
            </div>
        </div>
        <hr>
       <div class="mb-3">
           <p>'.$this->getAnotacao().'</p>
       </div>

       <div class="mb-3">
           <p>Criado em '.date('d/m/Y', strtotime($this->getDataCriada())).' as '.date('H:i', strtotime($this->getHoraCriada())).'</p>
       </div>
        </form>
        ';
    }

    public function formEditarAnotacao($idAnotacao){
        $this->preecherAtributosObjeto($idAnotacao);
        echo '
        <form action="validacao.php" method="POST" class="col-12 col-md-8 rounded p-4 shadow bg-white">
        <div class="row">
            <div class="col-12 col-sm-9 text-center text-sm-start ">
                <h3>Editar Anotacão</h3>
            </div>
            <div class="col-12 col-sm-3 text-center text-sm-end">
                <a href="anotacoes.php" class="btn btn-danger">Voltar</a>
            </div>
        </div>
        <hr>
        <div class="mb-3">
            <label for="titulo">Título</label>
            <textarea id="titulo" type="text" class="form-control" name="anotacaoTitulo" rows="1">'.$this->getTitulo().'</textarea>
        </div>
 
        <div class="mb-3">
            <label for="anotacao">Anotação</label>
            <textarea id="anotacao" class="form-control" name="anotacaoTexto" id="anotacao" rows="10">'.$this->getAnotacao().'</textarea>
        </div>
        <input name="anotacaoId" type="hidden" value='.$this->getId().'>
        <div class="mb-1 text-end">
            <button type="submit" id="btnEditarAnotacao" name="editarAnotacao" class="btn btn-success">Editar Anotacao</button>
        </div></form>';
    }

    public function mostrarAnotacoesLixeira($idUsuario){
        $sql = "SELECT * FROM anotacoes WHERE id_usuario = :id AND naLixeira = :status ORDER BY titulo ASC";
        $result = $this->conexao->prepare($sql);
        $result->bindParam(':id', $idUsuario);
        $result->bindValue(':status', 's');
        $result->execute();
        $anotacoes = $result->fetchAll(PDO::FETCH_ASSOC);

        if ($anotacoes) {
            foreach ($anotacoes as $anotacao) {
             $this->setId($anotacao['id']);
             $this->setTitulo($anotacao['titulo']);
             $this->setAnotacao($anotacao['anotacao']);
             $this->setDataCriada($anotacao['dataCriada']);
             $this->setHoraCriada($anotacao['horaCriada']);
                echo '
                <div class="card mb-2 shadow-sm">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="card-body">
                            <h5 class="card-title">'.$this->getTitulo().'</h5>
                            <p class="card-text oneline">'.$this->getAnotacao().'</p>
                            <p class="card-text"><small class="text-body-secondary">Criado em '.date('d/m/Y', strtotime($this->getDataCriada())).', às '.date('H:i', strtotime($this->getHoraCriada())).'</small></p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 d-flex align-items-center justify-content-center mb-lg-0 mb-2">
                    <form action="validacao.php" method="POST">
                        <input name="anotacaoID" type="hidden" value='.$this->getId().'>
                        <button name="btnAnotacaoRestaurar" class="btn btn-outline-success m-1"><i class="bi-arrow-clockwise me-1"></i>Restaurar</button>
                    </form>
                       <button name="btnAnotacaoExcluir" class="btn btn-outline-danger m-1" value='.$this->getId().'><i class="bi-trash-fill me-1"></i>Excluir</button>
                    </div>
                </div>
            </div>';
            }
        } else {
            echo '<h5>Você não possui anotacões na lixeira.</h5>';
        }
    }

    public function mostrarMensagem(){
        if(isset($_SESSION['msg'])){  
            echo '
                <div class="col-12">
                        <div class="alert alert-info alert-dismissible fade show" role="alert"><i class="bi-info-circle me-1"></i>'.$_SESSION['msg'].'
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button> 
                        </div>
                </div>
                    ';
            unset($_SESSION['msg']);
        }
    }
    
    public function preecherAtributosObjeto($idAnotacao){
        $sql = "SELECT * FROM anotacoes WHERE id = :id";
        $result = $this->conexao->prepare($sql);
        $result->bindParam(':id', $idAnotacao);
        $result->execute();
        $anotacao = $result->fetch(PDO::FETCH_ASSOC);

        $this->setId($anotacao['id']);
        $this->setTitulo($anotacao['titulo']);
        $this->setAnotacao($anotacao['anotacao']);
        $this->setDataCriada($anotacao['dataCriada']);
        $this->setHoraCriada($anotacao['horaCriada']);
    }
}
?>

<?php $anotacao = new Anotacao(); ?>