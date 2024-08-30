const express = require('express');
const nunjucks = require('nunjucks');
const path = require('path');
import { constants, projectCategories } from '../constants';

const { personalLinks, navBarLinks, skills, projects } = constants;

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

// Define routes
app.get('/links', (req, res) => {
  try {
    const pageName = 'Links';

    res.render('links.njk', { myLinks: personalLinks, pageName, navBarLinks });
  } catch (err) {
    console.error('Error rendering template:', err);
    res.status(500).send('Internal Server Error!');
  }
});

app.get('/', (req, res) => {
  res.render('home.njk', { navBarLinks, skills, projects, projectCategories: Object.values(projectCategories) });
});

// Export the Express app as a serverless function
module.exports = (req, res) => {
  app(req, res);
};
