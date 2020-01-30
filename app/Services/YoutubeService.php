<?php namespace App\Services;


class YoutubeService {

    /**
     * @var array
     */
    protected $pageInfo;


    protected $url = "https://www.googleapis.com/youtube/v3";


    /**
     * Gets the key from the environment or throws an error
     * @return mixed
     * @throws \Exception
     */
    private function getKey()
    {
        $key = env('YOUTUBE_KEY');

        if (is_string($key) && !empty($key))
        {
            return $key;
        }

        // if no key found
        throw new \Exception('Google API key is Required, please visit https://console.developers.google.com/');
    }

    /**
     * @param $searchTerm
     * @return bool
     * @throws \Exception
     */
    public function search($searchTerm)
    {

        // Set default parameters
        $params = [
            'q'              => $searchTerm,
            'type'           => 'video',
            'part'           => 'id, snippet',
            'maxResults'     => 10,
            'location'       => '53.723379, -6.325879', // keep the result based on Drogheda the mill
            'locationRadius' => '100km'
        ];

        return $this->processResults(
            $this->getRequest('/search', $params)
        );
    }


    /**
     * Send a GET request to youtube
     *
     * @param $url
     * @param $params
     * @return mixed
     * @throws \Exception
     */
    public function getRequest($url, $params)
    {
        //set the youtube key
        $params['key'] = $this->getKey();

        //Build url
        $url = $this->url . $url;

        $youtubeCurl = curl_init();
        curl_setopt($youtubeCurl, CURLOPT_URL, $url . (strpos($url, '?') === false ? '?' : '') . http_build_query($params));
        if (strpos($url, 'https') === false)
        {
            curl_setopt($youtubeCurl, CURLOPT_PORT, 80);
        } else
        {
            curl_setopt($youtubeCurl, CURLOPT_PORT, 443);
        }

        curl_setopt($youtubeCurl, CURLOPT_RETURNTRANSFER, 1);

        $responseData = curl_exec($youtubeCurl);

        if (curl_errno($youtubeCurl))
        {
            throw new \Exception('Request Error : ' . curl_error($youtubeCurl));
        }

        return $responseData;
    }

    /**
     * Creates an object for the results back
     *
     * @param $requestResults
     * @return bool
     * @throws \Exception
     */
    private function processResults($requestResults)
    {
        $requestResult = json_decode($requestResults);

        if (isset($requestResult->error))
        {
            $msg = "Error " . $requestResult->error->code . " " . $requestResult->error->message;

            if (isset($requestResult->error->errors[0]))
            {
                $msg .= " : " . $requestResult->error->errors[0]->reason;
            }
            throw new \Exception($msg);
        } else
        {
            $this->pageInfo = [
                'resultsPerPage' => $requestResult->pageInfo->resultsPerPage,
                'totalResults'   => $requestResult->pageInfo->totalResults,
                'kind'           => $requestResult->kind,
                'etag'           => $requestResult->etag,
                'prevPageToken'  => null,
                'nextPageToken'  => null,
            ];

            if (isset($requestResult->prevPageToken))
            {
                $this->pageInfo['prevPageToken'] = $requestResult->prevPageToken;
            }

            if (isset($requestResult->nextPageToken))
            {
                $this->pageInfo['nextPageToken'] = $requestResult->nextPageToken;
            }

            $itemsArray = $requestResult->items;

            if (!is_array($itemsArray) || count($itemsArray) == 0)
            {
                return false;
            }

            return $itemsArray;
        }

    }



}
