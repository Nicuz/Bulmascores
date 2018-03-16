<?php
/**
 * The template for displaying search forms in Underscores.me
 *
 * @package bulmascores
 */

?>

<form role="search" method="get" id="searchform" action="<?php echo esc_url_raw( home_url( '/' ) );?>">

	<div class="field has-addons">

		<div class="control is-expanded">
			<input class="input" name="s" type="text" placeholder="<?php esc_html_e( 'Search &hellip;', 'bulmascores' ); ?>">
		</div>

		<div class="control">
			<button type="submit" class="button is-dark"><i class="fas fa-search"></i></button>
		</div>
	
	</div>
</form>
