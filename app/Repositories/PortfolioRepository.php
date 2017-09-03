<?php

namespace App\Repositories;

use App\Portfolio;

class PortfolioRepository
{

    protected $portfolio;

    /**
     * Handles the create new user validation rules.
     * @var array
     */
    public $create_rules = [
        'title' => 'required',
        'description' => 'required',
        //'url' => 'required',
        'category' => 'required'
    ];


    public function __construct(Portfolio $portfolio){
        $this->portfolio = $portfolio;
    }

    /**
     * Handles getting all portfolio pics
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->portfolio->all();
    }


    /**
     * Handles creating new portfolio image
     *
     * @param array $data
     * @return Portfolio
     */
    public function create(array $data)
    {
        $this->portfolio = new Portfolio();
        $this->portfolio->forceFill([
            'title' => $data['title'],
            'description' => $data['description'],
            'url' => $data['url'],
            'category' => $data['category']
        ]);

        $this->portfolio->save();
        return $this->portfolio;
    }

    /**
     * Handles Deleting Portfolio Image
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $portfolioImg = $this->portfolio->where('id', $id)->first();
        if(!$portfolioImg){
            return false;
        }
        $portfolioImg->delete();
        return true;
    }

}
