describe('Testando Página de Cursos', () => {

    const random_number = String(Math.random()).replace('.', '');
    const name_page_courses = 'Cursos agrupados n º ' + random_number;

    it('Criar página de cursos', () => {

        cy.loginByAdmin();

        cy.visit('/node/add/courses_landing_page');

        cy.get('#edit-title-0-value').type(name_page_courses);

        cy.contains('Salvar').click();

        cy.wait(400);

        cy.visit('/admin/content?type=courses_landing_page');

    });

    it('Checa a existência de uma página de cursos', () => {

        cy.loginByAdmin();

        cy.visit('/admin/content?type=courses_landing_page');

        cy.contains(name_page_courses).click();

        cy.get('.MuiPaper-root > .MuiCardActions-root > .MuiButtonBase-root').eq(0).click(); // Clica no primeiro curso. Use eq(1) se quiser o segundo.

        cy.get('[data-test="anu-lms-navigation-next"]').eq(0).click(); // 1x

        cy.get('[data-test="anu-lms-navigation-next"]').eq(0).click(); // 2x

    });

    it('Apagar página de cursos', () => {

        cy.loginByAdmin();

        cy.visit('/admin/content?type=courses_landing_page');

        cy.contains(name_page_courses).click();

        cy.get('.tabs__items > :nth-child(3) > a').click();

        cy.get('#edit-submit').click();

    });

})
