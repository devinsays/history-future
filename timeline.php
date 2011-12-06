<?php
/**
 *
 * @package WordPress
 * @subpackage History of the Future
 * @since Version 0.1
 */
 ?>
 
<div id="timeline">

<?php

$timeline_data = array();

$args = array(
	'category_name'=>'Timeline',
	'posts_per_page'=>'90',
	'meta_key' => '_timelinetimestamp',
	'orderby'=> 'meta_value_num',
	'order' => 'ASC'
	
);
$timelineObj = new WP_Query($args);

if ( $timelineObj->have_posts() ) {
	while ( $timelineObj->have_posts() ) {
		$timelineObj->the_post();
		if ( has_post_thumbnail() ) {
  			$thumbnail = get_the_post_thumbnail(null,'timeline-thumb');
		} else {
			$thumbnail = '<img src="' . get_template_directory_uri() . '/images/sample.jpg" />';
		} 
		$timestamp = get_post_meta($post->ID, '_timelinetimestamp', true);
		$year = get_post_meta($post->ID, '_year', true);
		if ( $year < 0 )
			$year = str_replace('-','',$year) . ' BC';
		$permalink = get_permalink();
		$timeline_data[$timestamp] = array(
			'timestamp' => $timestamp,
			'year'=>$year,
			'thumbnail'=>$thumbnail,
			'permalink'=> $permalink,
			'title' => get_the_title() . ' | ' . get_bloginfo()
		);
	}
}

$clockhtml = '
<div id= "clockshadow">
	<div id="clockbase">
	<div id="year"></div>
	<div id="month"></div>
	<div id="date"></div>
	<div id="day"></div>
	<div id="ampm"></div>
	<div id="sec"></div>
	<div id="hour"></div>
	<div id="min"></div>
	</div>
</div>';

$time_adj = current_time('timestamp');

$timeline_data[gmdate( 'Ymd', $time_adj )] = array(
	'timestamp' => 'Now',
	'year'=>'',
	'thumbnail'=>$clockhtml,
	'permalink'=> get_site_url(),
	'title' => get_bloginfo() . ' | ' . get_bloginfo('description')
);

ksort($timeline_data);

$i = 0;
$len = count($timeline_data);
foreach ($timeline_data as $date ) {
	if ( $i == 0 )
		$past = $date;
	if ( $i == $len - 1 )
		$future = $date;
	$i++;
}
?>
	
	<div id="dates">
		<div id="slider-ui"></div>
			<a id="past" href="<?php echo $past['permalink']; ?>" title="<?php echo $past['title']; ?>" rel="ajax">Past</a>
			<a id="future" href="<?php echo $future['permalink']; ?>" title="<?php echo $future['title']; ?>" rel="ajax">Past</a>
	</div>
	
	<ul id="issues">
		<?php foreach ($timeline_data as $frame ) { ?>
			<li id="year<?php echo $frame['timestamp']; ?>">
				<div class="frame">
				<a href="<?php echo $frame['permalink']; ?>" title="<?php echo $frame['title']; ?>" rel="ajax">
				<?php echo $frame['thumbnail']; ?>
				<?php if ( $frame['year'] != '' ) { ?>
				<?php } ?>
				</a>
				<h3><?php echo $frame['year']; ?></h3>
				</div>
			</li>
		<?php } ?>
	</ul>

	<a href="#" id="next">+</a>
	<a href="#" id="prev">-</a>
		
</div>