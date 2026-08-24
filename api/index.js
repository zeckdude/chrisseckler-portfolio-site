const express = require('express');
const nunjucks = require('nunjucks');
const path = require('path');

import { constants, projectCategories } from '../constants';

const { navBarLinks, skills, projects } = constants;

const app = express();

// Configure Nunjucks to use the 'views' directory
nunjucks.configure('views', {
  autoescape: true,
  express: app,
  watch: true,
  noCache: true,
});

// Serve static files from the 'public' directory
app.use(express.static(path.join(__dirname, '../public')));

app.get('/', (req, res) => {
  res.render('home.njk', { navBarLinks, skills, projects, projectCategories: Object.values(projectCategories) });
});

// Export the Express app as a serverless function
module.exports = (req, res) => {
  app(req, res);
};
