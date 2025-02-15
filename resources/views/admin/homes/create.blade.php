@extends('layouts.app')

@section('content')
<div class="home-show">
    <div class="container mt-5">   
        <div class="button-manage text-end my-5">
            {{--? bottone indietro --}}
            <div class="back">
                <a href="{{route('admin.homes.index') }}">{{ __('Indietro')}}</a>
            </div>
        </div>
        <div class="card no-hover mb-5">
            <div class="bg-btn pt-4 px-5">
                <h2 class="mb-4 color-text2">Inserisci una casa<small>:</small></h2>
            </div>
            <div class="pb-4 px-5">
                <form action="{{route('admin.homes.store')}}" method="POST" enctype="multipart/form-data" class="m-4">
                    @csrf
            
                    <div class="mb-3">
                        <label for="title" class="form-label">Titolo <small>*</small></label>
                        <input type="text" class="form-control @if ($errors->get('title')) is-invalid @endif" id="title" name="title" value="{{old('title')}}" required>
                        @if ($errors->get('title'))
                        @foreach ($errors->get('title') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione</label>
                        <textarea class="form-control @if ($errors->get('description')) is-invalid @endif" id="description" rows="3" name="description">{{old('description')}}</textarea>
                        @if ($errors->get('description'))
                        @foreach ($errors->get('description') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <div class="mb-3">
                        <label for="address" class="form-label">Indirizzo <small>*</small></label>
                        <input type="text" class="form-control @if ($errors->get('address')) is-invalid @endif" id="address" name="address" value="{{old('address')}}" autocomplete="off" required>
                        <ul id="address-suggestions" class="list-group"></ul>
                        @if ($errors->get('address'))
                        @foreach ($errors->get('address') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <div class="mb-3">
                        <div class="d-flex">
                            <div class="col-2">
                                <label for="num-beds" class="form-label me-4">Numero di letti <small>*</small></label>
                            </div>
                            <input type="number" class="w-25 form-control @if ($errors->get('beds')) is-invalid @endif" id="num-beds" name="beds" value="{{old('beds')}}" required>
                        </div>
                        @if ($errors->get('beds'))
                        @foreach ($errors->get('beds') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <div class="mb-3">
                        <div class="d-flex">
                            <div class="col-2">
                                <label for="num-bathrooms" class="form-label me-4">Numero di bagni <small>*</small></label>
                            </div>
                            <input type="number" class="w-25 form-control @if ($errors->get('bathrooms')) is-invalid @endif" id="num-bathrooms" name="bathrooms" value="{{old('bathrooms')}}" required>
                        </div>
                        @if ($errors->get('bathrooms'))
                        @foreach ($errors->get('bathrooms') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <div class="mb-3">
                        <div class="d-flex">
                            <div class="col-2">
                                <label for="num-rooms" class="form-label me-4">Numero di stanze <small>*</small></label>
                            </div>
                            <input type="number" class="w-25 form-control @if ($errors->get('rooms')) is-invalid @endif" id="num-rooms" name="rooms" value="{{old('rooms')}}" required>
                        </div>
                        @if ($errors->get('rooms'))
                        @foreach ($errors->get('rooms') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <div class="mb-3">
                        <div class="d-flex">
                            <div class="col-2">
                                <label for="num-mq" class="form-label me-4">Metri quadri (mq) <small>*</small></label>
                            </div>
                            <input type="number" class="w-25 form-control @if ($errors->get('square_metres')) is-invalid @endif" id="num-mq" name="square_metres" value="{{old('square_metres')}}" required>
                        </div>
                        @if ($errors->get('square_metres'))
                        @foreach ($errors->get('square_metres') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <div class="mb-3">
                        <label for="services" class="form-label">Servizi <small>*</small></label>
                        <div class="d-flex flex-wrap">
                            @foreach ($services as $service)
                            <div class="col-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="service-{{$service->id}}" value="{{$service->id}}" name="services[]" {{in_array($service->id, old('services', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="service-{{$service->id}}">{{$service->name}}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- Messaggio di errore per validazione frontend -->
                        <div id="service-error" class="text-danger" style="display: none;">Devi selezionare almeno un servizio.</div>
            
                        @if ($errors->has('services'))
                        <div class="invalid-feedback d-block">
                            @foreach ($errors->get('services') as $message)
                            {{ $message }}<br>
                            @endforeach
                        </div>
                        @endif
                    </div>
            
                    <div class="mb-3">
                        <label for="image" class="form-label">Immagini <small>*</small></label>
                        <input class="form-control @if ($errors->get('image')) is-invalid @endif" type="file" name="image" id="image" required>
                        @if ($errors->get('image'))
                        @foreach ($errors->get('image') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <div class="form-check form-switch mt-4 mb-5">
                        <input type="hidden" name="active" value="0">
                        <input class="form-check-input" type="checkbox" role="switch" id="active" name="active" value="1"
                        {{in_array($service->id, old('services', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Annuncio On Line</label>
                    </div>
            
                    {{--? bottone inserimento --}}
                    <p><small>*</small> Questi campi sono richiesti</p>
                    <button class="effect mb-3 submit-checkbox" onclick="validateForm()" type="submit">Inserisci Casa</button>
                </form>
            </div>
        </div>
    </div>
</div>
    @endsection

    {{--? script per il suggeritore degli indirizzi --}}
    @section('scripts')
    <script>
        const addressSuggestionsUrl = "{{ route('get.address.suggestions') }}";
    </script>
    <script src="{{ asset('js/address-autocomplete.js') }}"></script>
    <script src="{{ asset('js/validateCheckbox.js') }}"></script>
    @endsection