<?php
// カスタム投稿タイプの設定
add_action( 'init', 'create_post_type' );
function create_post_type() {
    $Supports = ['title','editor','revisions','cumstom-fields','thumbnail'];

    // フロントのMD概要
    register_post_type( 'front', [ // 投稿タイプ名の定義
        'labels' => [
            'name'          => 'フロントページ', // 管理画面上で表示する投稿タイプ名
            'singular_name' => 'front',    // カスタム投稿の識別名
        ],
        'public'        => true,  // 投稿タイプをpublicにするか
        'has_archive'   => false, // アーカイブ機能ON/OFF
        'menu_position' => 5,     // 管理画面上での配置場所
        'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
        'supports' => $Supports,
        'menu_icon'     => 'dashicons-edit'
    ]);

    // 地図
    register_post_type( 'map', [ // 投稿タイプ名の定義
        'labels' => [
            'name'          => 'マップ', // 管理画面上で表示する投稿タイプ名
            'singular_name' => 'map',    // カスタム投稿の識別名
        ],
        'public'        => true,  // 投稿タイプをpublicにするか
        'has_archive'   => false, // アーカイブ機能ON/OFF
        'menu_position' => 5,     // 管理画面上での配置場所
        'show_in_rest'  => false,  // 5系から出てきた新エディタ「Gutenberg」を有効にする
        'supports' => $Supports,
        'menu_icon'     => 'dashicons-location-alt'
    ]);

     register_taxonomy(
        'front_about',  /* タクソノミーのslug */
        'front',        /* 属する投稿タイプ */
        array(
          'hierarchical' => true,
          'update_count_callback' => '_update_post_term_count',
          'label' => 'MDの概要カテゴリー',
          'singular_label' => 'MDの概要カテゴリー',
          'public' => true,
          'show_ui' => true
        )
      );

     register_taxonomy(
        'map-cat',  /* タクソノミーのslug */
        'map',        /* 属する投稿タイプ */
        array(
          'hierarchical' => true,
          'update_count_callback' => '_update_post_term_count',
          'label' => '地図',
          'singular_label' => '地図',
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

// 作成したカスタム投稿タイプにカスタムフィールドを追加
add_action('admin_menu', 'add_custom_fields');
function add_custom_fields(){
    add_meta_box(
        'on-off-field', //編集画面セクションのHTML ID
        '投稿のオン・オフ', //編集画面セクションのタイトル、画面上に表示される
        'insertOnOffButton', //編集画面セクションにHTML出力する関数
        'post', //投稿タイプ名
        'normal' //編集画面セクションが表示される部分
    );
    add_meta_box(
        'on_off_field', //編集画面セクションのHTML ID
        '投稿のオン・オフ', //編集画面セクションのタイトル、画面上に表示される
        'insertOnOffButton', //編集画面セクションにHTML出力する関数
        'front', //投稿タイプ名
        'normal' //編集画面セクションが表示される部分
    );
    add_meta_box(
        'on_off_field', //編集画面セクションのHTML ID
        '投稿のオン・オフ', //編集画面セクションのタイトル、画面上に表示される
        'insertOnOffButton', //編集画面セクションにHTML出力する関数
        'map', //投稿タイプ名
        'normal' //編集画面セクションが表示される部分
    );
    add_meta_box(
        'map_left', //編集画面セクションのHTML ID
        '日時情報等を書きます', //編集画面セクションのタイトル、画面上に表示される
        'insertMetaData', //編集画面セクションにHTML出力する関数
        'map', //投稿タイプ名
        'normal' //編集画面セクションが表示される部分
    );
    add_meta_box(
        'map_right', //編集画面セクションのHTML ID
        '地図情報', //編集画面セクションのタイトル、画面上に表示される
        'insertMap', //編集画面セクションにHTML出力する関数
        'map', //投稿タイプ名
        'normal' //編集画面セクションが表示される部分
    );
    add_meta_box(
        'post-sort-field', //編集画面セクションのHTML ID
        '投稿の順番を決める', //編集画面セクションのタイトル、画面上に表示される
        'insertPostSort', //編集画面セクションにHTML出力する関数
        'post', //投稿タイプ名
        'normal' //編集画面セクションが表示される部分
    );
}

$date_keymaps = array();
$date_keymaps = array(
        '日時'      => array(
                      'key_name'  => 'key_date',
                      'key_value' => '2019/12/08'
                      ),
        '集合場所'  => array(
                      'key_name'  => 'key_local',
                      'key_value' => '千葉県立北総花の丘公園'
                      ),
        'Twitter'  => array(
                      'key_name'  => 'key_twitter',
                      'key_value' => '@mdcnt'
                      )
      );

// 日時等を記載するカスタムフィールド
function insertMetaData() {
  global $post;
  global $date_keymaps;

  $keymaps = array();
  $keymaps = $date_keymaps;
  foreach ($keymaps as $keylabel => $val) {
    echo '<label for="' .$val['key_name']. '">' .$keylabel. '</label><br>';
    echo '<input type="text" name="'.$val['key_name'].'" value="' .get_post_meta($post->ID, $val['key_name'],true). '" placeholder="'. esc_html($val['key_value']) .'"><br>';
    // echo '<input type="text" name="'.$val['key_name'].'" placeholder="'. esc_html($val['key_value']) .'"><br>';
  }
}

// Mapのカスタムフィールドの保存（新規・更新・削除） 任意のラベルにmeta_keyを追加する
add_action('save_post', 'save_map_custom_fields');
function save_map_custom_fields( $post_id ) {
  global $date_keymaps;
  $keymaps = array();
  $keymaps = $date_keymaps;
  foreach ($keymaps as $keylabel => $val) {
      $key_name = $val['key_name'];
      if(isset($_POST[$key_name])) { // textに記入されているならば
        $data = $_POST[$key_name];
        if($data != get_post_meta($post_id, $key_name, true) ) {// すでに別の値を入力済みなら更新する
          update_post_meta($post_id, $key_name , $data);
        }
      }else{
          delete_post_meta($post_id, $key_name, get_post_meta($post_id, $key_name, true));
      }
    }
  }
  // カスタムフィールドの入力エリア
  function insertOnOffButton() {
    global $post;
  
  $options = array('OK','NG');
  $n       = count($options);

  $radio_field = get_post_meta($post->ID, 'on_off',true);
  echo '<label for="on_off_radio_field">ONにチェックが入った記事のみが表示されます。</label><br>';
  for ($i=0; $i<$n; $i++) {
	  $option = $options[$i];
	  if ($option==$radio_field) {
      echo '<input type="radio" name="on_off_radio_button" value="'. esc_html($option) .'" checked > '. $option .' ';
	  } else {
      echo '<input type="radio" name="on_off_radio_button" value="'. esc_html($option) .'" > '. $option .' ';
    }
  }
}

// カスタムフィールドの保存（新規・更新・削除） 任意のラベルにmeta_keyを追加する
add_action('save_post', 'save_my_custom_fields');
function save_my_custom_fields( $post_id ) {
  $key = 'on_off';
  $field_name = 'on_off_radio_button';
  $data = $_POST[$field_name];
  if (get_post_meta($post_id, $key) == "") // 新しいデータなら
    add_post_meta($post_id, $key , $data, true);
  elseif($data != get_post_meta($post_id, $key , true) ) //既存のデータで内容が異なるなら
    update_post_meta($post_id, $key , $data);
  elseif($data=="")
    delete_post_meta($post_id, $key , get_post_meta($post_id, $key , true) );
}

	// if( get_post_meta($post->ID,'book_label',true) == "is-on" ) {
	// 	$book_label_check = "checked";
	// }//チェックされていたらチェックボックスの$book_label_checkの場所にcheckedを挿入
	// echo 'ベストセラーラベル： <input type="checkbox" name="book_label" value="is-on" '.$book_label_check.' ><br>';

//画像をアップする場合は、multipart/form-dataの設定が必要なので、post_edit_form_tagをフックしてformタグに追加
add_action('post_edit_form_tag', 'custom_metabox_edit_form_tag');
function custom_metabox_edit_form_tag(){
  echo ' enctype="multipart/form-data"';
}

// カスタム投稿をフロントに表示する
if ( ! function_exists( 'bulma_get_front_custom_posts' ) ) {
  function bulma_get_front_custom_posts( $taxonomy_name = 'front_about',$post_type= 'front') 
  {
    $args = array(
        'orderby' => 'name',
        'hierarchical' => false
    );
    $taxonomys = get_terms( $taxonomy_name, $args);
    // 指定したタクソノミーとその記事が存在する場合
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
                      'include_children' => true,
                     )
            ),
            // カスタムフィールドで表示のONOFF判定
            'meta_query'  => array (
              array(
                'key'   => 'on_off',
                'value' => 'OK'
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
          echo    '<h2 class="title is-3 front-section__heading" id="' . esc_html($taxonomy->slug) . '">';
          //echo      '<a href="'. $url_taxonomy .'">'. esc_html($taxonomy->name) .'</a>';
          echo    esc_html($taxonomy->name);
          echo    '</h2>';
          echo    '<div class="front-section__content">';
            foreach($tax_posts as $tax_post):
               echo '<article class="front-section__article container">';
               // echo '<h3 class="front-listItem"><a href="'. get_permalink($tax_post->ID).'">'. get_the_title($tax_post->ID).'</a></h3>';
               $custom_post = get_post($tax_post->ID);
               echo '<h3 class="title is-3 front-section__article__title">'. get_the_title($tax_post->ID).'</h3>';
               echo '<div class="columns">';
               echo   '<div class="column is-8">'.$custom_post->post_content.'</div>';
               echo   '<div class="column is-4">' .get_the_post_thumbnail( $tax_post->ID , 'medium' ).'</div>';
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

// フロントのマップ等
if ( ! function_exists( 'bulma_get_archive_custom_posts' ) ) {
  function bulma_get_archive_custom_posts( $taxonomy_name = 'map-cat',$post_type= 'map') 
  {
    $args = array(
        'orderby' => 'name',
        'hierarchical' => false
    );
    $taxonomys = get_terms( $taxonomy_name, $args);
    // 指定したタクソノミーとその記事が存在する場合
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
                      'include_children' => true,
                     )
            ),
            // カスタムフィールドで表示のONOFF判定
            'meta_query'  => array (
              array(
                'key'   => 'on_off',
                'value' => 'OK'
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
          echo    '<h2 class="title is-3 front-section__heading" id="' . esc_html($taxonomy->slug) . '">';
          //echo      '<a href="'. $url_taxonomy .'">'. esc_html($taxonomy->name) .'</a>';
          echo    esc_html($taxonomy->name);
          echo    '</h2>';
          echo    '<div class="front-section__content">';
            foreach($tax_posts as $tax_post):
               echo '<article class="front-section__article container">';
               // echo '<h3 class="front-listItem"><a href="'. get_permalink($tax_post->ID).'">'. get_the_title($tax_post->ID).'</a></h3>';
               $custom_post = get_post($tax_post->ID);
               echo '<h3 class="title is-3 front-section__article__title">'. get_the_title($tax_post->ID).'</h3>';
               echo '<div class="columns">';
               echo   '<div class="column is-8">'.$custom_post->post_content.'</div>';
               echo   '<div class="column is-4">' .get_the_post_thumbnail( $tax_post->ID , 'medium' ).'</div>';
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
