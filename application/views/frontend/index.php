<!DOCTYPE html>
<html lang="en">

<head>
	<!-- <script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "WebSite",
			"url": "https://findmart.in/",
			"potentialAction": {
				"@type": "SearchAction",
				"target": {
					"@type": "EntryPoint",
					"urlTemplate": "https://findmart.in/home/search?search_string={search_term_string}"
				},
				"query-input": "required name=search_term_string"
			}
		}
	</script> -->

	<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "Website",
			"name": "<?php echo $title; ?>",
			"url": "<?php echo current_url(); ?>",
			"potentialAction": {
				"@type": "SearchAction",
				"target": {
					"@type": "EntryPoint",
					"urlTemplate": "https://findmart.in/home/search?search_string={search_term_string}"
				},
				"query-input": "required name=search_term_string"
			}
		}
	</script>

	<!-- Meta tags and seo configuration -->
	<?php include 'site_meta.php'; ?>

	<!-- Top css library files -->
	<?php include 'includes_top.php'; ?>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-91Z093VYQL"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'G-91Z093VYQL');
	</script>

	<!-- Google Tag Manager -->
	<script>
		(function(w, d, s, l, i) {
			w[l] = w[l] || [];
			w[l].push({
				'gtm.start': new Date().getTime(),
				event: 'gtm.js'
			});
			var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s),
				dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
			f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-MHHX6NQ');
	</script>
	<!-- End Google Tag Manager -->

</head>

<body>
	<div id="page">

		<!-- Header -->
		<?php
		if ($page_name == 'home' || $page_name == '404')
			include 'header_home.php';
		else if ($page_name == 'listings' || $page_name == 'listing/create')
			include 'header_listing.php';
		else if ($page_name == 'directory_listing')
			include 'header_home.php';
		else
			include 'header.php';
		?>

		<!-- Main page -->
		<main>
			<?php include $page_name . '.php'; ?>
		</main>

		<!-- Site footer -->
		<?php
		if (!($page_name == 'listings' && $this->session->userdata('listings_view') == 'list_view')) :
			include 'footer.php';
		endif;
		?>
	</div>


	<!-- Back to top button -->
	<div id="toTop"></div>

	<!-- Bottom js library files -->
	<?php include 'includes_bottom.php'; ?>

	<!--modal-->
	<?php include 'modal.php'; ?>

	<!-- Signin popup -->
	<?php
	if ($this->session->userdata('is_logged_in') != 1) {
		if ($page_name == 'listings' || $page_name == 'directory_listing') :
			include 'signin_popup.php';
		endif;
	}
	?>

	<?php
	if (get_frontend_settings('cookie_status') == 1) :
		include 'eu-cookie.php';
	endif;
	?>
	<?php
	if (get_addon_details('fb_messenger') != 0) {
		if (isset($listing_details['id'])) :
			if (check_facebook_page_data($listing_details['id']) && $page_name == 'directory_listing') {
				include 'fb_messenger.php';
			}
		endif;
	}
	?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MHHX6NQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

</body>

</html>