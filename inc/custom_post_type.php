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
          echo  '<section class="front-section">';
        //  echo  '<div class="column is-2">';
        //  echo    '<span class="front-icon">'.shard_fontawesome_random($taxonomy->term_id).'</span>'; // アイコンをtermi_idを元にしてランダムに生成する
        //  echo  '</div>';
          echo    '<h2 class="title is-2 front-section__heading" id="' . esc_html($taxonomy->slug) . '">';
          //echo      '<a href="'. $url_taxonomy .'">'. esc_html($taxonomy->name) .'</a>';
          echo    esc_html($taxonomy->name);
          echo    '</h2>';
          echo    '<div class="front-section__content">';
            foreach($tax_posts as $tax_post):
               echo '<article class="front-section__article">';
               // echo '<h3 class="front-listItem"><a href="'. get_permalink($tax_post->ID).'">'. get_the_title($tax_post->ID).'</a></h3>';
               $custom_post = get_post($tax_post->ID);
               echo '<h3 class="title is-3 front-section__article__title">'. get_the_title($tax_post->ID).'</h3>';
               echo '<div class="columns">';
               echo   '<div class="column">'.$custom_post->post_content.'</div>';
               echo   '<div class="column">' .get_the_post_thumbnail( $tax_post->ID , 'thumbnail' ).'</div>';
               echo '</div>';
               echo '<a class="button" href="'.get_the_permalink($tax_post->ID).'">記事の詳細</a>';
               echo '</article>';
            endforeach;
            wp_reset_postdata();
          echo    '</div>';
          echo  '</section>';
        endif;
      } // end foreach
    } // end if
  } // end function
} // end exist


if ( ! function_exists( 'get_bulma_archive_custom_posts' ) )
{
  function get_bulma_archive_custom_posts( $taxonomy_name = 'front_about',$post_type= 'front') 
  {
    $args = array(
        'orderby' => 'name',
        'hierarchical' => false
    );
    $taxonomys = get_terms( $taxonomy_name, $args);

    if(!is_wp_error($taxonomys) && count($taxonomys))
    {
      foreach($taxonomys as $taxonomy)
      {
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
      }
      return $tax_posts;
    }
    return 0;
  }
}