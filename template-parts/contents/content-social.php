
<section id="social-share" class="hero is-light">
	<div class="hero-body">
		<h2 class="title is-3 has-text-centered"><?php esc_html_e( 'Share', 'bulmascores' ); ?></h2>
		<div class="level is-mobile">
			<div class="level-item has-text-centered">
				<div>
					<a class=title target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fab fa-facebook-f"></i></a>
					<p class="heading"><?php esc_html_e( 'Facebook', 'bulmascores' ); ?></p>
				</div>
			</div>
			<div class="level-item has-text-centered">
				<div>
					<a class="title" target="_blank" href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>"><i class="fab fa-twitter"></i></a>
					<p class="heading"><?php esc_html_e( 'Twitter', 'bulmascores' ); ?></p>
				</div>
			</div>
			<div class="level-item has-text-centered">
				<div>
					<a class="title" target="_blank" href="https://telegram.me/share/url?url=<?php the_permalink(); ?>"><i class="fab fa-telegram-plane"></i></a>
					<p class="heading"><?php esc_html_e( 'Telegram', 'bulmascores' ); ?></p>
				</div>
			</div>
			<div class="level-item has-text-centered">
				<div>
					<a class="title" href="whatsapp://send?text=<?php the_permalink(); ?>" data-action="share/whatsapp/share"><i class="fab fa-whatsapp"></i></a>
					<p class="heading"><?php esc_html_e( 'WhatsApp', 'bulmascores' ); ?></p>
				</div>
			</div>
		</div><!-- .level -->
	</div><!--hero-body -->
</section><!-- #social-share -->
