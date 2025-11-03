<?php 

// Add Speculation Rules API for prefetching and prerendering
function add_speculation_rules()
{
	// Only add on frontend, not in admin
	if (is_admin()) {
		return;
	}

	$speculation_rules = array(
		'prefetch' => array(
			array(
				'source' => 'document',
				'where' => array(
					'and' => array(
						array('href_matches' => '/*'),
						array('not' => array('href_matches' => '/wp-admin/*')),
						array('not' => array('href_matches' => '/wp-login.php')),
						array('not' => array('href_matches' => '/*.zip')),
						array('not' => array('href_matches' => '/*.pdf')),
						array('not' => array('selector_matches' => '.no-prefetch'))
					)
				),
				'eagerness' => 'moderate'
			)
		),
		'prerender' => array(
			array(
				'source' => 'document',
				'where' => array(
					'and' => array(
						array('href_matches' => '/*'),
						array('not' => array('href_matches' => '/wp-admin/*')),
						array('not' => array('href_matches' => '/wp-login.php')),
						array('not' => array('selector_matches' => '.no-prerender'))
					)
				),
				'eagerness' => 'conservative'
			)
		)
	);

	echo '<script type="speculationrules">' . "\n";
	echo wp_json_encode($speculation_rules, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	echo "\n" . '</script>' . "\n";
}
add_action('wp_head', 'add_speculation_rules', 2);
