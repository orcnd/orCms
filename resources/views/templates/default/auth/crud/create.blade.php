@extends('templates.default.layouts.admin')

@section('content')
    <div class="row">
        <div class="col">
            <h1>{{__('Create')}} {{$title}}</h1>
            <form method="POST" action="{{$route}}">
                @csrf
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div>{{$error}}</div>
                @endforeach
                @endif
                @each('templates.default.components.form', $form, 'item')
                <div class="row mb-4">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
