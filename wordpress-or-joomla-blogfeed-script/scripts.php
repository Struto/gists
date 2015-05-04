<?php

// Set header to HTML / UTF-8
header('Content-Type: text/html; charset=utf-8');

global $text, $maxchar, $end;
$first_img = '';

$rss = new DOMDocument();
$rss->load('http://resources.conceptintegratedsystems.co.uk/blog/rss.xml'); // <-- Blog XML url
$feed = array();
foreach ($rss->getElementsByTagName('item') as $node) {
    $item = array (
        'title'         => $node->getElementsByTagName('title')->item(0)->nodeValue,
        'link'          => $node->getElementsByTagName('link')->item(0)->nodeValue,
        'date'          => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
        'content'	=> $node->getElementsByTagName('encoded')->item(0)->nodeValue,
        'creator'	=> $node->getElementsByTagName('creator')->item(0)->nodeValue,
        'the_excerpt'   => $node->getElementsByTagName('description')->item(0)->nodeValue,
    );
    array_push($feed, $item);
}

$limit = 5; // <-- Change the number of posts shown

for ($x=0; $x<$limit; $x++) {
    $title          = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
    $link           = $feed[$x]['link'];
    $description    = $feed[$x]['description'];
    $content        = $feed[$x]['content'];
    $description    = substr($description, 0, 100);
    $pubDate        = date('D, M d, Y' . ' @ ' . 'H:i A', strtotime($feed[$x]['date']));
    $creator        = $feed[$x]['creator'];
    $the_excerpt    = $feed[$x]['the_excerpt'];
    $the_excerpt    = strip_tags($the_excerpt);
    $short_excerpt  = substr($the_excerpt, 0, strrpos(substr($the_excerpt, 0, 200), ' '));

    preg_match_all('/src=([\'"])?(.*?)\\1/', $content, $matches);
    $first_img   = $matches[0][0];



    echo '  <div class="blog-list post'.$x.'">
                <a href=" '.$link.' " title=" '.$title.' ">
                    <img '.$first_img.'/>
                </a>
                <div class="detail'.$x.'">
                    <p class="blog-header">
                        <strong>
                            <a href=" '.$link.' " title=" '.$title.' ">'.$title.'</a>
                        </strong>
                    </p>
                    <p class="author-details">Posted by '.$creator.' on '.$pubDate.'</p>
                    <p class="blog-summart">'.$short_excerpt.'... </p>
                    <a class="blog-readmore" href=" '.$link.' ">Read More</a>
                </div>
            </div>';


}


    // All blogs
    echo '  <div class="all-blogs">
                <a href="http://resources.conceptintegratedsystems.co.uk/blog" target="_blank">All Blogs$
            </div>';

