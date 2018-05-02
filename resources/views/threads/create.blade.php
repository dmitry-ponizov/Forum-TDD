@extends('layouts.app')
@section('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a ne w thread</div>
                    <div class="card-body">
                        <form action="/threads" method="POST">
                            {{csrf_field() }}
                            <div class="form-group">
                                <label for="channel_id">Choose a channel</label>
                                <select name="channel_id" id="channel_id" class="form-control" required>
                                    <option value="">Choose one...</option>
                                    @foreach($channels as $channel)
                                        <option {{ old('channel_id') == $channel->id ? 'selected' : '' }} value="{{$channel->id}}">{{$channel->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" name="title" required placeholder="title" value="{{ old('title') }}"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="body">Body: </label>
                                <wysiwyg name="body" :value="form.body"></wysiwyg>
                                {{--<textarea type="text" required name="body" rows="8" id="body"--}}
                                          {{--class="form-control">{{ old('body') }}</textarea>--}}
                            </div>
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6LcaH1YUAAAAACEyjIPxaMY6GWktcZA9zKkFeetx"></div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>
                            @if(count($errors))
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
