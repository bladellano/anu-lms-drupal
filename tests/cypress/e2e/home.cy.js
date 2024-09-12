describe('testando home page', () => {
  before(() => {
    cy.xdebugOff()
  });

  it('checa existência da logo', () => {
    cy.visit('/')
    // Test site-logo class exist
    cy.get('div.block-system-branding-block')
      .should('exist');
  })
})
