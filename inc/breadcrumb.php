<?php
// パンくずリストを出力する
function breadcrumb($divOption = array("class" => "breadcrumb-yugioh")) {
  global $post;
  $str ='';
  $containerOption = array("breadcrumbs-yugioh", "is-dark", "is-shadow");
  $innerOption     = array("container", "breadcrumb-yugioh__inner");
  $ulOption = array("class" => "breadcrumb-yugioh__list");
  $liOption = array("class" => "breadcrumb-yugioh__item", "itemprop" => "itemListElement");

  if(is_front_page() || is_home() || is_admin()) {
    return ;
  }elseif(!is_home() && !is_admin()) {
    $schemaBread = 'https://schema.org/BreadcrumbList';
    $schemaList  = 'https://schema.org/ListItem';
    $position    = 1;

    $containerAttribute = '';
    $containerAttribute .= sprintf(' class="%1$s" ', implode(' ',$containerOption)); // 配列の中身を区切り文字を入れて結合

    $innerAttribute = '';
    $innerAttribute .= sprintf('class="%1$s" ', implode(' ',$innerOption)); // 配列の中身を区切り文字を入れて結合

    $tagAttribute = '';
    foreach($divOption as $attrName => $attrValue) {
      $tagAttribute .= sprintf(' %1$s="%2$s"', $attrName, $attrValue);
    }
    $ulAttribute = '';
    foreach($ulOption as $attrName => $attrValue) {
      $ulAttribute .= sprintf(' %1$s="%2$s"', $attrName, $attrValue);
    }
    $liAttribute = '';
    foreach($liOption as $attrName => $attrValue) {
      $liAttribute .= sprintf(' %1$s="%2$s" ', $attrName, $attrValue);
    }
    $navTitle = '<h2 class="screen-reader-text">BreadCrumbs</h2>';

    $currentOption = 'class="breadcrumb-yugioh__current"';

    $str .= sprintf(
      '<div %1$s><div %2$s><nav %3$s>%4$s<ul %5$s itemscope itemtype="%6$s"><li %7$s itemscope itemtype="%8$s" ><a itemprop="url" href="%9$s"><span itemprop="url"><i class="fas fa-home"></i> Home</span></a><meta itemprop="position" content="%9$d" /></li>',
      $containerAttribute,
      $innerAttribute,
      $tagAttribute,
      $navTitle,
      $ulAttribute,
      esc_url( $schemaBread ),
      $liAttribute,
      esc_url( $schemaList ),
      esc_url( home_url() ),
      $position
    );

    if(is_single()) {
      $post_type = get_query_var( 'post_type' );
      if($post_type == false ) { // 一般的な投稿だった場合
        $categories = get_the_category($post->ID); // カテゴリーIDを取得
        $cat        = $categories[0]; //最初の要素のカテゴリーだけを抽出
        // $strSingle = '';

        // 親カテゴリーがある場合
        if($cat -> parent !=0 ) {
          $ancestors = array_reverse(get_ancestors( $cat->cat_ID, 'category' )); // 親カテを昇順で取得
          foreach( $ancestors as $ancestor ) {
            ++$position;//ポジションを設定する
            $str .= sprintf(
              '<li %1$s itemscope itemtype="%2$s"><a itemprop="url" href="%3$s"><span itemprop="name"><i class="far fa-folder-open"></i> %4$s</span></a><meta itemprop="position" content="%5$d" /></li>',
              $liAttribute,
              esc_html( $schemaList ),
              esc_url( get_category_link( $ancestor ) ),
              esc_html( get_cat_name( $ancestor )),
              $position
            );
          }
        }

        $str .= sprintf(
          '<li %1$s itemscope itemtype="%2$s"><a itemprop="url" href="%3$s"><span itemprop="name"><i class="far fa-folder-open"></i> %4$s</span></a><meta itemprop="position" content="%5$d" /></li>',
          $liAttribute,
          esc_html( $schemaList ),
          esc_url( get_category_link( $cat->term_id ) ),
          esc_html( get_cat_name( $cat->cat_ID )),
          ++$position
        );

        $str .= sprintf(
          '<li %1$s itemscope itemtype="%2$s"><span %3$s itemprop="name"> %4$s</span><meta itemprop="position" content="%5$d" /></li>',
          $liAttribute,
          esc_html( $schemaList ),
          $currentOption,
          esc_html( mb_substr( $post->post_title,0,30 ) ),//30文字制限
          ++$position
        );
      }else{
        // カスタム投稿タイプ
        // タームからはカテゴリーかタグ化を判定できないので、両方が混ざると非常に危険なので投稿名だけを表示することにした
        // $custom_post_type = get_query_var('post_type') ;
        // $taxes = get_object_taxonomies($custom_post_type);
        // $mytax = $taxes[0];
        // $taxes = get_the_terms($post->ID, $mytax);
        // $tax = $taxes ? get_youngest_tax($taxes, $mytax): null;
        // if (!empty($tax)) {
        //   if($tax -> parent !=0) {//親要素がある
        //     $ancestors = array_reverse(get_ancestors($tax -> term_id, $mytax));
        //       foreach($ancestors as $ancestor) {
        //         $str .= sprintf(
        //           '<li %1$s itemscope itemtype="%2$s"><a itemprop="url" href="%3$s"><span itemprop="name">%4$s</span></a></li>',
        //           $liAttribute, // 1
        //           esc_html( $schemaList ), //2
        //           esc_url( get_term_link( $ancestor, $mytax )), //3
        //           esc_html( get_term( $ancestor, $mytax )) //4
        //         );
        //       }
        //   }
        // }
        // $str .= sprintf(
        //   '<li %1$s itemscope itemtype="%2$s"><a itemprop="url" href="%3$s"><span itemprop="name">%4$s</span></a></li>',
        //   $liAttribute, // 1
        //   esc_html( $schemaList ), //2
        //   esc_url( get_term_link( $tax, $mytax )), //3
        //   esc_html( $tax->name ) //4
        // );
        $str .= sprintf(
          '<li %1$s itemscope itemtype="%2$s"><span %3$s itemprop="name">%4$s</span></li>',
          $liAttribute,
          esc_html( $schemaList ),
          $currentOption,
          esc_html( mb_substr( $post->post_title,0,30 ) )//30文字制限
        );
      }
    }
    elseif(is_category()) {
      $cat = get_queried_object();
      // $strCat = '';
      if( $cat -> parent !=0 ) {
        $ancestors = array_reverse(get_ancestors( $cat->cat_ID, 'category' ));
        foreach($ancestors as $ancestor) {
          ++$position;
          $str .= sprintf(
            '<li %1$s itemscope itemtype="%2$s"><a itemprop="url" href="%3$s"><span itemprop="name">%4$s</span></a><meta itemprop="position" content="%5$d" /></li>',
            $liAttribute,
            esc_html( $schemaList ),
            esc_url( get_category_link( $ancestor ) ),
            esc_html( get_cat_name( $ancestor ) ),
            $position
          );
        }
        // $str .= $strCat;
      }
      $str .= sprintf(
        '<li %1$s itemscope itemtype=%2$s><span %3$s itemprop="name">%4$s</span><meta itemprop="position" content="%5$d" /></li>',
        $liAttribute,
        esc_html( $schemaList ),
        $currentOption,
        esc_html( $cat -> name ),
        ++$position
      );
    }
    elseif(is_page()) {
      if( $post -> post_parent !=0 ) {
        $ancestors = array_reverse( get_ancestors( $post->ID ) );
        foreach( $ancestors as $ancestor ) {
          ++$position;
          $str .= sprintf(
            '<li %1$s itemscope itemtype="%2$s"><a href="%3$s" itemprop="url"><span itemprop="name">%4$s</span></a><meta itemprop="position" content="%5$s" /></li>',
            $liAttribute,
            esc_html( $schemaList ),
            esc_url( getpermalink($ancestor) ),
            esc_html( get_the_title($ancestor) ),
            $position
            );
        }
      }
      $str .= sprintf(
        '<li %1$s itemscope itemtype="%2$s"><span %3$s itemprop="name">%4$s</span><meta itemprop="position" content="%5$d" /></li>',
        $liAttribute,
        esc_html( $schemaList ),
        $currentOption,
        esc_html( $post->post_title ),
        ++$position
        );
    }
    elseif(is_tag()) {
      $str .= sprintf(
          '<li %1$s itemscope itemtype="%2$s"><span %3$s itemprop="name">%4$s</span></li>',
          $liAttribute,
          esc_url( $schemaList ),
          $currentOption,
          esc_html(single_tag_title('',false))//取得するだけなのでfalseをつける
        );
    }
    elseif(is_tax()) {
      // タクソノミー
      $tax_obj = get_queried_object();
      if( $tax_obj -> parent !=0 ):
        $tax_ancestors = array_reverse(get_ancestors( $tax_obj->term_id, $tax_obj->taxonomy ));
        foreach( $tax_ancestors as $tax_ancestor ):
          $parent_term_obj = get_term($tax_ancestor,$tax_obj->taxonomy);//親要素のオブジェクトを取得
          ++$position;
          $str .= sprintf(
            '<li %1$s itemscope itemtype="%2$s"><a itemprop="url" href="%3$s"><span itemprop="name">%4$s</span></a><meta itemprop="position" content="%5$d" /></li>',
            $liAttribute,
            esc_html( $schemaList ),
            esc_url( get_term_link( $tax_ancestor ) ),//親要素のリンク
            esc_html( $parent_term_obj->name ),//親要素の名前をフィルター
            $position
          );
        endforeach;
      endif;

      $str .= sprintf(
        '<li %1$s itemscope itemtype=%2$s><span %3$s itemprop="name">%4$s</span><meta itemprop="position" content="%5$d" /></li>',
        $liAttribute,
        esc_html( $schemaList ),
        $currentOption,
        esc_html( $tax_obj->name ),
        ++$position
      );
    }
    elseif(is_date()) {
      if(is_day() !=0) {
        // 年を出力
        $str .= sprintf(
          '<li %1$s itemscope itemtype="%2$s"><a itemprop="url" href="%3$s"><span itemprop="name">%4$s</span></a></li>',
          $liAttribute,
          esc_url( $schemaList ),
          esc_url( get_year_link( get_query_var( 'year' ) ) ),
          esc_html( get_query_var( 'year' ).'年' )
        );
        $str .= sprintf(
          '<li %1$s itemscope itemtype="%2$s"><a itemprop="url" href="%3$s"><span itemprop="name">%4$s</span></a></li>',
          $liAttribute,
          esc_url( $schemaList ),
          esc_url( get_year_link( get_query_var( 'monthnum' ) ) ),
          esc_html( get_query_var( 'monthnum' ).'月' )
        );
        $str .= sprintf(
          '<li %1$s itemscope itemtype="%2$s"><span %3$s itemprop="name">%4$s</span></li>',
          $liAttribute,
          esc_url( $schemaList ),
          $currentOption,
          esc_html( get_query_var( 'day' ).'日' )
        );
      }
      elseif(is_month() !=0) {
        // 月を出力
        $str .= sprintf(
          '<li %1$s itemscope itemtype="%2$s"><a itemprop="url" href="%3$s"><span itemprop="name">%4$s</span></a></li>',
          $liAttribute,
          esc_url( $schemaList ),
          esc_url( get_year_link( get_query_var( 'year' ) ) ),
          esc_html( get_query_var( 'year' ).'年' )
        );
        $str .= sprintf(
          '<li %1$s itemscope itemtype="%2$s"><span %3$s itemprop="name">%4$s</span></li>',
          $liAttribute,
          esc_url( $schemaList ),
          $currentOption,
          esc_html( get_query_var( 'monthnum' ).'月' )
        );
      }
      elseif(is_year() !=0) {
        // 年を出力
        $str .= sprintf(
          '<li %1$s itemscope itemtype="%2$s"><span %3$s itemprop="name">%4$s</span></li>',
          $liAttribute,
          esc_url( $schemaList ),
          $currentOption,
          esc_html( get_query_var( 'year' ).'年' )
        );
      }
    }

    $str .= '</ul>';
    $str .= '</nav>';
    $str .= '</div>';
    $str .= '</div>';
  }
  echo $str;
  wp_reset_postdata();
}

// 最下層のカテゴリーを返す関数
// https://increment-log.com/wordpress-breadcrumb/
function get_youngest_cat($categories){
    global $post;
    if(count($categories) == 1 ){
        $youngest = $categories[0];
    }
    else{
        $count = 0;
        foreach($categories as $category){  //それぞれのカテゴリーについて調査
            $children = get_term_children( $category -> term_id, 'category' );  //子カテゴリーの ID を取得
            if($children){  //子カテゴリー（の ID ）が存在すれば
                if ( $count < count($children) ){  //子カテゴリーの数が多いほど、そのカテゴリーは階層が下なのでそれを元に調査するかを判定
                    $count = count($children);  //$count に子カテゴリーの数を代入
                    $lot_children = $children;
                    foreach($lot_children as $child){  //それぞれの「子カテゴリー」について調査 $childは子カテゴリーのID
                        if( in_category( $child, $post -> ID ) ){  //現在の投稿が「子カテゴリー」のカテゴリーに属するか
                            $youngest = get_category($child);  //属していればその「子カテゴリー」が一番若い（一番下の階層）
                        }
                    }
                }
            }
            else{  //子カテゴリーが存在しなければ
                $youngest = $category;  //そのカテゴリーが一番若い（一番下の階層）
            }
        }
    }
    return $youngest;
}

// 最下層のタクソノミーを返す
function get_youngest_tax($taxes, $mytaxonomy){
    global $post;
    if(count($taxes) == 1 ){
        $youngest = $taxes[key($taxes)];
    }
    else{
        $count = 0;
        foreach($taxes as $tax){  //それぞれのタクソノミーについて調査
            $children = get_term_children( $tax -> term_id, $mytaxonomy );  //子タクソノミーの ID を取得
            if($children){  //子カテゴリー（の ID ）が存在すれば
                if ( $count < count($children) ){  //子タクソノミーの数が多いほど、そのタクソノミーは階層が下なのでそれを元に調査するかを判定
                    $count = count($children);  //$count に子タクソノミーの数を代入
                    $lot_children = $children;
                    foreach($lot_children as $child){  //それぞれの「子タクソノミー」について調査 $childは子タクソノミーのID
                        if( is_object_in_term( $post -> ID, $mytaxonomy ) ){  //現在の投稿が「子タクソノミー」のタクソノミーに属するか
                            $youngest = get_term($child, $mytaxonomy);  //属していればその「子タクソノミー」が一番若い（一番下の階層）
                        }
                    }
                }
            }
            else{  //子タクソノミーが存在しなければ
                $youngest = $tax;  //そのタクソノミーが一番若い（一番下の階層）
            }
        }
    }
    return $youngest;
}
