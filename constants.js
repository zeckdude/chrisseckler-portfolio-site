export const projectCategories = {
  javascript: {
    title: 'JavaScript',
    filterLabel: 'javaScript',
  },
  jquery: {
    title: 'jQuery',
    filterLabel: 'jquery',
  },
  php: {
    title: 'PHP',
    filterLabel: 'php',
  },
  mysql: {
    title: 'MySQL',
    filterLabel: 'mysql',
  },
  laravel: {
    title: 'Laravel',
    filterLabel: 'laravel',
  },
  ajax: {
    title: 'AJAX',
    filterLabel: 'ajax',
  },
  mobileResponsive: {
    title: 'Mobile Responsive',
    filterLabel: 'mobile',
  },
  mvc: {
    title: 'MVC',
    filterLabel: 'mvc',
  },
  html: {
    title: 'HTML',
    filterLabel: 'html',
  },
  css: {
    title: 'CSS',
    filterLabel: 'css',
  },
  smarty: {
    title: 'Smarty',
    filterLabel: 'smarty',
  },
  facebookIntegration: {
    title: 'Facebook Integration',
    filterLabel: 'facebook',
  },
  wordpress: {
    title: 'WordPress',
    filterLabel: 'wordpress',
  },
  git: {
    title: 'Git',
    filterLabel: 'git',
  },
  grunt: {
    title: 'Grunt',
    filterLabel: 'grunt',
  },
  customCms: {
    title: 'Custom CMS',
    filterLabel: 'cms',
  },
  youtubeIntegration: {
    title: 'YouTube Integration',
    filterLabel: 'youtube',
  },
  videos: {
    title: 'Videos',
    filterLabel: 'video',
  },
};

export const constants = {
  personalLinks: [
    {
      url: 'https://stackoverflow.com',
      imgSrc: 'https://picsum.photos/600/400?a',
      title: 'Stack Overflow',
      description: 'A question and answer site for professional and enthusiast programmers.',
    },
    {
      url: 'https://github.com',
      imgSrc: 'https://picsum.photos/600/400?b',
      title: 'GitHub',
      description: 'A platform for version control and collaboration.',
    },
    {
      url: 'https://codepen.io',
      imgSrc: 'https://picsum.photos/600/400?c',
      title: 'CodePen',
      description: 'An online community for testing and showcasing HTML, CSS, and JavaScript code snippets.',
    },
  ],
  navBarLinks: [
    {
      href: '/#services',
      title: 'Why choose me',
    },
    {
      href: '/#about',
      title: 'Who am I',
    },
    {
      href: '/#skills',
      title: 'Skills',
    },
    {
      href: '/#portfolio',
      title: 'Projects',
    },
    {
      href: '/#experience',
      title: 'Experience',
    },
    {
      href: '/links',
      title: 'Links',
      isScrollLink: false,
    },
    {
      href: '/#contact',
      title: 'Get in touch',
    },
  ],
  skills: [
    {
      title: 'Mobile Responsive',
      description:
        'I create websites that are not only HTML5 and CSS3 compliant, but also look great on the multitude of devices on the market today.',
      imageUrl: 'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/service1.png',
    },
    {
      title: 'Versatile',
      description:
        'My core skill set lies in the front-end development of websites, but I am also experienced in PHP and MySQL databases.',
      imageUrl: 'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/service2.png',
    },
    {
      title: 'Interactive',
      description:
        'While web development is my bread and butter, I am also familiar in other areas, including graphic design and sound & video editing.',
      imageUrl: 'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/service3.png',
    },
    {
      title: 'Adaptive',
      description:
        'Having served 8 years in the military and worked 4 years in an agency environment, I excel in team environments.',
      imageUrl: 'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/service4.png',
    },
  ],
  projects: [
    {
      title: 'Custom Analytics Platform',
      slug: 'myhotelwedding-analytics',
      categories: [
        projectCategories.javascript,
        projectCategories.jquery,
        projectCategories.php,
        projectCategories.mysql,
        projectCategories.laravel,
        projectCategories.ajax,
        projectCategories.mobileResponsive,
        projectCategories.mvc,
      ],
      date: '07/15',
      client: 'My Hotel Wedding',
      role: 'Front & Back End Developer',
      thumbnail:
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/myhotelwedding-analytics/320x210/1.jpg',
      images: [
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/myhotelwedding-analytics/750x430/1.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/myhotelwedding-analytics/750x430/2.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/myhotelwedding-analytics/750x430/3.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/myhotelwedding-analytics/750x430/4.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/myhotelwedding-analytics/750x430/5.jpg',
      ],
      content: [
        'A tracking and analytics platform customized to the needs of one my clients, My Hotel Wedding.',
        'My Hotel Wedding approached me about figuring out a way to track unique actions their users take on their site and for ways to display that data in meaningful reports and concise data visualization methods.',
        "The custom analytics platform I developed makes use of PHP and JavaScript to collect the data based on user's actions, such as page loads, button clicks, and other customized actions. The information is then seamlessly sent to a MySQL database using AJAX to record a wealth of information along with each entry.",
        'The data can be accessed in the mobile-responsive admin dashboard panels on any device available. They are filled with beautiful data visualizations displaying trends and other site information, so that administrators can easily determine how well the site is operating, based on a variety of filters they determine.',
      ],
    },
    {
      title: 'Fox International Portal',
      slug: 'fox-international-portal',
      categories: [
        projectCategories.javascript,
        projectCategories.jquery,
        projectCategories.html,
        projectCategories.css,
        projectCategories.mobileResponsive,
        projectCategories.mvc,
      ],
      date: '07/14',
      client: 'Trailer Park Inc.',
      role: 'Front End Developer',
      thumbnail:
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/fox_portal/320x210/1.jpg',
      images: [
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/fox_portal/750x430/1.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/fox_portal/750x430/2.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/fox_portal/750x430/3.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/fox_portal/750x430/4.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/fox_portal/750x430/5.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/fox_portal/750x430/6.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/fox_portal/750x430/7.jpg',
      ],
      content: [
        'A website created for Fox Entertainment Group to display their large library of movie titles and to give viewers an easy way to buy the titles.',
        'Built on top of the Yii PHP framework, the site uses a custom CMS for Fox to change anything on the site for different countries. It is mobile responsive and uses JavaScript to improve the viewing experience.',
      ],
    },
    {
      title: 'AutoMD Mobile Responsive Re-Design',
      slug: 'automd-mobile-responsive-redesign',
      categories: [
        projectCategories.html,
        projectCategories.css,
        projectCategories.jquery,
        projectCategories.mobileResponsive,
        projectCategories.smarty,
        projectCategories.mvc,
      ],
      date: '10/15',
      client: 'AutoMD',
      role: 'Front End Developer',
      thumbnail:
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/320x210/1.jpg',
      images: [
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/1.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/2.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/3.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/4.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/5.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/6.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/7.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/8.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/9.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/10.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/11.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/12.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/13.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/automd/750x430/14.jpg',
      ],
      content: [
        'A re-design of an outdated site using mobile-responsive strategies.',
        'AutoMD contracted me to convert existing, outdated pages into new designs employing mobile responsive strategies. As a front-end developer, it was my role to ensure that pages were pixel-perfect recreations of the photoshop comps provided to me, while knowing when to use groundbreaking CSS3 and HTML5, as well as being aware of when to use fallbacks for older browsers.',
      ],
    },
    {
      title: 'College Rental Listings Website',
      slug: 'college-rental-listings',
      categories: [
        projectCategories.html,
        projectCategories.css,
        projectCategories.jquery,
        projectCategories.php,
        projectCategories.mysql,
        projectCategories.ajax,
      ],
      date: '08/13',
      client: 'College Rental Listings',
      role: 'Chief Technical Officer',
      thumbnail:
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/320x210/1.jpg',
      images: [
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/1.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/2.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/3.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/4.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/5.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/6.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/7.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/8.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/9.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/10.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/11.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/12.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/13.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/crl/750x430/14.jpg',
      ],
      content: [
        'A startup I co-founded that provides homeowners and property managers a way to advertise homes for rent to college students.',
        "Built on the idea that finding off-campus housing shouldn't be a huge amount of homework, College Rental Listings sought to improve the listing process for homeowners as well as the search process for students through several easy-to-follow steps of creating a profile and being able to communicate with each other effortlessly.",
        'Apart from the house/apartment listings, it also includes other features, such as room and roommate listings for students, options to filter and search through the returned listings for each category, a notification system for when listings are posted, Google Maps integration, and an admin dashboard for university administrators to moderate and edit listings, as well as have a quick overview of all the students and listers registered on the site.',
      ],
    },
    {
      title: "TNT's Major Crimes Facebook App",
      slug: 'tnt-major-crimes-facebook-app',
      categories: [
        projectCategories.html,
        projectCategories.css,
        projectCategories.jquery,
        projectCategories.facebookIntegration,
      ],
      date: '02/13',
      client: 'Trailer Park Inc.',
      role: 'Front End Developer',
      thumbnail:
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/major_crimes/320x210/1.jpg',
      images: [
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/major_crimes/750x430/1.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/major_crimes/750x430/2.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/major_crimes/750x430/3.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/major_crimes/750x430/4.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/major_crimes/750x430/5.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/major_crimes/750x430/6.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/major_crimes/750x430/7.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/major_crimes/750x430/8.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/major_crimes/750x430/9.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/major_crimes/750x430/10.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/major_crimes/750x430/11.jpg',
      ],
      content: [
        "While employed at Trailer Park Inc., we were approached by TNT to create a website integrated into Facebook by means of a Facebook app that provided information relating to the new season, gave a deeper understanding of the new characters, allowed for viewing of clips from the show via YouTube embedded videos, as well as an interactive module where users could upload photos and the system would determine if they're guilty or not.",
        'Working on a team of 3, my role as the front-end developer was to code layouts, create slick animations, and integrate Facebook comments for photo/video galleries.',
      ],
    },
    {
      title: 'Pro Print & Services Website',
      slug: 'pro-print-services',
      categories: [projectCategories.html, projectCategories.css, projectCategories.jquery, projectCategories.php],
      date: '10/10',
      client: 'Pro Print & Services',
      role: 'Front End Developer',
      thumbnail:
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/pro_print/320x210/1.jpg',
      images: [
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/pro_print/750x430/1.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/pro_print/750x430/2.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/pro_print/750x430/3.jpg',
      ],
      content: [
        'The Pro Print website is an informational site for a printing company that explains their services, as well as offers users an opportunity to contact them or request quotes.',
        'Includes an illustrative office-desk look with a tab-based interface that mimics the feel of manila folders. Also, makes use of a lightbox in a creative way.',
      ],
    },
    {
      title: 'Warner Bros. Cartoon Universe Website',
      slug: 'warner-bros-cartoon-universe',
      categories: [projectCategories.html, projectCategories.css],
      date: '08/12',
      client: 'Trailer Park Inc.',
      role: 'Front End Developer',
      thumbnail:
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/cartoon_universe/320x210/1.jpg',
      images: [
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/cartoon_universe/750x430/1.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/cartoon_universe/750x430/2.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/cartoon_universe/750x430/3.jpg',
      ],
      content: [
        'While employed at Trailer Park Inc., I was tasked with developing the re-design for the Cartoon Universe, a Unity online game. The website served as a portal to find more information about the game, rules, and means to receive customer support.',
        'Working on a team of 3, we worked collaboratively to finish development by set deadlines. As the front-end developer, I made sure that the design was implemented pixel perfect and to the liking of the client, Warner Bros.',
      ],
    },
    {
      title: 'Warner Bros. 300: The Movie Website',
      slug: 'warner-bros-300-movie-website',
      categories: [
        projectCategories.html,
        projectCategories.css,
        projectCategories.javascript,
        projectCategories.youtubeIntegration,
        projectCategories.videos,
      ],
      date: '08/13',
      client: 'Trailer Park Inc.',
      role: 'Front End Developer',
      thumbnail:
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/300_movie/320x210/1.jpg',
      images: [
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/300_movie/750x430/1.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/300_movie/750x430/2.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/300_movie/750x430/3.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/300_movie/750x430/4.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/300_movie/750x430/5.jpg',
      ],
      content: [
        'Warner Bros hired my team of 3 at Trailer Park Inc. to create a teaser site for their upcoming film "300: The Rise of an Empire". It includes videos, plot synopsis, movie poster downloads, and character profiles.',
        'Built with mobile responsiveness in mind, it includes fullscreen YouTube video integration and social sharing features.',
      ],
    },
    {
      title: 'Vacation Showcase Website',
      slug: 'vacation-showcase-website',
      categories: [
        projectCategories.html,
        projectCategories.css,
        projectCategories.php,
        projectCategories.mysql,
        projectCategories.javascript,
        projectCategories.jquery,
      ],
      date: '02/11',
      client: 'Peninsula Travel Experts',
      role: 'Front & Back End Developer',
      thumbnail:
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/vacation_showcase/320x210/1.jpg',
      images: [
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/vacation_showcase/750x430/1.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/vacation_showcase/750x430/2.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/vacation_showcase/750x430/3.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/vacation_showcase/750x430/4.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/vacation_showcase/750x430/5.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/vacation_showcase/750x430/6.jpg',
      ],
      content: [
        'Peninsula Travel Experts are a network of travel agents and vendors who organize an annual trade show promoting their various services. They were in need of a website with which they could provide information to the next upcoming annual trade show named "Vacation Showcase".',
        'I designed the site in a playful, fun, vacation-like feel and made the site content customizable from top to bottom. It includes a custom Content Management System to allow for easy website updates by the client as well as a built-in Mailing List Manager to send out newsletters to large groups of recipients at the click of a button.',
      ],
    },
    {
      title: 'My Hotel Wedding Website',
      slug: 'my-hotel-wedding-website',
      categories: [
        projectCategories.html,
        projectCategories.css,
        projectCategories.jquery,
        projectCategories.laravel,
        projectCategories.mvc,
        projectCategories.wordpress,
        projectCategories.git,
        projectCategories.grunt,
      ],
      date: '08/15',
      client: 'My Hotel Wedding',
      role: 'Front & Back End Developer',
      thumbnail:
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/myhotelwedding/320x210/1.jpg',
      images: [
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/myhotelwedding/750x430/1.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/myhotelwedding/750x430/2.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/myhotelwedding/750x430/3.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/myhotelwedding/750x430/4.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/myhotelwedding/750x430/5.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/myhotelwedding/750x430/6.jpg',
      ],
      content: [
        'My Hotel Wedding is a service that originated with a successful blog (30,000+ pageviews a month) and branched out into several other areas, primarily as a resource for hotels to list their venues and to connect brides/grooms with them. In addition, the site also includes interactive quizzes, budgeting tools, helpful PDFs, an e-course for planning your wedding, and more.',
        'As the lead developer, I am responsible for updating outdated WordPress code, adding new pages on the Laravel PHP MVC framework, and consulting on many other web-related issues. Some things I have created are modular, interactive JavaScript quizzes that track user responses for data collection, Google Maps integration on user locations, and a hotel rating system.',
      ],
    },
    {
      title: 'Photography Auction Website',
      slug: 'photography-auction-website',
      categories: [
        projectCategories.html,
        projectCategories.css,
        projectCategories.php,
        projectCategories.mysql,
        projectCategories.javascript,
      ],
      date: '08/09',
      client: 'Freelance',
      role: 'Front & Back End Developer',
      thumbnail:
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/photo_auction/320x210/1.jpg',
      images: [
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/photo_auction/750x430/1.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/photo_auction/750x430/2.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/photo_auction/750x430/3.jpg',
      ],
      content: [
        "As a requirement for my final bachelor's degree class, I decided to create a conceptual silent photo auction. The resulting site is a complete site that is ready to be deployed as is.",
        'It includes sorting and filtering, multi-user accounts, and automated email features that notify the winner of an auction. Using PHP and MySQL, I created a custom Content Management System so the administrator can easily add, edit, delete, or activate auction items.',
      ],
    },
    {
      title: 'Applied Materials Business Card Ordering Center Website',
      slug: 'amat-business-card-ordering',
      categories: [
        projectCategories.html,
        projectCategories.css,
        projectCategories.php,
        projectCategories.mysql,
        projectCategories.javascript,
        projectCategories.jquery,
        projectCategories.customCms,
      ],
      date: '06/10',
      client: 'Pro Print & Services',
      role: 'Front & Back End Developer',
      thumbnail:
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/amatorders/320x210/1.jpg',
      images: [
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/amatorders/750x430/1.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/amatorders/750x430/2.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/amatorders/750x430/3.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/amatorders/750x430/4.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/amatorders/750x430/5.jpg',
        'https://s3-us-west-1.amazonaws.com/chris-seckler-portfolio-site/assets/images/projects/amatorders/750x430/6.jpg',
      ],
      content: [
        'My client, Pro Print & Services, required a system to process and track a large amount of daily business card orders. It had to streamline their workflow, while minimizing the amount of manual work hours required to order cards as well as provide an easy-to-follow administrative tracking system.',
        'I devised a solution in which all orders are entered on a website, and a dynamically created PDF proof of the business card is generated. At this point, the proof is automatically sent to the manager for approval. After the manager approves, the PDF can be combined with dynamically generated PDFs of other completed cards to be run off the printing press. The new system I developed substantially sped up the process and saved Pro Print & Services significant time and money.',
        'It is a multi-user site and allows for a translating service to upload foreign language characters that can be automatically added to the PDF proofs. It also includes a custom Content Management System where the printing company employees can track all their orders, complete with a detailed order history, searching and sorting, and a status ticker for a quick overview of all past and current orders.',
      ],
    },
  ],
};
