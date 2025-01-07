//SELEÇÃO
//Btns
const btnAddAnotacao = document.querySelector('#btnAddAnotacao');
const btnAnotacaoJogarLixeira = [...document.getElementsByName('btnAnotacaoJogarLixeira')];

//EVENTOS
btnAddAnotacao.addEventListener('click', () =>{
   let addAnotacao = document.createElement('section');
   addAnotacao.classList.add('win-floats');

   addAnotacao.innerHTML = `
   <form action="validacao.php" method="POST" class="col-12 col-md-7 rounded bg-light p-3 shadow">
       <div class="row">
           <div class="col-10">
               <h3>Adicionar Anotação</h3>
           </div>
           <div class="col-2 text-end">
               <!-- Botão de fechar janela -->
               <button type="button" id="btnFechar" class="btn-close" aria-label="Fechar"></button>
           </div>
       </div>
       <hr>
       <div class="mb-3">
           <label for="titulo">Título</label>
           <input id="titulo" type="text" placeholder="Digite o título" class="form-control" name="anotacaoTitulo" id="titulo">
       </div>

       <div class="mb-3">
           <label for="anotacao">Anotação</label>
           <textarea id="anotacao" class="form-control" name="anotacaoTexto" id="anotacao" rows="10" placeholder="Digite sua anotação..."></textarea>
       </div>

        <input type="hidden" name="anotacaoData" id="data">
        
        <input type="hidden" name="anotacaoHora" id="hora">

       <div class="mb-1 text-end">
           <button type="submit" name='addAnotacao' class="btn btn-primary" id="btnSubmit">Adicionar Anotação</button>
       </div>
   </form>`;

    document.body.appendChild(addAnotacao);

    const btnFechar = addAnotacao.querySelector('#btnFechar');
    btnFechar.addEventListener('click', () => {
        addAnotacao.remove();
    });

    const inputTitulo = document.querySelector('#titulo');
    const inputAnotacao = document.querySelector('#anotacao');
    const inputData = document.querySelector('#data');
    const inputHora = document.querySelector('#hora');
    const btnSubmit = document.querySelector('#btnSubmit');
    btnSubmit.disabled = true;

    const verificarCampos = () => {
        btnSubmit.disabled = inputTitulo.value.trim().length > 0  && inputAnotacao.value.trim().length > 0? false : true;
    }
  
    inputTitulo.addEventListener('input', verificarCampos);
    inputAnotacao.addEventListener('input', verificarCampos);

    btnSubmit.addEventListener('click', () => {
        const momentoClicado = new Date();
        const dataFormatada = momentoClicado.toISOString().split('T')[0];
        const horaFormatada = momentoClicado.toTimeString().split(':').slice(0, 2).join(':');
        inputData.value = dataFormatada;
        inputHora.value = horaFormatada;
    });
})

btnAnotacaoJogarLixeira.map((el) => {
    el.addEventListener('click', () => {
        const idAnotacao = el.value;
        console.log(idAnotacao)
        const moverAnotacao = document.createElement('section');
        moverAnotacao.classList.add('win-floats');

        moverAnotacao.innerHTML = `
        <form action="validacao.php" method="POST" class="col-12 col-md-4 rounded bg-light p-3 shadow">
            <div class="col-12 text-center mb-3">
                <h3>Mover Para a Lixeira?</h3>
            </div>
            <input type="hidden" name="idAnotacao" value="${idAnotacao}">
            <div class="mb-1 text-center">
                <button type="button" id="btnFechar" class="btn btn-light" aria-label="Fechar">Não, Cancelar</button>
                <button type="submit" name="moverAnotacao" class="btn btn-danger" id="btnExcluir">Sim, Mover Anotacão</button>
            </div>
        </form>`;

        document.body.appendChild(moverAnotacao);

        const btnFechar = moverAnotacao.querySelector('#btnFechar');
        btnFechar.addEventListener('click', () => {
            moverAnotacao.remove();
        });

    });
});

