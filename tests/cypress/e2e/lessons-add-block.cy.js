describe('Testando Página de Lições', () => {

    it('Add página em lições', () => {

        cy.loginByAdmin();

        cy.visit('/node/40/edit'); /** Você só precisa adicionar o ID da lição. Não é necessário copiar toda a URL cheia de caracteres. */

        cy.contains('Add block').click();

        cy.wait(400);

        /** A classe `.simple` foi utilizada porque identifiquei que ela é única em todo o DOM. Além disso, o seletor `[name="field_lesson_section_content_lesson_text_add_more"]` também é exclusivo, garantindo a identificação correta do elemento. Embora a inclusão de `.simple` não seja estritamente necessária, optei por adicioná-la por questões de organização. Resumindo, todos os botões de "adicionar" no modal terão uma identificação única no atributo `name`, o que facilita sua diferenciação.*/

        cy.get('.simple [name="field_lesson_section_content_lesson_text_add_more"]').click();

        cy.wait(200);

        /** Achei que esse comando já estivesse sendo utilizado e estivesse na etapa de 1MIO. */
        cy.setCkeditorContent('.ck-editor__editable', '<p>Burgdoggen pancetta beef ribs, beef ham hock enim velit labore salami occaecat ground round ut excepteur magna brisket. Chicken strip steak corned beef spare ribs dolor. Commodo anim tempor bacon occaecat lorem pork chop porchetta sausage bresaola venison dolore brisket. Dolore ullamco consequat ut ham hock mollit pork chop. Ham dolore adipisicing doner labore consectetur ground round dolore nostrud duis cupim cillum irure shankle frankfurter. Aliquip eu andouille, strip steak in cupidatat laborum in do laboris irure aliqua ribeye aute alcatra. Pastrami pork chop ham et. Turducken et tempor, eiusmod kielbasa cow ball tip pancetta esse mollit cupim corned beef short loin prosciutto. Beef adipisicing kevin, ribeye id pariatur ham hock. Aliquip tongue culpa chuck ea, ham hock deserunt burgdoggen incididunt alcatra adipisicing reprehenderit.<p>');

        cy.contains('Salvar').click();

    });

})
