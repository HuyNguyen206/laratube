@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                        <form action="">
                            <input type="text" class="form-control" placeholder="Enter the text to search channel/video" name="search">
                        </form>

                    @if ($videos->count())
                            <div class="card">
                                <div class="card-header">
                                    Videos
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
{{--                                        <th>STT</th>--}}
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
{{--                                                <td>{{$page > 1 ? $loop->iteration + $perPage*($page-1) : $loop->iteration}}</td>--}}
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
                                        {!! $videos->withQueryString()->links() !!}
                                    </div>
                                </div>
                            </div>
                    @endif
                    @if ($channels->count())
                            <div class="card">
                                <div class="card-header">
                                    Channels
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
{{--                                        <th>STT</th>--}}
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                        </thead>
                                        <tbody>
                                        @php
                                            $page = request('page', 1);
                                            $perPage = $channels->perPage()
                                        @endphp
                                        @foreach($channels as $channel)

                                            <tr>
{{--                                                <td>{{$page > 1 ? $loop->iteration + $perPage*($page-1) : $loop->iteration}}</td>--}}
                                                <td>
                                                    <img width="100" height="100" src="{{$channel->image}}"
                                                         alt="No image">
                                                </td>
                                                <td>{{$channel->name}}</td>
                                                <td>{{$channel->description}}</td>

                                                <td>
                                                    <a href="{{route('channels.show', $channel->id)}}" class="btn btn-outline-primary">Go to channel</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="my-2">
                                        {!! $channels->withQueryString()->links() !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
