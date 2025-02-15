@extends('layouts.app')

@section('content')
<div class="home-index mt-4">
    <div class="container m-5 m-auto">
        <div class="manage">
            {{--? bottone crea --}}
            <div class="create my-5 text-end">
                <a href="{{route('admin.homes.create') }}">{{ __('Crea Nuovo')}}</a>
            </div>
        </div>
        <h2 class="my-5 color-text">Lista Case:</h2>
        <div class="row">
            <ul class="d-flex flex-wrap mb-0">
                @foreach ($homes as $apartment)
                <li class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="mx-2 my-3">
                        {{--? link diretto su foto --}}
                        <a href="{{ route('admin.homes.show', $apartment)}}">
                            <div class="img-container">
                                @if (Str::startsWith($apartment->image, 'http'))
                                {{--? immagine da url --}}
                                <img src="{{ $apartment->image }}" alt="{{ $apartment->title }}" class="rounded">
                                @else
                                {{--? immagine da storage --}}
                                <img src="{{ asset('storage/' . $apartment->image) }}" alt="{{ $apartment->title }}" class="rounded">
                                @endif
                            </div>
                        </a>
                        <p class="title"><strong>{{$apartment['title']}}</strong></p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="manage mt-4 mb-5">
            <a href="{{route('admin.visual.index')}}">Statistiche</a>
        </div>
    </div>
</div>
@endsection