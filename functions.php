<?php

add_theme_support( 'post-thumbnails' );
/*
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
ニュース
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/
//カスタム投稿タイプ(ニュース)
  add_action( 'init', 'create_news' );
  function create_news() {
    $Supports = [
      'title',//名前
      'thumbnail',
      //'custom-fields',
      'editor'//本文
    ];
    register_post_type( 'news',
      array(
        'labels' => array(
          'name' => __( 'ニュース' ),
          'singular_name' => __( 'News' )
        ),
        'public' => true,
        'has_archive' => true,
        'menu_position' => 5,
        'supports' => $Supports
      )
    );
  }
  //カスタムフィールド追加
  add_action('admin_menu','add_news_fields');
  function add_news_fields(){
    add_meta_box('custom-news-class_room', '教室', 'create_news_class_room', 'news', 'normal');
    add_meta_box('custom-news-end-date', 'サムネイルスワイパー掲載最終日', 'create_news_end_date', 'news', 'normal');
  }
  function create_news_class_room() {
    $keyname = '教室';
    global $post;
    $get_value = get_post_meta($post->ID, $keyname, true);
    $data = [ '全体','神戸','伊丹'];
    wp_nonce_field('action-' . $keyname, 'nonce-' . $keyname);
    echo '<select name="'.$keyname.'">';
    echo '<option value="">-----</option>';
    foreach ($data as $d) {
      $selected = '';
      if ($d === $get_value) {
        $selected = 'selected';
      }
      echo '<option value="'.$d.'"'.$selected.'>'.$d.'</option>';
    }
    echo '</select>';
  }
  function create_news_end_date() {
    $keyname = 'サムネイルスワイパー掲載最終日';
    global $post;
    $get_value = get_post_meta($post->ID, $keyname, true);
    wp_nonce_field('action-' . $keyname, 'nonce-' . $keyname);
    // echo '<input type="date" min="'.date("Y-m-d").'" name="'.$keyname.'"value="'.$get_value.'"autocomplete="off">';
    echo '<input type="date" name="'.$keyname.'"value="'.$get_value.'"autocomplete="off">';
  }
  add_action('save_post', 'save_new_fields');
  function save_new_fields($post_id){
    $new_fields = ['教室','サムネイルスワイパー掲載最終日'];
    foreach ($new_fields as $d) {
      if (isset($_POST['nonce-'.$d])&&$_POST['nonce-'.$d]) {
        if (check_admin_referer('action-'.$d, 'nonce-'.$d)) {
          if (isset($_POST[$d])&&$_POST[$d]) {
            update_post_meta($post_id,$d,$_POST[$d]);
          }else{
            delete_post_meta($post_id,$d,get_post_meta($post_id,$d,true));
          }
        }
      }
    }
  }

/*
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
js読み込み
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/
add_action('wp_enqueue_scripts', function(){
  wp_enqueue_script('swiper','https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.6/js/swiper.min.js',array(),'4.4.6',true);
  wp_enqueue_script('top_swiper',get_template_directory_uri().'/js/top_swiper.js',array('swiper'),false,true);
  wp_enqueue_script('sp_menus', get_template_directory_uri().'/js/sp_menus.js',array(),false,true);
  wp_enqueue_script('book_modal', get_template_directory_uri().'/js/book_modal.js',array(),false,true);
  wp_enqueue_script('sche_accordion', get_template_directory_uri().'/js/sche_accordion.js',array(),false,true);
  wp_enqueue_script('sche_letter_adjust', get_template_directory_uri().'/js/sche_letter_adjust.js',array(),false,true);
  //wp_enqueue_script('feature_letter_adjust', get_template_directory_uri().'/js/feature_letter_adjust.js',array(),false,true);
  //wp_enqueue_script('sp_top_height_adjust', get_template_directory_uri().'/js/sp_top_height_adjust.js',array(),false,true);
});
