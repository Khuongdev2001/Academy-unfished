<?php

// require "../PiFirstProject/vendor/autoload.php";
// // Authenticate in production environment
// $client = ApiVideo\Client\Client::create('yourProductionApiKey');


// // Alternatively, authenticate in sandbox environment for testing
// $client = ApiVideo\Client\Client::createSandbox('yourSandboxApiKey');

// // Create and upload a video resource from local drive
// $video = $client->videos->upload(
//     '/path/to/video.mp4', 
//     array('title' => 'Course #4 - Part B')
// );

// // Display embed code
// echo $video->assets['iframe'];
// // <iframe src="https://embed.api.video/vod/viXXX" width="100%" height="100%" frameborder="0" scrolling="no" allowfullscreen=""></iframe>