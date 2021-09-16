<?php get_header();?>
<main id="main">
<header class="header">
<div class = "ucla campus">
<div class= "col span_12_of_12">
<br><br>
<?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) );?>
<section class="story">
<div class="story__featured">
    <article class="story__featured-card">
      <a href="#" tabindex="-1">
      <img class="story__featured-image" src="<?php echo $thumbnail[0]?>">
      </a>
 <div class="story__featured-content">
        <h3 class="story__featured-title"><?php echo get_the_title( $post_id ); ?></h3>
	<p class="story__featured-blurb"><?php if(get_post_meta($post->ID, 'event_speaker', true)):?>
	<b>Speaker: </b><?php
	  echo get_post_meta($post->ID, 'event_speaker', true);
endif;?><br><b>Institution:</b>
<?php if(get_post_meta($post->ID, 'event_institution', true)):?>
        <?php
          echo get_post_meta($post->ID, 'event_institution', true);
endif;?><br><b>Location: </b>
<?php if(get_post_meta($post->ID, 'event_location', true)):?>
        <?php
          echo get_post_meta($post->ID, 'event_location', true);
endif;?>

</p>
      </div>
    </article>
  </div>
</section>
</div>
</div>
</header>
<br>
<!--Display Date + Time info-->
<div class = "ucla campus">
<div class= "col span_8_of_12">
<h5><?php if(get_post_meta($post->ID, 'event_date', true)):?>
        <?php
          echo get_post_meta($post->ID, 'event_date', true);
endif;?>
 | <?php if(get_post_meta($post->ID, 'event_time', true)):?>
        <?php
          echo get_post_meta($post->ID, 'event_time', true);
endif;?>
 </h5>
<p><?php the_content(); ?> </p>
</div>
<div class= "col span_3_of_12">
<h2 class="yellow-side-header">More Images</h2>
<br><br>
</div>
<div class= "col span_12_of_12">
<h2 class="yellow-side-header">More AOS Events</h2>
<br><br>
<?php
$args = array (
	'category__in' => wp_get_post_categories( get_queried_object_id() ),
	'post_type'=>'events',
                'posts_per_page' => 4,
                'orderby'       => 'date',
                'post__not_in' => array( get_queried_object_id() )
                );
    $the_query = new WP_Query( $args );?>
<section class="story">
	<div class="story__secondary section group"><?php
    if ( $the_query->have_posts() ) : ?>
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
    $thumbnail_other = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) );?>
    <article class="story__secondary-card">
    <a href=""<?php the_permalink(); ?>"">
    <div class="story__secondary-image-wrapper"><img class="story__secondary-image" src="<?php echo $thumbnail_other[0]?>" /></div>
        <h1 class="story__secondary-title">
	<span class="story__secondary-title-text"><?php echo the_title();?></span>
        </h1>
      </a>
      <div class="story__secondary-content">
        <p class="story__secondary-blurb"><b>Speaker: </b><?php if(get_post_meta($post->ID, 'event_speaker', true)):
	echo get_post_meta($post->ID, 'event_speaker', true);endif;?><br><b>Institution:</b>
<?php if(get_post_meta($post->ID, 'event_institution', true)):?>
        <?php
          echo get_post_meta($post->ID, 'event_institution', true);
endif;?><br><b>Location: </b>
<?php if(get_post_meta($post->ID, 'event_location', true)):?>
        <?php
          echo get_post_meta($post->ID, 'event_location', true);
endif;?>
<br><b>When: </b>
<?php if(get_post_meta($post->ID, 'event_date', true)):?>
        <?php
echo get_post_meta($post->ID, 'event_date', true);endif;?> from <?php if(get_post_meta($post->ID, 'event_time', true)):?>
        <?php
echo get_post_meta($post->ID, 'event_time', true);
endif;?>

</p>
        <p class="story__secondary-source"></p>
      </div>
    </article>
        <?php endwhile; ?>
        
        <?php wp_reset_postdata(); ?>

     <?php endif; ?>
</div></section>
</div>
</main>
<?php get_footer(); ?>
