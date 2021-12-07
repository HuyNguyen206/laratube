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
                            <form id="update-form-channel" enctype="multipart/form-data"
                                  action="{{route('channels.update', $channel->id)}}" class="form" method="post">
                                @csrf
                                @method('put')

                                <div onclick="document.getElementById('image').click()"
                                     class="form-group d-flex justify-content-center">
                                    <div class="channel-avatar d-flex align-items-center">
                                        @if ($isAuthorizeToUpdate)
                                            <div class="channel-avatar-overlay">
                                                <svg style="color:white;width: 50px;" aria-hidden="true"
                                                     focusable="false" data-prefix="fas" data-icon="camera"
                                                     class="svg-inline--fa fa-camera fa-w-16" role="img"
                                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path fill="currentColor"
                                                          d="M512 144v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48h88l12.3-32.9c7-18.7 24.9-31.1 44.9-31.1h125.5c20 0 37.9 12.4 44.9 31.1L376 96h88c26.5 0 48 21.5 48 48zM376 288c0-66.2-53.8-120-120-120s-120 53.8-120 120 53.8 120 120 120 120-53.8 120-120zm-32 0c0 48.5-39.5 88-88 88s-88-39.5-88-88 39.5-88 88-88 88 39.5 88 88z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <img src="{{$channel->image()}}" alt="">
                                    </div>
                                </div>
                                <div class="text-center my-2">
                                    @include('channels.partials.subscribe-button')
                                </div>

                                <input onchange="document.getElementById('update-form-channel').submit()" type="file"
                                       class="d-none" name="image" id="image">
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
                                        <input name="name" type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{old('name', $channel->name)}}">
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
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  name="description"
                                                  rows="7">{{old('description',$channel->description )}}</textarea>
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
                <div class="card">
                    <div class="card-header">
                        Videos
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <th>STT</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @php
                                $page = request('page', 1);
                                $perPage = $videos->perPage()
                            @endphp
                            @foreach($videos as $video)
                                @php
                                $isProcessComplete = $video->getCustomProperty('percentage', 0) === 100
                                @endphp

                                <tr>
                                    <td>{{$page > 1 ? $loop->iteration + $perPage*($page-1) : $loop->iteration}}</td>
                                    <td>
                                        <img width="100" height="100" src="{{$video->getCustomProperty('thumbnail')}}"
                                             alt="Processing">
                                    </td>
                                    <td>{{$video->getCustomProperty('title')}}</td>
                                    <td>{{$video->getCustomProperty('view', 0)}}</td>
                                    <td>
                                        @if($isProcessComplete)
                                            <span class="badge badge-success">
                                             Live
                                         </span>
                                        @else
                                            <span class="badge badge-primary">
                                             Processing
                                         </span>
                                    @endif
                                    </td>
                                    <td>
                                        @if ($isProcessComplete)
                                            <a class="btn btn-outline-primary" href="{{ route('videos.show', $video->id)}}">View</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="my-2">
                            {!! $videos->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
