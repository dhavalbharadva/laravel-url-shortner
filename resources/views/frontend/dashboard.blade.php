@extends('frontend.layouts.default')

@section('content')
<section class="page-content">
    <div class="container">
        <div class="heading">
            <div class="content">
                <h1 class="page-title">Welcome {!! auth()->user()->name; !!}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 offset-md-2 col-xs-12">
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="col-lg-8 col-md-8 col-sm-8 offset-md-2 col-xs-12">
                            @include('frontend.includes.notifications')
                            {!! Form::open(['route' => 'dashboard.store', 'id' => 'url-form', 'class' => 'form']) !!}
                            <div class="form-group">
                                <div class="form-icon">
                                    {!! Form::text('destination', old('destination'),array('class'=>'form-control', 'placeholder'=>'http://example.com')) !!}
                                    <span class="text-muted">Enter the url you want to shorten</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary float-right" id="url-form-submit">Shorten Url</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-8 col-md-8 col-sm-8 offset-md-2 col-xs-12">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <table class="table">
                            <thead>
                              <tr>
                                <th>SHORTENED URL</th>
                                <th>URL</th>
                                <th>CREATED AT</th>
                              </tr>
                            </thead>
                            <tbody>
                                @if(count($urls))
                                @foreach ($urls as $data)
                                    <tr>
                                        <td><a href="{!! route('shorten.url', $data->url_key) !!}" target="_blank">{!! $data->default_short_url !!}</a></td>
                                        <td>{!! $data->destination_url !!}</td>
                                        <td>{!! date('m/d/Y h:i:s A',strtotime($data->created_at)) !!}</td>
                                  </tr>
                                @endforeach
                                @else
                                    <tr>
                                    <td colspan="3" class="text-center">No records available</td>
                                  </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop