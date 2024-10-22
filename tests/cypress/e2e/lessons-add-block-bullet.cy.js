describe('Testando Página de Lições', () => {

    it('Add página em lições', () => {

        cy.loginByAdmin();

        cy.visit('/node/40/edit'); /** Você só precisa adicionar o ID da lição. Não é necessário copiar toda a URL cheia de caracteres. */

        cy.contains('Add block').click();

        cy.wait(400);

        /** Nesta tela, a palavra "Tamanho" é única, então a utilizei apenas para criar um "irmão" e utilizar o evento siblings. O argumento 'select' é usado para garantir o alvo, e em seguida, defino o valor no select. Conforme indicado na documentação do Cypress, a função 'select' recebe o valor do option como argumento.  */

        // https://docs.cypress.io/api/commands/select

        cy.get('[name="field_lesson_section_content_lesson_img_list_add_more"]').click();
        cy.contains('Tamanho').siblings('select').select('small');
        cy.wait(200);
        cy.contains('Alinhamento').siblings('select').select('middle');


        cy.contains('Add block').click();

        cy.wait(400);

        cy.get('[name="field_lesson_section_content_lesson_img_list_add_more"]').click();
        cy.contains('Tamanho').siblings('select').select('small');
        cy.wait(200);
        cy.contains('Alinhamento').siblings('select').select('middle');

        cy.setCkeditorContent('.ck-editor__editable', 'Conteúdo no terceiro editor', 1);

        /** Achei que esse comando já estivesse sendo utilizado e estivesse na etapa de 1MIO. */
        // cy.setCkeditorContent('.ck-editor__editable', '<p>Burgdoggen pancetta beef ribs, beef ham hock enim velit labore salami occaecat ground round ut excepteur magna brisket. Chicken strip steak corned beef spare ribs dolor. Commodo anim tempor bacon occaecat lorem pork chop porchetta sausage bresaola venison dolore brisket. Dolore ullamco consequat ut ham hock mollit pork chop. Ham dolore adipisicing doner labore consectetur ground round dolore nostrud duis cupim cillum irure shankle frankfurter. Aliquip eu andouille, strip steak in cupidatat laborum in do laboris irure aliqua ribeye aute alcatra. Pastrami pork chop ham et. Turducken et tempor, eiusmod kielbasa cow ball tip pancetta esse mollit cupim corned beef short loin prosciutto. Beef adipisicing kevin, ribeye id pariatur ham hock. Aliquip tongue culpa chuck ea, ham hock deserunt burgdoggen incididunt alcatra adipisicing reprehenderit.<p>');

        // cy.contains('Salvar').click();

    });

})
