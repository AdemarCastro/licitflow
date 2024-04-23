document.addEventListener("DOMContentLoaded", function () {
  var form = document.getElementById("form-login");
 
  form.addEventListener("submit", function (event) {
     event.preventDefault(); // Impede o comportamento padrão do formulário
 
     // Verifica se todos os campos do formulário estão preenchidos
     var email = form.elements["email"].value.trim();
     var password = form.elements["password"].value.trim();
 
     // Valida o formato do e-mail usando uma expressão regular
     var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
     if (!emailPattern.test(email)) {
       // Se o e-mail não estiver em um formato válido, exibe uma mensagem de erro
       alert("Por favor, insira um endereço de e-mail válido.");
       return; // Impede o envio do formulário
     }
 
     if (password === "") {
       // Se a senha estiver vazia, exibe uma mensagem de erro
       alert("Por favor, insira sua senha.");
       return; // Impede o envio do formulário
     }
 
     // Se a validação passar, envia os dados do formulário para o scriptlogin.php
     var formData = new FormData(form);
     fetch('scriptlogin.php', {
       method: 'POST',
       body: formData
     })
     .then(response => response.text())
     .then(data => {
       // Aqui você pode manipular a resposta do servidor, se necessário
       console.log(data);
     })
     .catch(error => {
       console.error('Erro ao enviar o formulário:', error);
     });
  });
 });
 