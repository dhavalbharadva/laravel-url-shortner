<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Url as Url;
use Validator;
use Illuminate\Support\Str;
use AshAllenDesign\ShortURL\Classes\Builder;

class DashboardController extends Controller {
    
    protected $auth;
    
    public function __construct() {
        $this->auth = auth()->guard('user');
    }

    public function index() {
        //$userId  = $this->auth->user()->id;
        $urls = Url::all();
        return view('frontend.dashboard',compact('urls'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $rules = array(
            'destination' => 'required|url'
        );
        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['slug'] = Str::random(5);
        $builder = new Builder();

        $shortURLObject = $builder->destinationUrl($data['destination'])->urlKey($data['slug'])->make();
        $data['shortened_url'] = $shortURLObject->default_short_url;

        //Url::create($data);

        return redirect('dashboard')->with('success_message', "Your shorten URL created successfully!");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shortenUrl($slug)
    {
        /*$find = Url::where('slug', $slug)->first();
        if($find){
            return redirect($find->destination);
        }else{
            return abort(404);
        }*/

        $find = Url::where('url_key', $slug)->first();
        if($find){
            return redirect($find->destination_url);
        }else{
            return abort(404);
        }
        
    }
}
