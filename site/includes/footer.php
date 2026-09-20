<?php
/*
 * footer.php: closes the main column, shows the sidebar, and prints the
 * footer with the W3C validation icons and the last modified timestamp.
 */
$verse = verse_of_the_day();
?>
</div>

<div id="side">
<div class="panel">
<h2>Verse of the Day</h2>
<p class="verse">&#8220;<?php echo h($verse['text']); ?>&#8221;</p>
<p class="verse-ref"><?php echo h($verse['ref']); ?></p>
</div>
<div class="panel">
<h2>Your Cart</h2>
<p><?php echo h(cart_label()); ?> &#183; <?php echo h(money(cart()->subtotalCents())); ?></p>
<p><a href="cart.php">View cart</a> &#183; <a href="store.php">Shop</a></p>
</div>
<div class="panel">
<h2>Get Involved</h2>
<ul>
<li><a href="volunteer.php">Serve on a team</a></li>
<li><a href="prayer.php">Send a prayer request</a></li>
<li><a href="contact.php">Contact the office</a></li>
</ul>
</div>
</div>
</div>

<div id="footer">
<ul class="footer-links">
<li><a href="index.php">Home</a></li>
<li><a href="about.php">Our Story</a></li>
<li><a href="store.php">Mission Store</a></li>
<li><a href="contact.php">Contact</a></li>
<li><a href="sitemap.php">Site Map</a></li>
</ul>
<p class="badges">
<a href="https://validator.w3.org/check?uri=referer"><img src="https://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
<a href="https://jigsaw.w3.org/css-validator/check/referer"><img src="https://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS" height="31" width="88" /></a>
</p>
<p class="modified">This page was last modified on <?php echo h(last_modified()); ?>.</p>
<p class="fine">Beacon Road Missions is a fictional organization created for a web development course. Images and product copy were produced with AI assistance. &#169; <?php echo date('Y'); ?> Beacon Road Missions.</p>
</div>

</div>
</body>
</html>
