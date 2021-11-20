@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $channel->name }}</div>

                    <div class="card-body">
                        <form id="update-form-channel" enctype="multipart/form-data" action="{{route('channels.update', $channel->id)}}" class="form" method="post">
                            @csrf
                            @method('put')
                          <div onclick="document.getElementById('image').click()" class="form-group d-flex justify-content-center">
                              <div class="channel-avatar d-flex align-items-center">
                                  <div class="channel-avatar-overlay">
                                      <svg style="color:white;width: 50px;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="camera" class="svg-inline--fa fa-camera fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M512 144v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48h88l12.3-32.9c7-18.7 24.9-31.1 44.9-31.1h125.5c20 0 37.9 12.4 44.9 31.1L376 96h88c26.5 0 48 21.5 48 48zM376 288c0-66.2-53.8-120-120-120s-120 53.8-120 120 53.8 120 120 120 120-53.8 120-120zm-32 0c0 48.5-39.5 88-88 88s-88-39.5-88-88 39.5-88 88-88 88 39.5 88 88z"></path></svg>
                                  </div>
                                  <img src="{{$channel->image()}}" alt="">
                              </div>
                          </div>
                            <input onchange="document.getElementById('update-form-channel').submit()" type="file" class="d-none" name="image" id="image">
                            <div class="form-group">
                                <label for="">
                                    Name
                                </label>
                                <input name="name" type="text" class="form-control" value="{{$channel->name}}">
                            </div>
                            <div class="form-group">
                                <label for="">
                                    Description
                                </label>
                                <textarea class="form-control" name="description"  rows="7">{{$channel->description}}</textarea>
                            </div>

                            <button class="btn btn-primary">
                                Update channel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
