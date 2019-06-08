<?php
$args = [ 'post_type' => ['news','events'],//投稿postとカスタム投稿タイプevents
          'order' => 'DESC',
          'orderby' => 'date',
          'posts_per_page' => 10,
        ];
$swiper_args = [ 'post_type' => ['news','events'],//投稿postとカスタム投稿タイプevents
          'order' => 'DESC',
          'orderby' => 'date',
          'posts_per_page' => 6,
          'meta_key' => 'サムネイルスワイパー掲載最終日',
      'meta_query' => [
        'key' => 'サムネイルスワイパー掲載最終日',
        'value' => date('Y/m/d', strtotime('now')),
        'compare' => '<='
      ]
//           'meta_value' => date('Y/m/d'),
//           'meta_compare' => '<=',
        ];
$events_news_query = new WP_Query($args);
$swiper_query = new WP_Query($swiper_args);
// echo '<pre>';
// var_dump($events_news_query);
// echo '</pre>';
?>
<div class="news-part container-fluid">
  <div class="row swiper-container">
    <ul class="swiper-wrapper mx-0 px-0">
<?php
if ($swiper_query->have_posts()): while($swiper_query->have_posts()):$swiper_query->the_post(); if (has_post_thumbnail()):
?>
        <li class="position-relative swiper-slide thumbnail_list">
          <?php the_post_thumbnail(); ?>
          <a class="hover_modal position-absolute py-5 nounderline overflow-auto" href="<?= get_permalink(); ?>">
            <h3 class="h5 mb-5 px-5 py-2"><?php the_title();?></h3>
            <span class="h6 small px-5 d-block"><?php the_excerpt(); ?></span>
          </a>
        </li>
<?php
endif;endwhile;endif;
?>
    </ul>
    <div class="swiper-pagination"></div>
    <div class="position-absolute d-none d-md-block offset-md-8 col-md-4"></div>
  </div>
  <div class="row text-center">
    <div class="col-md-8 py-5 px-md-5">
      <h2 class="border-bottom border-dark offset-md-3 col-md-6">NEWS</h2>
      <span>おしらせ</span>
      <ul class="mx-auto mt-3 bg-light rounded p-1 p-md-5 overflow-auto">
      <?php if($events_news_query->have_posts()):?>
      <?php
      $event = 0;
      while ($events_news_query->have_posts()):
        $events_news_query->the_post();
      ?>
        <li class="text-left mb-3 pb-3">
          <h3 class="title_trans text-left font-weight-bold">
            <a href="<?= $events_news_query->posts[$event]->guid; ?>"><?php the_title(); ?></a>
          </h3>
          <span class="small text-secondary"><?php the_time('Y年n月j日'); ?></span>
          <?php
          $time = 1;
          $now = date_i18n('U');
          $entry = get_the_time('U');
          $term = date('U', ($now - $entry))/2592000;//1ヶ月(30日)(2592000秒)
          if ($time > $term): ?>
          <span class="text-light ml-3 p-1 bg-danger rounded small">new</span>
          <?php endif; ?>
        </li>
      <?php $event++; ?>
      <?php endwhile; ?>
      <?php else: ?>
        <li><h3 class="text-left">Newsはありません</h3></li>
      <?php endif; ?>
      </ul>
      <div class="text-center mb-1 pb-1"><a href="<?= get_post_type_archive_link('news')?get_post_type_archive_link('news'):'#'; ?>">過去の記事一覧</a></div>
    </div>
    <?php get_sidebar('cancel'); ?>
  </div>
</div>