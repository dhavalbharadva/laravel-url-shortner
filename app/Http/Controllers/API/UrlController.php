<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Url as Url;
use App\Http\Controllers\ApiController;
use Validator;

class UrlController extends ApiController {


    public function __construct() {
    }

    public function index(Request $request) {
        $rules = array(
            'destination' => 'required|url'
        );

        $data = $request->all();

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return $this->respondValidationError($validator->errors()->all());
        }
        
        $destination = $data['destination'];

        $urls = Url::select('id','destination_url','url_key','default_short_url','created_at','updated_at')->where('destination_url',$destination)->first();
        if ($urls) {
            return $this->respond($urls);
        } else {
            return $this->respondWithError(['Url Not Found']);
        }
    }

}
