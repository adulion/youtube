<?php namespace App\Services;

use Alaouy\Youtube\Facades\Youtube;
use Google_Client;
use Google_Service_YouTube;

class YoutubeService {

    public function search($searchTerm)
    {

        $this->buildClient();


        // Set default parameters
        $params = [
            'q'          => $searchTerm,
            'type'       => 'video',
            'part'       => 'id, snippet',
            'maxResults' => 10,
            'location'   => '53.723379, -6.325879', // keep the result based on Drogheda the mill
            'locationRadius' => '100km'
        ];

        // Make intial call. with second argument to reveal page info such as page tokens
        $search = Youtube::searchAdvanced($params, true);

        // Add results key with info parameter set
        return $search['results'];
    }

    private function buildClient()
    {
        Youtube::setApiKey(env('YOUTUBE_KEY'));
    }


}
