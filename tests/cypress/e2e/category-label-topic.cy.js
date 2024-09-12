describe('inserindo informações para categoria, rótulo e tópico', () => {
  before(() => {
    cy.xdebugOff()
  });
  it('visualiza as informações no frontend', () => {
    cy.loginByAdmin()
    //cria categoria
    cy.visit('/admin/structure/taxonomy/manage/course_category/overview')
    cy.get('a.button').click()
    cy.get('#edit-name-0-value')
      .type('Natureza')
    cy.get('#edit-submit').click()
    cy.contains('O novo termo Natureza foi criado.')

    //cria rótulo
    cy.visit('/admin/structure/taxonomy/manage/course_label/overview')
    cy.get('a.button').click()
    cy.get('#edit-name-0-value')
      .type('Transformação')
    cy.get('#edit-submit').click()
    cy.contains('O novo termo Transformação foi criado.')

    //cria tópico
    cy.visit('/admin/structure/taxonomy/manage/course_topics/overview')
    cy.get('a.button').click()
    cy.get('#edit-name-0-value')
      .type('Lorem ipsum dolor sit amet, consectetur adipiscing elit')
    cy.get('#edit-submit').click()
    cy.contains('O novo termo Lorem ipsum dolor sit amet, consectetur adipiscing elit foi criado.')
  })
})