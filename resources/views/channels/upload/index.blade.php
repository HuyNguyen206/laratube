@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <upload-video inline-template :channel="{{$channel}}">
                <div class="col-md-8">
                    <div class="card" v-if="!selected">
                        <div class="card-header">
                            {{ $channel->name }}
                        </div>

                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <input multiple type="file" ref="videos" id="video" class="d-none" @change="upload">
                            <svg onclick="document.getElementById('video').click()" style="color:red;" width="100" height="70" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="youtube" class="svg-inline--fa fa-youtube fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path></svg>
                            <p>
                                Upload video
                            </p>
                        </div>
                    </div>
                    <div v-else>
                        <div class="my-4" v-for="(video, index) in videos" :key="index">
                            <div class="progress mb-3">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :style="{'width': getProgress(video, index)}" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-center align-items-center" style="height: 180px; color: white; font-size: 18px; background: #808080">
                                        Loading thumbnail...
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="text-danger">
                                        @{{ video.name }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </upload-video>
        </div>
    </div>
@endsection
