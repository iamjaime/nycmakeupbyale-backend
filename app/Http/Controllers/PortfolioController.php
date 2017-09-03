<?php

namespace App\Http\Controllers;

use App\Repositories\PortfolioRepository as Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage as S3;
use Illuminate\Http\UploadedFile;

class PortfolioController extends Controller
{
    protected $portfolio;
    protected $storage;
    protected $storage_folder = 'nycmakeupbyale';

    public function __construct(Portfolio $portfolio, S3 $storage)
    {
        $this->portfolio = $portfolio;
        $this->storage_folder = env('AWS_BUCKET', 'nycmakeupbyale');
        $this->storage = $storage;
    }

    /**
     * Handles getting all portfolio images
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $portfolio = $this->portfolio->all();

        return response()->json([
            'success' => true,
            'data' => $portfolio
        ], 200);
    }


    /**
     * Handles uploading the portfolio pic.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function portfolioPic(Request $request)
    {
        $data = $request->get('data');

        if(!$request->hasFile('data.image')){
            return response()->json([
                'success' => false,
                'error' => ['image' => ['The data[image] field is required.']]
            ], 400);
        }

        //validate....
        $rules = $this->portfolio->create_rules;
        $validator = $this->validate($request, $rules);

        if(!empty($validator)){
            return response()->json([
                'success' => false,
                'data' => $validator
            ], 400);
        }

        $portfolio_pic = $this->uploadFile($request->file('data.image'), 'portfolio');
        $data['url'] = $portfolio_pic;
        $portfolio = $this->portfolio->create($data);

        return response()->json([
            'success' => true,
            'data' => $portfolio
        ], 200);
    }
}
