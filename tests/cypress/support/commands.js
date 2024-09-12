// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************

Cypress.Commands.add('xdebugOff', () => {
  cy.exec('cd ../ && lando xdebug-off', { failOnNonZeroExit:false })
});

Cypress.Commands.add('loginByAdmin', () => {
    cy.exec('cd ../ && ./vendor/bin/drush uli --uri="http://drupal-lms.local.com"', { failOnNonZeroExit:false })
      .its('stdout')
      .then(function (url) {
      cy.visit(url);
    });
});

Cypress.Commands.overwrite('visit', (originalFn, url, options ) => {
  options = options || {};
  options.auth = {
    username: Cypress.env('user'),
    password: Cypress.env('pass')
  }

  return originalFn(url, options)
})
