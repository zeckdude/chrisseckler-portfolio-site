const express = require('express');
const nunjucks = require('nunjucks');
const { createServer } = require('@vercel/node');

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

// Export the app wrapped in a serverless function
module.exports = createServer(app);

// const express = require('express');
// const nunjucks = require('nunjucks');

// const app = express();

// // Configure Nunjucks to use the 'views' directory
// nunjucks.configure('views', {
//   autoescape: true,
//   express: app,
//   watch: true,
// });

// // Serve a simple route
// app.get('/', (req, res) => {
//   res.render('simple.njk');
// });

// // Start the server
// const PORT = process.env.PORT || 3000;
// app.listen(PORT, () => {
//   console.log(`Server is running on port ${PORT}`);
// });

// const express = require('express');
// const nunjucks = require('nunjucks');
// const path = require('path');

// const app = express();

// // Configure Nunjucks
// nunjucks.configure('views', {
//   autoescape: true,
//   express: app,
//   watch: true,
// });

// // Serve static files from the 'public' directory
// app.use(express.static(path.join(__dirname, 'public')));

// const navBarLinks = [
//   {
//     href: '/#services',
//     title: 'Why choose me',
//   },
//   {
//     href: '/#about',
//     title: 'Who am I',
//   },
//   {
//     href: '/#skills',
//     title: 'Skills',
//   },
//   {
//     href: '/#portfolio',
//     title: 'Projects',
//   },
//   {
//     href: '/#experience',
//     title: 'Experience',
//   },
//   {
//     href: '/links',
//     title: 'Links',
//     isScrollLink: false,
//   },
//   {
//     href: '/#contact',
//     title: 'Get in touch',
//   },
// ];

// // Define routes
// app.get('/links', (req, res) => {
//   try {
//     const linksData = [
//       {
//         url: 'https://stackoverflow.com',
//         imgSrc: 'https://picsum.photos/600/400?a',
//         title: 'Stack Overflow',
//         description: 'A question and answer site for professional and enthusiast programmers.',
//       },
//       {
//         url: 'https://github.com',
//         imgSrc: 'https://picsum.photos/600/400?b',
//         title: 'GitHub',
//         description: 'A platform for version control and collaboration.',
//       },
//       {
//         url: 'https://codepen.io',
//         imgSrc: 'https://picsum.photos/600/400?c',
//         title: 'CodePen',
//         description: 'An online community for testing and showcasing HTML, CSS, and JavaScript code snippets.',
//       },
//     ];

//     const pageName = 'Links';

//     res.render('links.njk', { links: linksData, pageName, navBarLinks });
//   } catch (err) {
//     console.error('Error rendering template:', err);
//     res.status(500).send('Internal Server Error!');
//   }
// });

// app.get('/', (req, res) => {
//   res.render('home.njk', { navBarLinks });
// });

// // Start the server
// const PORT = process.env.PORT || 3200;
// app.listen(PORT, () => {
//   console.log(`Server is running on port ${PORT}`);
//   console.log(`Visit your site at: http://localhost:${PORT}`);
// });
