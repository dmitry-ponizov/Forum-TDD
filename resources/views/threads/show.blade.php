@extends('layouts.app')
@section('head')
    <script>
        window.thread = <?= json_encode($thread); ?>
    </script>
    @endsection
@section('content')
    <thread-view inline-template :thread="{{ $thread }}">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @include('threads._question')
                    <replies @removed="repliesCount--" @added="repliesCount++"></replies>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p>
                                This thread was published {{$thread->created_at->diffForHumans()}}
                                by <a href="# ">{{ $thread->creator->name }}</a>, and currently
                                has
                                <span v-text="repliesCount"></span> {{ str_plural('comment',$thread->replies_count) }}
                            </p>
                            <p>
                                <subscribe-button v-if="signedIn" :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                                <button v-if="authorize('isAdmin')"
                                        class="btn btn-sm btn-danger"
                                        @click="toggleLock" v-text="locked ? 'Unlock' : 'Lock' ">
                                    Lock
                                </button>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
