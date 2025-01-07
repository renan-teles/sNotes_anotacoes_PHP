//SELEÇÃO
//Divs
const divLogin = document.querySelector('#divLogin');
const divCadastro = document.querySelector('#divCadastro');
const inputNome = document.querySelector('#usuarioNome');
const inputEmail = document.querySelector('#usuarioEmail');
const inputSenha = document.querySelector('#usuarioSenha');

//Btns
const btnToggle = [...document.getElementsByName('btnToggleLogCad')];
const btnCadastrar = document.querySelector('#btnCadastrar');
btnCadastrar.disabled = true;

//EVENTOS
btnToggle.map((el) => {
    el.addEventListener('click', () => {
        divLogin.classList.toggle('d-none');
        divCadastro.classList.toggle('d-none');
    })
});

// //FUNÇÕES
const verificarCampos = () => {
    btnCadastrar.disabled = inputNome.value.trim().length > 0  && inputEmail.value.trim().length > 0 && inputSenha.value.trim().length > 5? false : true;
}

inputNome.addEventListener('input', verificarCampos);
inputEmail.addEventListener('input', verificarCampos);
inputSenha.addEventListener('input', verificarCampos);

