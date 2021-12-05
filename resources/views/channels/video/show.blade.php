@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ $video->name }}
            </div>
            <div class="card-body">
                <video
                    id="my-video"
                    class="video-js"
                    data-setup='{}'
                >
                    <source src="{{MediaHelper::getStreamingUrl($video)}}" type="application/x-mpegURL"/>
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a
                        web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank"
                        >supports HTML5 video</a
                        >
                    </p>
                </video>
                @php
                    $canEditVideo = MediaHelper::canEditVideo($video)
                @endphp
                @if($canEditVideo)
                    <form action="{{route('videos.update', $video->id)}}" method="post">
                        @csrf
                        @method('put')
                @endif
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($canEditVideo)
                                    <div class="form-group mt-2">
                                        <input type="text" value="{{old('title', $video->getCustomProperty('title'))}}" name="title" class="form-control @error('title') is-invalid @enderror">
                                        @error('title')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>

                                 @else
                                <h4 class="mt-3">
                                    {{$video->getCustomProperty('title')}}
                                </h4>
                                 @endif
                                {{ $video->getCustomProperty('view', 0) }} {{ Str::plural('view', $video->getCustomProperty('view', 0)) }}
                            </div>
                            <vote :default_votes="{{json_encode($video->voters)}}" :entity="{{json_encode($video)}}"></vote>
                        </div>
                        @if($canEditVideo)
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="" cols="30" rows="5">{{old('description', $video->getCustomProperty('description'))}}</textarea>
                            @error('description')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                            <button class="mt-2 btn btn-primary btn-sm">Update video detail</button>
                        @else
                        <p>
                            {{$video->getCustomProperty('description')}}
                        </p>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between align-items-center m-2">
                            <div class="media">
                                <img src="https://picsum.photos/200/300" class="rounded-circle" alt="" width="50" height="50"
                                     class="mr-3">
                                <div class="media-body ml-2">
                                    <h5 class="mt-0 mb-0">
                                        {{$channel->name}}
                                    </h5>
                                    <span class="small">
                            Published on {{$video->created_at->toFormattedDateString()}}
                        </span>
                                </div>
                            </div>
                            @include('channels.partials.subscribe-button')
                        </div>
                @if($canEditVideo)
                    </form>
                @endif

            </div>
        </div>
       <list-comment :video-id="{{$video->id}}"></list-comment>
    </div>
@endsection

@section('style')
    <link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet"/>
    <style>
        .video-js {
            position: relative !important;
            width: 100% !important;
            height: 500px !important;
        }

        .vjs-poster {
            position: absolute !important;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        .thumb-up, .thumb-down {
            width: 20px;
            height: 20px;
            cursor: pointer;
            fill: currentColor;
        }

        .thumb-down-active, .thumb-up-active {
            color: #3EA6FF;
        }

        .thumb-down {
            margin-left: 1rem;
        }
    </style>
@endsection

@section('script')
    <script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
    <script>
        var video = videojs('my-video', {
            controls: true,
            autoplay: false,
            preload: 'auto',
            width: 700,
            height: 300
        })
        var isUpdateViewAlready = false
        video.on('timeupdate', function () {
            var percentagePlayed = Math.ceil((video.currentTime() / video.duration()) * 100);
            if (percentagePlayed > 10 && !isUpdateViewAlready) {
                isUpdateViewAlready = true
                axios.put(`/channels/videos/{{$video->id}}`)
                    .then(res => {

                    })
                    .catch(err => {
                        console.log(err.respond)
                    })
            }
        })
    </script>
@endsection
