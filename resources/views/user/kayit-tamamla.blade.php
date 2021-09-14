
<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="row">
    <div class="col-md-8">
        <div class="container">
            <form class="form-horizontal" method="post"  enctype="multipart/form-data" action="{{route('aktif-tamamla',$user->activate_code)}}">
                @csrf
                <h2>Kayıt Tamamlama</h2>
                <div class="form-group">
                    <label for="ad" class="col-sm-3 control-label">Sayın {{$user->name}}</label>
                </div>
                <div class="form-group">
                    <label for="birthDate" class="col-sm-3 control-label">Date of Birth*</label>
                    <div class="col-sm-9">
                        <input type="date" id="birthDate" name="birthday" class="form-control @error('birthday') is-invalid @enderror" class="form-control">
                        @error('birthday')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="phoneNumber" class="col-sm-3 control-label">Phone number </label>
                    <div class="col-sm-9">
                        <input type="phoneNumber" id="phoneNumber" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="Phone number" class="form-control">
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        <span class="help-block">Your phone number won't be disclosed anywhere </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Height" class="col-sm-3 control-label">Height* </label>
                    <div class="col-sm-9">
                        <input type="number" name="height" class="form-control @error('height') is-invalid @enderror" id="height" placeholder="Please write your height in centimetres" class="form-control">
                        @error('height')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="weight" class="col-sm-3 control-label">Weight* </label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" placeholder="Please write your weight in kilograms" class="form-control">
                        @error('weight')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="weight" class="col-sm-3 control-label">Adres* </label>
                    <div class="col-sm-9">
                        <textarea class="form-control" class="form-control @error('adres') is-invalid @enderror" aria-label="With textarea" name="adres" placeholder="adresiniz"></textarea>
                        @error('adres')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="weight" class="col-sm-3 control-label">Chose Your Image* </label>
                    <div class="col-sm-9">
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Gender</label>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" id="femaleRadio" name="sex" value="Female">Female
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" id="maleRadio"  name="sex" value="Male">Male
                                </label>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.form-group -->
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <span class="help-block">*Required fields</span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Bilgileri Kaydet</button>
            </form> <!-- /form -->
        </div>
    </div>
    <div class="col-md-4">
        <div class="container mt-5">
        </div>
    </div>
</div> <!-- ./container -->

</body>
</html>
