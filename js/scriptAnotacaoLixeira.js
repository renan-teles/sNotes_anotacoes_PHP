//SELEÇÃO
//Btn
const btnAnotacaoExcluir = [...document.getElementsByName('btnAnotacaoExcluir')];

//EVENTO
btnAnotacaoExcluir.map((el) => {
    el.addEventListener('click', () => {
        const idAnotacao = el.value;

        const excluirAnotacao = document.createElement('section');
        excluirAnotacao.classList.add('win-floats');

        excluirAnotacao.innerHTML = `
        <form action="validacao.php" method="POST" class="col-12 col-md-4 rounded bg-light p-3 shadow">
            <div class="col-12 text-center mb-3">
                <h3>Excluir Anotação?</h3>
            </div>
            <input type="hidden" name="idAnotacao" value="${idAnotacao}">
            <div class="mb-1 text-center">
                <button type="button" id="btnFechar" class="btn btn-light" aria-label="Fechar">Não, Cancelar</button>
                <button type="submit" name="excluirAnotacao" class="btn btn-danger" id="btnExcluir">Sim, Excluir Anotacão</button>
            </div>
        </form>`;

        document.body.appendChild(excluirAnotacao);

        const btnFechar = excluirAnotacao.querySelector('#btnFechar');
        btnFechar.addEventListener('click', () => {
            excluirAnotacao.remove();
        });
    });
});