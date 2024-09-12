describe('testando configurações do site', () => {
  before(() => {
    cy.xdebugOff()
  });

  it('sem erros no relatório do site', () => {
    cy.loginByAdmin()
    cy.visit('/admin/reports/status')
    cy.get('span.system-status-counter--error').should('contain.text', '0 Erros');
  })
})
