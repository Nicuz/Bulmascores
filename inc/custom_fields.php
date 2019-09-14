<?php
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
        'ここに必要な日時や地図情報を書きます', //編集画面セクションのタイトル、画面上に表示される
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
        'catch', //編集画面セクションのHTML ID
        'キャッチコピー', //編集画面セクションのタイトル、画面上に表示される
        'insertCatch', //編集画面セクションにHTML出力する関数
        'front', //投稿タイプ名
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
                      'key_name'         => 'key_date',
                      'key_public_name'  => '開催日時',
                      'key_value'        => '2019年12月'
                      ),
        '集合場所'  => array(
                      'key_name'         => 'key_local',
                      'key_public_name'  => '集合場所',
                      'key_value'        => '千葉県立北総花の丘公園'
                      ),
        '受付会場'  => array(
                      'key_name'         => 'key_uketuke',
                      'key_public_name'  => '受付会場',
                      'key_value'        => '千葉県立北総花の丘公園'
                      ),
        'TwitterIDを書きます。@は不要です。'  => array(
                      'key_name'         => 'key_twitter',
                      'key_public_name'  => 'MD公式Twitter',
                      'key_value'        => 'mdcnt'
                      )
      );
$date_mappings = array();
$date_mappings = array(
        'MAPを貼り付けてください'  => array(
                      'key_name'         => 'key_map',
                      'key_public_name'  => '会場周辺地図',
                      'key_value'        => 'OSMのコードを貼り付けます'
                      )
);

$key_catch = array();
$key_catch = array(
        'key_catch'  => array(
                      'key_name'         => 'key_catch',
                      'key_label'        => 'キャッチコピーを入力',
                      'key_public_name'  => 'キャッチコピーを入力',
                      'key_value'        => 'キャッチコピーを15文字程度で'
                      )
);
// キャッチコピーを入力するカスタムフィールド
function insertCatch() {
  global $post;
  global $key_catch;  

  $keymaps = $key_catch;

  foreach ($keymaps as $key => $val) {
    echo '<label for="' .$key. '">' .$val['key_label']. '</label><br>';
    echo '<input type="text" width="60" name="'.$key.'" value="' .esc_html( get_post_meta($post->ID, $key, true) ). '" placeholder="'. esc_html($val['key_value']) .'"><br>';
    // echo '<input type="text" name="'.$val['key_name'].'" placeholder="'. esc_html($val['key_value']) .'"><br>';
  }
}

// Mapのカスタムフィールドの保存（新規・更新・削除） 任意のラベルにmeta_keyを追加する
add_action('save_post', 'save_catch_custom_fields');
function save_catch_custom_fields( $post_id ) {
  global $key_catch;
  $keymaps = array();
  $keymaps = $key_catch;
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

// 日時等を記載するカスタムフィールド
function insertMetaData() {
  global $post;
  global $date_keymaps;

  $keymaps = array();
  $keymaps = $date_keymaps;
  foreach ($keymaps as $keylabel => $val) {
    echo '<label for="' .$val['key_name']. '">' .$keylabel. '</label><br>';
    echo '<input type="text" name="'.$val['key_name'].'" value="' .esc_html( get_post_meta($post->ID, $val['key_name'],true) ). '" placeholder="'. esc_html($val['key_value']) .'"><br>';
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

// MAPの貼り付けデータを記載するカスタムフィールド
function insertMap() {
  global $post;
  global $date_mappings;

  $keymaps = array();
  $keymaps = $date_mappings;
  foreach ($keymaps as $keylabel => $val) {
    $key_name = $val['key_name'];
    echo '<label for="' .$key_name. '">' .$keylabel. '</label><br>';
    echo '<textarea type="text" name="'.$key_name.'" placeholder="'. esc_html($val['key_value']) .'" cols="100" rows="8">';
    echo esc_html( get_post_meta($post->ID, $val['key_name'], true) );
    echo '</textarea>';
    // echo '<textarea id="'.$val['key_name'].'" type="text" name="'.$val['key_name'].'" value="' .get_post_meta($post->ID, $val['key_name'],true). '" placeholder="'. esc_html($val['key_value']) .'" cols="100" rows="8" ></textarea>';
    // echo '<input type="text" name="'.$val['key_name'].'" placeholder="'. esc_html($val['key_value']) .'"><br>';
  }
}

// OSMデータを貼り付けるカスタムフィールドの保存（新規・更新・削除） 任意のラベルにmeta_keyを追加する
add_action('save_post', 'save_osm_custom_fields');
function save_osm_custom_fields( $post_id ) {
  global $date_mappings;
  $keymaps = array();
  $keymaps = $date_mappings;
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
  if( isset($_POST[$field_name]) ) {
    $data = $_POST[$field_name];
    if( $data != get_post_meta($post_id, $key , true) ) {//既存のデータで内容が異なるなら
      update_post_meta($post_id, $key , $data);
    }
  }else{
    delete_post_meta($post_id, $key , get_post_meta($post_id, $key , true) );
  }
}