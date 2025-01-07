//SELEÇÃO
const btnEditarAnotacao = document.querySelector('#btnEditarAnotacao');

//EVENTOS
btnEditarAnotacao.disabled = true;
const inputTitulo = document.querySelector('#titulo'); 
const inputAnotacao = document.querySelector('#anotacao'); 
        
const verificarCampos = () => {
    btnEditarAnotacao.disabled = inputTitulo.value.trim().length > 0  && inputAnotacao.value.trim().length > 0? false : true;
}
      
inputTitulo.addEventListener('input', verificarCampos);
inputAnotacao.addEventListener('input', verificarCampos);
