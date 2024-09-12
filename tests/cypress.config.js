const { defineConfig } = require("cypress");

module.exports = defineConfig({
  chromeWebSecurity: false,
  e2e: {
    baseUrl: 'http://drupal-lms.local.com'
  },
  env: {
    user: 'thiagopoltronieri',
    pass: '1mio@dev',
  },

  viewportWidth: 1400,
  viewportHeight: 1200,
});
