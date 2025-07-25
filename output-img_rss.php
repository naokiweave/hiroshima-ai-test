<?php
date_default_timezone_set('Asia/Tokyo');

// $url = "https://note.com/hiroshima_sb/m/m5b0f5cc2b371/rss"; // RSSフィードのURLをここに設定
$url = "https://note.com/hiroshima_aiclub/rss";
$max = 3;

if ($rss = simplexml_load_file($url)) {
    $cnt = 0;
    $output = '';

    foreach ($rss->channel->item as $item) {
        if ($cnt >= $max) break;

        // 名前空間を取得し、メディア情報を取得
        $namespaces = $item->getNameSpaces(true);
        $media = $item->children($namespaces['media']);

        $imageUrl = $item->children('media',true)->thumbnail;

        // $description = strip_tags($item->description);
        // if (mb_strlen($description) > 80) {
        //     $description = mb_substr($description, 0, 80) . '...';
        // }

        $date = date('Y.m.d', strtotime($item->pubDate));
        
        $output .= '<div class="swiper-slide"><a href="'. $item->link .'" target="_blank" rel="noopener"><div class="img"><img src="' . $imageUrl . '" alt="Thumbnail"></div><div class="text"><time datetime="' . date('c', strtotime($item->pubDate)) . '">' . $date . '</time><h3>' . $item->title . '</h3></div></a></div>';
        $cnt++;
    }
    echo $output;
}
?>