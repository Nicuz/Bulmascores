<?php 
if( get_the_hero_background_img_url() ) {
    $top_hero_bg = get_the_hero_background_img_url();
}else{
    $top_hero_bg = get_template_directory_uri().'/assets/img/top-hero.jpg';
}
?>
<section>
    <div class="hero--2 is-medium">
        <img src="<?php echo $top_hero_bg; ?>">
    </div>
</section>