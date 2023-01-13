@extends('templates.default.layouts.admin')

@section('content')
    <div class="row">
        <div class="col">
            <h1>{{$title}}</h1>
        </div>
        <div class="col">
            <ul class="nav justify-content-end">
                @if (isset($buttons))
                @foreach ($buttons as $button)
                <li class="nav-item">
                    <a class="btn btn-secondary" href="{{$button['href']}}">{{$button['text']}}</a>
                </li>
                @endforeach
                @endif
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @include('templates.default.components.table',['routeNamePrefix'=>(isset($routeNamePrefix)?$routeNamePrefix:''), 'actions'=>(isset($tableActions)?($tableActions):[]),'columns'=>$columns,'data'=>$data])
        </div>
    </div>

@endsection
