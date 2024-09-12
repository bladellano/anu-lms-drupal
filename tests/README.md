# 1MIO - Testes

## Como rodar os testes - passo a passo
* Antes de tudo, instale o Cypress, caso não tenha instalado: `npm install cypress --save-dev`. Mais informações na documentação https://docs.cypress.io/guides/getting-started/installing-cypress;

* Caso precise acessar o container em algum momento, rode `docker exec -it 1mio_appserver_1 bash` ou use o comando `lando <aqui seu comando desejado>`;
2. Acesse a pasta ./tests e execute o comando `npx cypress open`;
3. No painel que o cypress abrirá, clique em E2E Testing, escolha um navegador para rodar seu teste e, a exemplo de ter escolhido o Chrome, clique em "Start E2E Testing in Chrome";
    ![Alt text](./cypress/img/image.png)
4. Clique na "spec" que corresponde ao teste que deseja rodar, e acompanhe sua execução.
    ![Alt text](./cypress/img/image-1.png)

## Estrutura de pastas:
- Na raiz do projeto está a pasta tests/, e nela estão os seguintes arquivos/diretórios:
    -   tests/cypress/
        - tests/cypress/e2e/ (aqui ficam as 'specs', que são os arquivos onde serão escritos os testes)   
        - tests/cypress/support/ (pasta com os comandos personalizados e configuração global)
    -   tests/cypress.config.js (arquivo de configuração)