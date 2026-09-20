<?php
/*
 * Beacon Road Missions, site data.
 *
 * Everything the site displays is stored in the arrays below so that the
 * final CMS assignment can move each array into its own database table
 * (pages, products, fields, stories, verses, users) without changing the
 * page templates. Prices are stored as whole cents to avoid rounding errors.
 *
 * Product copy, prices, and images were produced with AI assistance.
 */
return array(

    /* ---------- pages table ---------- */
    'pages' => array(
        'home'      => array('file' => 'index.php',     'title' => 'Home',                 'nav' => 'main',    'access' => 'public',    'desc' => 'Beacon Road Missions brings clean water, education, medical care, and the gospel to communities across four fields.'),
        'about'     => array('file' => 'about.php',     'title' => 'Our Story',            'nav' => 'main',    'access' => 'public',    'desc' => 'How Beacon Road Missions began and the biblical convictions that guide our work.'),
        'mission'   => array('file' => 'mission.php',   'title' => 'Vision and Goals',     'nav' => 'main',    'access' => 'public',    'desc' => 'Our vision, goals, and measurable objectives for the coming five years.'),
        'fields'    => array('file' => 'fields.php',    'title' => 'Where We Serve',       'nav' => 'main',    'access' => 'public',    'desc' => 'Meet the four mission fields where Beacon Road teams serve alongside local churches.'),
        'stories'   => array('file' => 'stories.php',   'title' => 'Field Stories',        'nav' => 'main',    'access' => 'public',    'desc' => 'Stories of changed lives and field updates from Beacon Road Missions.'),
        'store'     => array('file' => 'store.php',     'title' => 'Mission Store',        'nav' => 'main',    'access' => 'public',    'desc' => 'Christian books, gifts, and fair trade goods. Every purchase supports Beacon Road field work.'),
        'product'   => array('file' => 'product.php',   'title' => 'Product Details',      'nav' => null,      'access' => 'public',    'desc' => 'Full product details for an item in the Beacon Road Mission Store.'),
        'cart'      => array('file' => 'cart.php',      'title' => 'Your Cart',            'nav' => 'util',    'access' => 'public',    'desc' => 'Review, update, or remove items in your shopping cart.'),
        'checkout'  => array('file' => 'checkout.php',  'title' => 'Checkout',             'nav' => null,      'access' => 'public',    'desc' => 'Review your order total with tax and enter your shipping details.'),
        'contact'   => array('file' => 'contact.php',   'title' => 'Contact Us',           'nav' => 'main',    'access' => 'public',    'desc' => 'Send a message to the Beacon Road Missions office.'),
        'volunteer' => array('file' => 'volunteer.php', 'title' => 'Serve With Us',        'nav' => 'main',    'access' => 'public',    'desc' => 'Apply to serve on a short term or long term Beacon Road mission team.'),
        'prayer'    => array('file' => 'prayer.php',    'title' => 'Prayer Requests',      'nav' => 'main',    'access' => 'public',    'desc' => 'Share a prayer request with our intercession team.'),
        'login'     => array('file' => 'login.php',     'title' => 'Log In',               'nav' => 'util',    'access' => 'public',    'desc' => 'Log in as a customer, publisher, or administrator.'),
        'register'  => array('file' => 'register.php',  'title' => 'Create an Account',    'nav' => 'util',    'access' => 'public',    'desc' => 'Create a Beacon Road account with a strong password.'),
        'account'   => array('file' => 'account.php',   'title' => 'My Account',           'nav' => 'util',    'access' => 'customer',  'desc' => 'Your account home and access level.'),
        'publisher' => array('file' => 'publisher.php', 'title' => 'Publisher Desk',       'nav' => 'role',    'access' => 'publisher', 'desc' => 'Draft and publish field updates for the Field Stories page.'),
        'admin'     => array('file' => 'admin.php',     'title' => 'Administrator Panel',  'nav' => 'role',    'access' => 'admin',     'desc' => 'Manage products, pages, and accounts.'),
        'sitemap'   => array('file' => 'sitemap.php',   'title' => 'Site Map',             'nav' => 'footer',  'access' => 'public',    'desc' => 'A complete list of pages on the Beacon Road Missions website.'),
    ),

    /* ---------- products table ---------- */
    'products' => array(
        1  => array('name' => 'Beacon Study Bible',           'category' => 'Books',   'price_cents' => 3499, 'stock' => 40,  'image' => 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=900&q=80', 'short' => 'Hardcover study Bible with notes and maps.',
                    'description' => 'A durable hardcover study Bible with clear type, cross references, and one hundred short study notes written for first time and lifelong readers. The ribbon marker keeps your place through every season of reading.'),
        2  => array('name' => 'Pocket Psalms Bible',          'category' => 'Books',   'price_cents' => 850,  'stock' => 120, 'image' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=900&q=80', 'short' => 'Slim Psalms-only Bible for daily encouragement.',
                    'description' => 'A portable Psalms-only Bible designed for a jacket pocket, backpack, or bedside table. Compact enough for daily use and easy to share with a neighbor, friend, or new believer who needs a steady source of comfort and hope.'),
        3  => array('name' => 'Morning Mercies Prayer Journal', 'category' => 'Books', 'price_cents' => 1600, 'stock' => 60,  'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=900&q=80', 'short' => 'A guided prayer journal for daily reflection.',
                    'description' => 'A ninety day prayer journal that pairs a short Scripture focus with space to write prayers, gratitude, and answered requests. The lay flat binding and elastic band make it easy to carry between home, study, and church.'),
        4  => array('name' => 'Living Water Steel Bottle',     'category' => 'Gifts',   'price_cents' => 2200, 'stock' => 35,  'image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=900&q=80', 'short' => 'Insulated 20 oz bottle. Funds a clean water share.',
                    'description' => 'A 20 ounce insulated bottle that keeps drinks cold for a full day. Each bottle sold contributes to a clean water fund for a village well project, a small daily reminder of the living water Jesus offers.'),
        5  => array('name' => 'Cross Pendant Necklace',        'category' => 'Jewelry', 'price_cents' => 2800, 'stock' => 25,  'image' => 'https://images.unsplash.com/photo-1617038220319-276d3cfab638?auto=format&fit=crop&w=900&q=80', 'short' => 'Simple cross pendant on an 18 inch chain.',
                    'description' => 'A plain, well finished cross pendant on an 18 inch chain with a secure clasp. Its clean lines suit daily wear and make a thoughtful gift for a baptism, a birthday, or a new believer.'),
        6  => array('name' => 'Harvest Blend Coffee',          'category' => 'Food',    'price_cents' => 1450, 'stock' => 80,  'image' => 'https://images.unsplash.com/photo-1498804103079-a6351b050096?auto=format&fit=crop&w=900&q=80', 'short' => '12 oz fair trade medium roast whole bean.',
                    'description' => 'A smooth medium roast with notes of cocoa and toasted almond, sourced from cooperatives that pay farmers a fair, steady price. Ground and roasted in small batches and packed in a 12 ounce resealable bag.'),
        7  => array('name' => 'Psalm 121 Canvas Tote',         'category' => 'Gifts',   'price_cents' => 1800, 'stock' => 50,  'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80', 'short' => 'Heavy canvas tote printed with Psalm 121.',
                    'description' => 'A sturdy natural canvas tote with reinforced handles and a mountain scene printed with the opening of Psalm 121. Big enough for groceries, books, and a Bible, and tough enough for years of Sunday mornings.'),
        8  => array('name' => 'Scripture Memory Card Set',     'category' => 'Books',   'price_cents' => 999,  'stock' => 90,  'image' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=900&q=80', 'short' => '52 cards, one verse for every week of the year.',
                    'description' => 'Fifty two illustrated cards, each with a verse on the front and a short thought on the back. Keep the set on a dinner table, in a car, or by a bathroom mirror and hide a new verse in your heart every week.'),
        9  => array('name' => 'Olive Wood Cross',              'category' => 'Gifts',   'price_cents' => 2400, 'stock' => 30,  'image' => 'https://images.unsplash.com/photo-1516303699686-d7191d6e3df0?auto=format&fit=crop&w=900&q=80', 'short' => 'Hand carved standing cross, 8 inches tall.',
                    'description' => 'A hand carved cross made from responsibly harvested olive wood. The grain of every piece is different, so your cross is one of a kind. It stands eight inches tall and sits well on a shelf or desk.'),
        10 => array('name' => 'Kids Story Bible',              'category' => 'Books',   'price_cents' => 1995, 'stock' => 45,  'image' => 'https://images.unsplash.com/photo-1516627145497-ae6968895b74?auto=format&fit=crop&w=900&q=80', 'short' => '100 illustrated stories for ages 4 to 9.',
                    'description' => 'One hundred illustrated Bible stories told in warm, simple language and arranged so a family can read one story a night for a season. Each story ends with a question that starts a good conversation.'),
        11 => array('name' => 'Light of the World Candle',     'category' => 'Gifts',   'price_cents' => 1500, 'stock' => 40,  'image' => 'https://images.unsplash.com/photo-1602872029706-8ea0b5b0f0f0?auto=format&fit=crop&w=900&q=80', 'short' => '8 oz soy candle with a soft vanilla scent.',
                    'description' => 'An 8 ounce soy wax candle in a reusable glass jar with a gentle vanilla and cedar scent. Light it during prayer, at the dinner table, or on a quiet evening as a reminder that the light shines in the darkness.'),
        12 => array('name' => 'Beacon Road Mission Tee',       'category' => 'Apparel', 'price_cents' => 2100, 'stock' => 55,  'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=900&q=80', 'short' => 'Soft cotton tee with the lighthouse design.',
                    'description' => 'A soft, pre washed cotton tee in deep navy with the Beacon Road lighthouse across the chest. Runs true to size. Proceeds from each shirt help send a volunteer team to one of our fields.'),
    ),

    /* ---------- fields table ---------- */
    'fields' => array(
        array('name' => 'Kenya',       'region' => 'East Africa',       'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=1200&q=80', 'summary' => 'Church planting and discipleship in the dry lowlands.',
              'work' => array('Church planting in new villages', 'Pastor training for rural congregations', 'Discipleship groups and community care')),
        array('name' => 'Guatemala',   'region' => 'Central America',   'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&q=80', 'summary' => 'Education and literacy in the highland communities.',
              'work' => array('Primary school tutoring centers', 'Adult literacy classes using Scripture', 'Scholarships for secondary school students')),
        array('name' => 'Philippines', 'region' => 'Southeast Asia',    'image' => 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&w=1200&q=80', 'summary' => 'Medical outreach and disaster relief on the coast.',
              'work' => array('Mobile medical and dental clinics', 'Typhoon preparedness training', 'Rebuilding homes with local carpenters')),
        array('name' => 'Nepal',       'region' => 'South Asia',        'image' => 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?auto=format&fit=crop&w=1200&q=80', 'summary' => 'Mountain village health and Bible translation support.',
              'work' => array('Community health worker training', 'Scripture recordings in local dialects', 'Winter supply runs to remote villages')),
    ),

    /* ---------- stories table ---------- */
    'stories' => array(
        array('title' => 'A Well Behind the Church',     'field' => 'Kenya',       'image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1200&q=80',
              'body' => 'For eleven years the women of Kiambu Ridge walked four hours each day to fetch water. When our team and the local church finished drilling in March, the first bucket was lifted while the whole village sang. The walk that once consumed the morning now takes less than five minutes, and the church hosts a Bible study at the well every Thursday.'),
        array('title' => 'The Reading Room',             'field' => 'Guatemala',   'image' => 'https://images.unsplash.com/photo-1513258496091-48138775d4ac?auto=format&fit=crop&w=1200&q=80',
              'body' => 'A grandmother named Rosa enrolled in our evening class at age sixty one. Six months later she read the Sermon on the Mount aloud to her family. Her grandchildren keep her reading glasses on a hook by the door, and the tutoring center now serves forty two learners each week.'),
        array('title' => 'Clinic Day on the Coast',      'field' => 'Philippines', 'image' => 'https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1200&q=80',
              'body' => 'After the storm season our mobile clinic saw one hundred eighty patients in a single day beneath a borrowed church roof. Nurses treated infections and checked blood pressure, while volunteers prayed with families waiting in the shade. Several patients returned the next Sunday to worship.'),
    ),

    /* ---------- verses table ---------- */
    'verses' => array(
        array('text' => 'Your word is a lamp to my feet and a light to my path.',              'ref' => 'Psalm 119:105'),
        array('text' => 'Let your light shine before others, that they may see your good deeds and glorify your Father in heaven.', 'ref' => 'Matthew 5:16'),
        array('text' => 'How beautiful upon the mountains are the feet of him who brings good news.', 'ref' => 'Isaiah 52:7'),
        array('text' => 'Whoever is generous to the poor lends to the Lord, and he will repay him for his deed.', 'ref' => 'Proverbs 19:17'),
        array('text' => 'Go therefore and make disciples of all nations.',                      'ref' => 'Matthew 28:19'),
        array('text' => 'Let us not grow weary of doing good, for in due season we will reap.', 'ref' => 'Galatians 6:9'),
        array('text' => 'I was thirsty and you gave me drink.',                                 'ref' => 'Matthew 25:35'),
    ),

    /* ---------- goals shown on the Vision page ---------- */
    'objectives' => array(
        array('goal' => 'Clean Water',   'target' => '60 village wells drilled or restored',            'year' => 2030),
        array('goal' => 'Education',     'target' => '2,000 learners enrolled in tutoring and literacy', 'year' => 2029),
        array('goal' => 'Health',        'target' => '25,000 patients served through mobile clinics',   'year' => 2030),
        array('goal' => 'Church Health', 'target' => '120 local pastors trained and mentored',           'year' => 2028),
    ),

    /* ---------- volunteer skills (checkbox list) ---------- */
    'skills' => array(
        'teaching'   => 'Teaching or tutoring',
        'medical'    => 'Medical or dental care',
        'building'   => 'Construction and repair',
        'water'      => 'Water and sanitation',
        'media'      => 'Photography, video, or writing',
        'languages'  => 'Translation or languages',
        'prayer'     => 'Prayer and pastoral care',
    ),

    /* ---------- weak passwords that are always rejected ---------- */
    'common_passwords' => array('password', 'password1', 'password123', '12345678', 'qwerty123', 'letmein', 'welcome1', 'admin123', 'iloveyou', 'christian1'),

    /* ---------- users table (bcrypt hashes, roles stored in session at login) ---------- */
    'users' => array(
        'admin'     => array('hash' => '$2y$10$WLQPG9LkYOB/asxtYYdh1uT46T24bhIk8qGFWnazPb4s5ZaVuCMDu', 'role' => 'admin',     'display' => 'Site Administrator'),
        'publisher' => array('hash' => '$2y$10$p8K4r/A1Pu55fSwjgPufAeC/7y9q9yexMhhnTPOMKCA71/S.yi5.K', 'role' => 'publisher', 'display' => 'Field Publisher'),
        'customer'  => array('hash' => '$2y$10$AcLQREGzNtG8DHaFjBwAF.AxKBLuhXd525GlAYpxOvApuD4OvTJZq', 'role' => 'customer',  'display' => 'Valued Customer'),
    ),

    /* ---------- role levels ---------- */
    'roles' => array('customer' => 1, 'publisher' => 2, 'admin' => 3),
);
