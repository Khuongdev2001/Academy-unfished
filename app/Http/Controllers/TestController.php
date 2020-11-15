<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  ApiVideo\Client\Client;

class TestController extends Controller
{
    //
    function index()

    {

        // Authenticate in production environment
        $client = Client::create('DqWBOl92Ksoo30WRhzaJ8IWzLgq2CiMgBkcnExN6llq');


        // Alternatively, authenticate in sandbox environment for testing
        $client = Client::createSandbox('DqWBOl92Ksoo30WRhzaJ8IWzLgq2CiMgBkcnExN6llq');

        // Create and upload a video resource from local drive
        $video = $client->videos->upload(
            'public/test.mp4',
            array('title' => 'Course #4 - Part B')
        );

        // Display embed code

        echo $video->assets['iframe'];

        return "ok";
    
    }
}
