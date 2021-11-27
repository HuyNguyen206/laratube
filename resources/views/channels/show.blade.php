@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        {{ $channel->name }}
                        <a href="{{route('upload-video.index', $channel->id)}}">Upload videos</a>
                    </div>

                    <div class="card-body">
                        @php
                            $isAuthorizeToUpdate = $channel->canUpdateByCurrentUser();
                        @endphp
                        @if ($isAuthorizeToUpdate)
                            @include('layouts.partial.show-message')
                            <form id="update-form-channel" enctype="multipart/form-data" action="{{route('channels.update', $channel->id)}}" class="form" method="post">
                                @csrf
                                @method('put')

                                <div onclick="document.getElementById('image').click()" class="form-group d-flex justify-content-center">
                                    <div class="channel-avatar d-flex align-items-center">
                                        @if ($isAuthorizeToUpdate)
                                            <div class="channel-avatar-overlay">
                                                <svg style="color:white;width: 50px;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="camera" class="svg-inline--fa fa-camera fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M512 144v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48h88l12.3-32.9c7-18.7 24.9-31.1 44.9-31.1h125.5c20 0 37.9 12.4 44.9 31.1L376 96h88c26.5 0 48 21.5 48 48zM376 288c0-66.2-53.8-120-120-120s-120 53.8-120 120 53.8 120 120 120 120-53.8 120-120zm-32 0c0 48.5-39.5 88-88 88s-88-39.5-88-88 39.5-88 88-88 88 39.5 88 88z"></path></svg>
                                            </div>
                                        @endif
                                        <img src="{{$channel->image()}}" alt="">
                                    </div>
                                </div>
                                <div class="text-center my-2">
                                    @include('channels.partials.subscribe-button')
                                </div>

                                <input onchange="document.getElementById('update-form-channel').submit()" type="file" class="d-none" name="image" id="image">
                                @error('image')
                                <span class="d-none is-invalid"></span>
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                                @endif
                                @if ($isAuthorizeToUpdate)
                                    <div class="form-group">
                                        <label for="">
                                            Name
                                        </label>
                                        <input name="name"  type="text" class="form-control @error('name') is-invalid @enderror" value="{{old('name', $channel->name)}}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">
                                            Description
                                        </label>
                                        <textarea  class="form-control @error('description') is-invalid @enderror" name="description"   rows="7">{{old('description',$channel->description )}}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary">
                                        Update channel
                                    </button>
                            </form>
                            @else
                            <div class="form-group text-center">
                                <img src="{{$channel->image()}}" alt="">
                                <div class="my-2">
                                    @include('channels.partials.subscribe-button')
                                </div>
                                <h4>
                                    {{$channel->name}}
                                </h4>
                                <p>
                                    {{$channel->description}}
                                </p>

                            </div>
                                @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
