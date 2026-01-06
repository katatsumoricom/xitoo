<?php
// microcms データ取得
function IndexNewsInclude()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://idonokawazu.microcms.io/api/v1/news');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $headers[] = 'X-MICROCMS-API-KEY: SZiKAu9IHpAf07qjPmFAdSCghWxjsEiVYc2P';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    // 取得したら表示
    $result = json_decode($response, true);
    foreach ($result['contents'] as $key => $contents) {
        $banner = array_key_exists('banner', $contents) ? $contents['banner'] : null;
        $newsTitle = array_key_exists('newsTitle', $contents) ? $contents['newsTitle'] : null;
        $text = array_key_exists('text', $contents) ? $contents['text'] : null;
        $url = array_key_exists('url', $contents) ? $contents['url'] : null;
        $linkTitle = array_key_exists('linkTitle', $contents) ? $contents['linkTitle'] : null;

        if (!empty($newsTitle)) {
            if ($key <= 2) {
                echo '<div class="c-grid__card">';
                echo '<h4>' . $newsTitle . '</h4>';
                echo $text;
                echo '<a href="' . $url . '" class="c-link" target="_blank">' . $linkTitle . '</a>';
                echo '</div>';
            }
        }
    }
}

function IndexDiscographyInclude()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://idonokawazu.microcms.io/api/v1/discography');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $headers[] = 'X-MICROCMS-API-KEY: SZiKAu9IHpAf07qjPmFAdSCghWxjsEiVYc2P';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    // 取得したら表示
    $result = json_decode($response, true);
    foreach ($result['contents'] as $key => $contents) {
        if (isset($contents) == true) {
            $format = array_key_exists('format', $contents) ? $contents['format'] : null;
            $release = array_key_exists('release', $contents) ? $contents['release'] : null;
            $discoTitle = array_key_exists('discoTitle', $contents) ? $contents['discoTitle'] : null;
            $image = array_key_exists('image', $contents) ? $contents['image']['url'] : null;
            $url = array_key_exists('url', $contents) ? $contents['url'] : null;
            $track = array_key_exists('track', $contents) ? $contents['track'] : null;
            $spotify = array_key_exists('spotify', $contents) ? $contents['spotify'] : null;

            if ($key <= 2) {
                echo '<div class="p-discography__content">';
                echo '<h3>' . $release . ' 発売</h3>';
                echo '<div class="p-discography__content-inner">';
                echo '<h4>' . $discoTitle . '</h4>';
                echo '<a href="' . $url . '" target="_blank"><img src="' . $image . '" alt="' . $discoTitle . '"></a>';
                echo $track;
                echo '<div class="spotify">';
                echo '<iframe style="border-radius:12px" src="' . $spotify . '?utm_source=generator&theme=0" width="100%" height="100%" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "データがありません";
        }
    }
}

function IndexWorksInclude()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://idonokawazu.microcms.io/api/v1/works');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $headers[] = 'X-MICROCMS-API-KEY: SZiKAu9IHpAf07qjPmFAdSCghWxjsEiVYc2P';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    // 取得したら表示
    $result = json_decode($response, true);
    foreach ($result['contents'] as $key => $contents) {
        $title = array_key_exists('title', $contents) ? $contents['title'] : null;
        $url = array_key_exists('url', $contents) ? $contents['url'] : null;
        $urlTitle = array_key_exists('urlTitle', $contents) ? $contents['urlTitle'] : null;
        $part = array_key_exists('part', $contents) ? $contents['part'] : null;


        if ($key <= 5) {
            echo '<li>';
            if (!empty($url)) {
                echo '<a href="' . $url . '" class="c-link" target="_blank">' . $title . '/ ' . $part . ' <span>';
                if (!empty($urlTitle)) {
                    echo $urlTitle;
                } else {
                    echo 'YouTube';
                }
                echo ' <i class="fas fa-angle-right"></i></span></a>';
            } else {
                echo $title . '/ ' . $part;
            }

            echo '</li>';
        }
    }
}
