<?php namespace App\Http\Controllers;


use App\Services\YoutubeService;

class MainController extends Controller {

    /**
     * @var YoutubeService
     */
    private $youtubeService;


    /**
     * MainController constructor.
     */
    public function __construct(YoutubeService $youtubeService)
    {
        $this->youtubeService = $youtubeService;
    }

    public function getIndex()
    {
        return View('index');

    }

}
