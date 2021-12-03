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

                            <div class="d-flex">
                                <div class="mr-3">
                                    <svg style="width: 25px" aria-hidden="true" focusable="false" data-prefix="far"
                                         data-icon="thumbs-up"
                                         class="svg-inline--fa fa-thumbs-up fa-w-16" role="img"
                                         xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 512 512">
                                        <path fill="currentColor"
                                              d="M466.27 286.69C475.04 271.84 480 256 480 236.85c0-44.015-37.218-85.58-85.82-85.58H357.7c4.92-12.81 8.85-28.13 8.85-46.54C366.55 31.936 328.86 0 271.28 0c-61.607 0-58.093 94.933-71.76 108.6-22.747 22.747-49.615 66.447-68.76 83.4H32c-17.673 0-32 14.327-32 32v240c0 17.673 14.327 32 32 32h64c14.893 0 27.408-10.174 30.978-23.95 44.509 1.001 75.06 39.94 177.802 39.94 7.22 0 15.22.01 22.22.01 77.117 0 111.986-39.423 112.94-95.33 13.319-18.425 20.299-43.122 17.34-66.99 9.854-18.452 13.664-40.343 8.99-62.99zm-61.75 53.83c12.56 21.13 1.26 49.41-13.94 57.57 7.7 48.78-17.608 65.9-53.12 65.9h-37.82c-71.639 0-118.029-37.82-171.64-37.82V240h10.92c28.36 0 67.98-70.89 94.54-97.46 28.36-28.36 18.91-75.63 37.82-94.54 47.27 0 47.27 32.98 47.27 56.73 0 39.17-28.36 56.72-28.36 94.54h103.99c21.11 0 37.73 18.91 37.82 37.82.09 18.9-12.82 37.81-22.27 37.81 13.489 14.555 16.371 45.236-5.21 65.62zM88 432c0 13.255-10.745 24-24 24s-24-10.745-24-24 10.745-24 24-24 24 10.745 24 24z"></path>
                                    </svg>
                                    <span>
                                25k
                            </span>

                                </div>
                                <div>
                                    <svg style="width: 25px" aria-hidden="true" focusable="false" data-prefix="far"
                                         data-icon="thumbs-down"
                                         class="svg-inline--fa fa-thumbs-down fa-w-16" role="img"
                                         xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 512 512">
                                        <path fill="currentColor"
                                              d="M466.27 225.31c4.674-22.647.864-44.538-8.99-62.99 2.958-23.868-4.021-48.565-17.34-66.99C438.986 39.423 404.117 0 327 0c-7 0-15 .01-22.22.01C201.195.01 168.997 40 128 40h-10.845c-5.64-4.975-13.042-8-21.155-8H32C14.327 32 0 46.327 0 64v240c0 17.673 14.327 32 32 32h64c11.842 0 22.175-6.438 27.708-16h7.052c19.146 16.953 46.013 60.653 68.76 83.4 13.667 13.667 10.153 108.6 71.76 108.6 57.58 0 95.27-31.936 95.27-104.73 0-18.41-3.93-33.73-8.85-46.54h36.48c48.602 0 85.82-41.565 85.82-85.58 0-19.15-4.96-34.99-13.73-49.84zM64 296c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zm330.18 16.73H290.19c0 37.82 28.36 55.37 28.36 94.54 0 23.75 0 56.73-47.27 56.73-18.91-18.91-9.46-66.18-37.82-94.54C206.9 342.89 167.28 272 138.92 272H128V85.83c53.611 0 100.001-37.82 171.64-37.82h37.82c35.512 0 60.82 17.12 53.12 65.9 15.2 8.16 26.5 36.44 13.94 57.57 21.581 20.384 18.699 51.065 5.21 65.62 9.45 0 22.36 18.91 22.27 37.81-.09 18.91-16.71 37.82-37.82 37.82z"></path>
                                    </svg>
                                    <span>
                              11k
                           </span>
                                </div>

                            </div>
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
