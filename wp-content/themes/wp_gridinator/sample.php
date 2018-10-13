<!DOCTYPE html>
<html>
<head>
</head>
<body class="<?php echo $page; ?>">

	<!-- navigation -->
	<div id="mainNav" class="close">
		
		<a class="nav-close fa fa-times"></a>

		<nav class="JG-nav nav-inner">
			<a href="../about/" class="<?php if ($page == 'about') { echo 'active'; } ?>">about Joey G.</a>
			<a href="../resume/" class="<?php if ($page == 'resume') { echo 'active'; } ?>">résumé</a>
			<a href="../portfolio/" class="<?php if ($page == 'portfolio' || $page == 'project') { echo 'active'; } ?>">portfolio</a>
			<a href="../blog/" class="<?php if ($page == 'blog') { echo 'active'; } ?>">blog</a>
			<a class="contact-open">contact</a>
			<ul class="social-links">
				<li><a class="sm-li fa fa-linkedin" href="https://www.linkedin.com/in/joeygrable94/" target="_blank"></a></li>
				<li><a class="sm-fb fa fa-facebook-f" href="https://www.facebook.com/joeygrable94/" target="_blank"></a></li>
				<li><a class="sm-tw fa fa-twitter" href="https://twitter.com/JoeyGrable94" target="_blank"></a></li>
				<li><a class="sm-gt fa fa-git" href="https://github.com/joeygrable94" target="_blank"></a></li>
			</ul>
		</nav>
	</div>

	<!-- contact
	<div id="JoeyG"  class="">
		<a class="contact-close fa fa-times"></a>
		<div class="JG-logo-block">
			<h1 class="logo-Joey">Joey<span class="logo-G">G</span></h1>
			<nav class="logo-sub">
				<a href="tel:+1-949-292-6564">+1.949.292.6564</a>
				<a href="mailto:joeyg@joeygrable.com" target="_blank">joeyg@joeygrable.com</a>
				<a href="http://www.joeygrable.com/" target="_blank">joeygrable.com</a>
				<a href="https://www.linkedin.com/in/joeygrable94" target="_blank">@joeygrable94</a>
			</nav>
		</div>
	</div>
	-->

	<!-- page example -->
	<div id="page">
		
		<!-- nav toggle -->
		<div class="nav-toggle">
			<a class="nav-open fa fa-times"></a>
			<h3 class="nav-title"><?php echo $page; ?></h3>
			<img id="JoeyG-logo" src="../inc/images/brand-element_JoeyG-white.png">
		</div>

		<!-- about -->
		<article class="grid-base grid-about">
			<div class="grid-inner flex">
				<div class="about-content">
					<h2>Hello,<br>I'm Joey G.</h2>
					<p class="objective">I strive to be a reliable digital designer who learns fast and enjoys organization. With a diverse background in digital and print design, I seek to apply my creative problem solving knowledge in the digital design industry, or to obtain a position that will improve my communication, leadership, and creative abilities.</p>
				</div>
				<div class="about-image">
					<img class="portrait" src="../inc/images/JoeyG_grad-portrait-02_halfQ.jpg">
					<p class="sub sub-right">photograph by <a>@KevinTranMedia</a></p>
				</div>
			</div>
		</article>
	</div>

	<div class="footer-contact hide">
		<h1 class="logo-Joey">Joey<span class="logo-G">G</span></h1>
		<nav class="logo-sub">
			<a href="tel:+1-949-292-6564">+1.949.292.6564</a>
			<a href="mailto:joeyg@joeygrable.com" target="_blank">joeyg@joeygrable.com</a>
			<a href="http://www.joeygrable.com/" target="_blank">joeygrable.com</a>
			<a href="https://www.linkedin.com/in/joeygrable94" target="_blank">@joeygrable94</a>
		</nav>
	</div>

</body>
</html>