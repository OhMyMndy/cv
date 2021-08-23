<?php

require __DIR__ . '/../vendor/autoload.php';
chdir(__DIR__);

$fileName = __DIR__ . '/content.txt';

if (!file_exists($fileName)) {
    $content = file_get_contents("https://stackoverflow.com/story/ohmymndy");
    file_put_contents($fileName, $content);
} else {
    $content = file_get_contents($fileName);
}

use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\AbstractNode;

$dom = new Dom();
$dom->load($content);

$result = [];

$result['about-me'] = $dom->find('.description-content-full')->innerhtml;


// Jobs
$result['timeline'] = [];

$items = $dom->find('.timeline-item');
/** @var AbstractNode $item */
foreach ($items as $item) {
    if (strpos($item->getAttribute('class'), 'job') === false) {
        continue;
    }
    $title = $item->find('.timeline-item-title')->innerhtml;
    $date = $item->find('.timeline-item-date')->innerhtml;

    $timelineTags = [];
    $tags = $item->find('.timeline-item-tags .s-tag');
    foreach ($tags as $tag) {
        $timelineTags[] = $tag->innerhtml;
    }

    $description = $item->find('.description-content-full')->innerhtml;


    $result['timeline'][] = [
        'title' => $title,
        'date' => $date,
        'tags' => $timelineTags,
        'description' => $description
    ];
}


// Education
$result['education'] = [];
/** @var AbstractNode $item */
foreach ($items as $item) {
    if (strpos($item->getAttribute('class'), 'education') === false) {
        continue;
    }
    $title = $item->find('.timeline-item-title')->innerhtml;
    $date = $item->find('.timeline-item-date')->innerhtml;

    $resultTags = [];
    $tags = $item->find('.timeline-item-tags .post-tag');
    foreach ($tags as $tag) {
        $resultTags[] = $tag->innerhtml;
    }

    $description = $item->find('.description-content-full')->innerhtml;


    $result['education'][] = [
        'title' => $title,
        'date' => $date,
        'tags' => $resultTags,
        'description' => $description
    ];
}


$result['generic'] = [];
/** @var AbstractNode $item */
foreach ($items as $item) {
    if (strpos($item->getAttribute('class'), 'generic') === false) {
        continue;
    }
    $title = trim($item->find('.timeline-item-title')->innerhtml);
    $description = $item->find('.description-content-full')->innerhtml;

    $result['generic'][] = [
        'title' => $title,
        'description' => $description
    ];
}



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

$template = $twig->load('template.html.twig');
$content = $template->render([
    'profilePicture' => 'https://i.stack.imgur.com/S9C4n.jpg?s=136&g=1',
    'name' => "Mandy Schoep",
    'title' => 'Software Engineer',
    'subtitle' => 'Bachelor of Information and Communication Technology (2013)',
    'personalInfo' => '14-07-1991 &#8226; Retie, BE &#8226; mandyschoep@gmail.com',
    'socials' => '<li><span class="fa fa-github"></span> <a href="https://github.com/OhMyMndy" target="_blank">github.com/OhMyMndy</a></li>
    <li><span class="fa fa-stack-overflow"></span> <a href="https://stackoverflow.com/story/ohmymndy" target="_blank">stackoverflow.com/story/ohmymndy</a></li>
    <li><span class="fa fa-linkedin"></span> <a href="https://www.linkedin.com/in/mandy-schoep/" target="_blank">linkedin.com/in/mandy-schoep</a></li>',
    'data' => $result
]);


if (php_sapi_name() == 'cli') {
    return $content;
} else {
    echo $content;
}
