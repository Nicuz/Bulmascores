<?php 
if( get_the_hero_background_img_url() ) {
    $top_hero_bg = get_the_hero_background_img_url();
}else{
    $top_hero_bg = get_template_directory_uri().'/assets/img/top-hero.jpg';
}
?>
<section style="background: url(<?php echo $top_hero_bg ; ?>); background-size: cover; background-position: center center;" class="hero is-primary is-large">
    <div class="hero is-medium">
    <img src="<?php echo $top_hero_bg; ?>">
        <div class="hero-body--2">
            <div class="hero-mdcenter container has-text-centered" >
                <?php $logo_url= get_the_hero_logo_img_url(); 
                echo '<img width="100" src="'.$logo_url.'">';
                ?> 
                <h1 class="title is-1"><?php bloginfo('name'); ?></h1>
                <h2 class="subtitle is-3">
                <?php bloginfo('description'); ?>
                </h2>
                <p><?php echo get_option('top_hero_option_2') ?></p>
                <p><?php echo get_option('top_hero_option_3') ?></p>
                <a class="button is-white is-outlined is-large is-rounded" href="//ingress.com/ja/events/">
                <?php echo get_option('top_hero_option_1') ?>
                </a>
            </div>
        </div>
    </div>
</section>