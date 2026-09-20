BEACON ROAD MISSIONS
CMS Project: Sessions Assignment

HOW TO RUN
Upload the whole folder to any PHP 7.4 or newer host (PHP 8 works). Open index.php.
No database and no framework is used. Sessions hold the cart, login, and admin edits.
Local test: php -S localhost:8000 inside this folder.

FOLDERS
  *.php        18 main pages
  includes/    bootstrap.php, header.php, menu.php, footer.php, functions.php
  classes/     Product, Catalog, Cart, Auth, Validator, ContentStore
  data/        site-data.php (pages, products, fields, stories, users as arrays)
  css/         style.css (the only style sheet)
  images/      SVG illustrations

ACCOUNTS
  admin / Admin123!   publisher / Publisher123!   customer / Customer123!

REQUIREMENT MAP
  15+ main pages ............ 18 pages listed in data/site-data.php and on sitemap.php
  header, menu, footer ...... includes/header.php, menu.php, footer.php
  W3C icons and timestamp ... includes/footer.php, using last_modified() in functions.php
  Strict XHTML and one CSS .. every page validated against the XHTML 1.0 Strict DTD
  10+ products .............. 12 products with image, description, price, quantity in stock
  Cart add, update, remove .. cart.php, class Cart
  Total with tax ............ cart.php and checkout.php (7 percent, TAX_RATE in bootstrap.php)
  Login, roles in session ... login.php, class Auth, require_role() in functions.php
  Registration and strength . register.php, Validator::passwordChecks(). Nothing is saved.
  Two or more validated forms  contact.php, volunteer.php, prayer.php, checkout.php
  Two control structures ..... foreach loops and if/elseif chains on nearly every page,
                               lockout logic in login.php
  Two arrays ................. data/site-data.php (products, pages), volunteer skills, cart in $_SESSION
  Functions, classes, objects  includes/functions.php and classes/
  CMS ready .................. pages, products, users, posts already shaped like database rows

SECURITY NOTES
  Output escaped with h(). CSRF token on every POST form. Passwords stored as bcrypt hashes.
  Session id rotated at login and logout. Five failed logins lock the form for 60 seconds.

IMAGES AND COPY
  Illustrations, product descriptions, and prices were produced with AI assistance.
  The organization is fictional.
