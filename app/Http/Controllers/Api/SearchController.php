<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\YoutubeResource;
use App\Services\YoutubeService;

class SearchController extends Controller {

    /**
     * @var YoutubeService
     */
    private $youtubeService;


    /**
     * SearchController constructor.
     * @param YoutubeService $youtubeService
     */
    public function __construct(YoutubeService $youtubeService)
    {
        $this->youtubeService = $youtubeService;
    }

    public function search()
    {
        try{
            $result = $this->youtubeService->search(Request()->input('search_term'));

            return YoutubeResource::collection(collect($result));

        } catch(\Exception $e){
            return Response()->json(
                [
                    'error' =>true,
                    'message' => $e->getMessage()
                ],429
            );

        }



    }



}
