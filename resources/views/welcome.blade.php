<!DOCTYPE html>
<html>
    <head>
        <title>Up Tilt's Image Upload</title>
        <link href="resources/assets/css/app.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <meta name="_token" content="{!! csrf_token() !!}"/>
    </head>
    <body>
        <header>
            <h1>Just a simple image upload application.</h1>
        </header>
        <div class="main-wrap">
            @if(Session::has('global-message'))
                <div class="{{ session('message-type') }}">
                    <p>{{ session('global-message') }}</p>
                </div>
            @endif
            <div class="upload-container">
                <div class="upload-wrap">
                    <button class="button-primary button-photo"><i class="fa fa-cloud-upload fa-lg"></i> Upload an image!</button>
                    @if(Session::has('errors'))
                        <div class="form-errors">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                        </div>
                    @endif
                    <div {!! Session:: has('errors') ? 'class="form-wrap"' : 'class="form-wrap" style="display: none;"' !!}> <!-- I hate that I had to put an inline style here /cry -->
                        {!! Form::open(['id' => 'upload-form', 'route' => 'photo.store', 'method' => 'post', 'files' => true]) !!}
                            <div class="input-field">
                                <input id="input-file" type="file" name="photo" autocomplete="off" class="photo-input">
                                <label for="input-file" class="button-primary button-file-select"><i class="fa fa-camera fa-lg"></i> Choose an image</label>
                            </div>
                            <hr>
                            <button class="button-primary button-submit" type="submit" value="Submit"><i class="fa fa-upload fa-lg"></i> Submit</button>
                        {!! Form::close() !!}
                    </div>{{-- upload-form --}}
                </div>{{-- upload-wrap --}}
            </div>

            <div class="photo-container">
            <div class="photo-wrap">
                <h1>Uploads</h1>
                <div class="pagination-wrap">
                    {!! $images->render() !!}
                </div>
                <hr>
                <div class="photo-gallery">
                    @foreach($images as $image)
                        <div class="flex-image">
                            <a href="{!! route('photo.serve', $image->slug) !!}">
                                {!! Html::image($image->thumb_path) !!}
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="pagination-wrap">
                    {!! $images->render() !!}
                </div>
            </div>{{-- photo-wrap --}}
            </div> {{-- photo-container --}}
        </div>{{-- main-wrap --}}

        <!-- Scripts -->
        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });
        </script>
        {!! Html::script("resources/assets/js/buttonplate.js") !!}
        {!! Html::script("resources/assets/js/app.js") !!}

    </body>
</html>
