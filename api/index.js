const express = require('express');
const nunjucks = require('nunjucks');
const path = require('path');
const { notion } = require('../lib/notion/client');

require('dotenv').config();

import { constants, projectCategories } from '../constants';

const { navBarLinks, skills, projects } = constants;

const app = express();

const fetchPersonalLinks = async () => {
  try {
    const response = await notion.databases.query({
      database_id: process.env.LINKS_NOTION_DATABASE_ID,
      sorts: [
        {
          property: 'title', // Replace with the name of the property that determines order
          direction: 'ascending', // or 'descending' depending on your desired order
        },
      ],
    });
    return response.results.map((page) => {
      return {
        url: page.properties.url.rich_text[0].plain_text,
        imgSrc: page.properties.imgSrc.rich_text[0].plain_text,
        title: page.properties.title.title[0].plain_text,
        description: page.properties.description.rich_text[0].plain_text,
      };
    });
  } catch (error) {
    console.error('Error fetching data from Notion:', error);
    throw error; // rethrow to be caught in the route handler
  }
};

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
app.get('/links', async (req, res) => {
  try {
    const pageName = 'Links';
    const myLinks = await fetchPersonalLinks();

    res.render('links.njk', { myLinks, pageName, navBarLinks });
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
