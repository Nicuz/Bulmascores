<?php
// カスタム投稿タイプの設定
add_action( 'init', 'create_post_type' );
function create_post_type() {
    $Supports = ['title','editor','revisions','cumstom-fields','thumbnail'];

    register_post_type( 'front', [ // 投稿タイプ名の定義
        'labels' => [
            'name'          => 'フロントページ', // 管理画面上で表示する投稿タイプ名
            'singular_name' => 'front',    // カスタム投稿の識別名
        ],
        'public'        => true,  // 投稿タイプをpublicにするか
        'has_archive'   => false, // アーカイブ機能ON/OFF
        'menu_position' => 5,     // 管理画面上での配置場所
        'show_in_rest'  => true,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
        'supports' => $Supports
    ]);

     register_taxonomy(
       'front_news',  /* タクソノミーのslug */
       'front',        /* 属する投稿タイプ */
        array(
          'hierarchical' => true,
          'update_count_callback' => '_update_post_term_count',
          'label' => 'ニュース',
          'singular_label' => 'ニュース',
          'public' => true,
          'show_ui' => true
        )
        );

     register_taxonomy(
        'front_about',  /* タクソノミーのslug */
        'front',        /* 属する投稿タイプ */
        array(
          'hierarchical' => true,
          'update_count_callback' => '_update_post_term_count',
          'label' => 'MDの概要',
          'singular_label' => 'MDの概要',
          'public' => true,
          'show_ui' => true
        )
      );
    // register_post_type( 'news', [ // 投稿タイプ名の定義
    //     'labels' => [
    //         'name'          => 'ニュース', // 管理画面上で表示する投稿タイプ名
    //         'singular_name' => 'news',    // カスタム投稿の識別名
    //     ],
    //     'public'        => true,  // 投稿タイプをpublicにするか
    //     'has_archive'   => false, // アーカイブ機能ON/OFF
    //     'menu_position' => 5,     // 管理画面上での配置場所
    //     'show_in_rest'  => true,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
    //     'supports' => $Supports
    // ]);
}

if ( ! function_exists( 'bulma_get_archive_custom_posts' ) ) {
  function bulma_get_archive_custom_posts( $taxonomy_name = 'front_about',$post_type= 'front') 
  {
    $args = array(
        'orderby' => 'name',
        'hierarchical' => false
    );
    $taxonomys = get_terms( $taxonomy_name, $args);
    if(!is_wp_error($taxonomys) && count($taxonomys)) {
      foreach($taxonomys as $taxonomy) {
        $url_taxonomy = get_term_link($taxonomy->slug, $taxonomy_name);
        $tax_get_array = array(
            'post_type' => $post_type, //表示したいカスタム投稿
            'posts_per_page' => 5,//表示件数
            // https://blog.nakachon.com/2014/10/27/dont-use-name-field-tax-query-in-japanese/
            // termsにはidを, fieldにはterm_idを入れるべき
            'tax_query' => array(
                array(
                      'taxonomy' => $taxonomy_name,
                      'terms'     => array($taxonomy -> term_id),
                      'field'    => 'term_id',
                      'operator' => 'IN',
                      'include_children' => true
                     )
            )
        );
        $tax_posts = get_posts( $tax_get_array );
        // ポストが存在するならば
        if($tax_posts):
          echo '<section class="column is-12-mobile is-6-tablet is-4-desktop front-section">';
          echo  '<div class="front-section__columns columns is-mobile">';
        //  echo  '<div class="column is-2">';
        //  echo    '<span class="front-icon">'.shard_fontawesome_random($taxonomy->term_id).'</span>'; // アイコンをtermi_idを元にしてランダムに生成する
        //  echo  '</div>';
          echo  '<div class="front-section__content column">';
          echo    '<h2 class="front-heading" id="' . esc_html($taxonomy->slug) . '">';
          echo      '<a href="'. $url_taxonomy .'">'. esc_html($taxonomy->name) .'</a>';
          echo    '</h2>';
          echo    '<ul class="front-list">';
            foreach($tax_posts as $tax_post):
               echo '<li class="front-listItem"><a href="'. get_permalink($tax_post->ID).'">'. get_the_title($tax_post->ID).'</a></li>';
            endforeach;
            wp_reset_postdata();
          echo     '</ul>';
          echo    '</div>';// #front-section__content
          echo   '</div>';
          echo '</section>';
        endif;
      } // end foreach
    } // end if
  } // end function
} // end exist