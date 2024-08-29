const express = require('express');
const nunjucks = require('nunjucks');

const app = express();

// Configure Nunjucks to use the 'views' directory
nunjucks.configure('views', {
  autoescape: true,
  express: app,
  watch: true,
});

// Serve a simple route
app.get('/', (req, res) => {
  res.render('simple.njk');
});

const PORT = process.env.PORT || 3200;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
  console.log(`Visit your site at: http://localhost:${PORT}`);
});

// Export the app wrapped in a serverless function
module.exports = app;
