@extends('layouts.app')

@section('content')


<div class="home-show">
    <div class="container mt-5">
        {{--? bottone indietro --}}
        <div class="button-manage text-end mt-5">
            <div class="back">
                <a href="{{route('admin.homes.index') }}">{{ __('Indietro')}}</a>
            </div>
        </div>
    
        <div class="card no-hover mb-5">
            <div class="px-5 pt-4 bg-btn">
                <h2 class="mb-4 color-text2">Modifica la casa<small>:</small></h2>
            </div>
            <div class="pb-4 px-5">
                <!-- Formulario di edizione -->
                <form action="{{ route('admin.homes.update', $home) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                    @method('PUT')
                    @csrf
            
                    {{-- <!-- Titolo -->--}}
                    <div class="form-group mb-3 formcontainer ">
                        <label for="title" class="@error('title') text-danger @enderror">Titolo <small>*</small></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $home->title) }}" required>
            
                        @if ($errors->get('title'))
                        @foreach ($errors->get('title') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
            
                    <!-- Descrizione -->
                    <div class="form-group mb-3 formcontainer ">
                        <label for="description" class="pt-2 @error('description') text-danger @enderror">Descrizione</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $home->description) }}</textarea>
            
                        @if ($errors->get('description'))
                        @foreach ($errors->get('description') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <!-- Indirizzo -->
                    <div class="form-group mb-3 formcontainer ">
                        <label for="address" class="@error('address') text-danger @enderror">Indirizzo <small>*</small></label>
                        <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $home->address) }}" required>
                        <ul id="address-suggestions" class="list-group"></ul>
            
                        @if ($errors->get('address'))
                        @foreach ($errors->get('address') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <!-- Letti -->
                    <div class="form-group mb-3 formcontainer flex-row ">
                        <div class="d-flex">
                            <div class="col-2">
                                <label for="beds" class="pt-2 @error('beds') text-danger @enderror">Numero di letti <small>*</small></label>
                            </div>
                            <input type="number" name="beds" class="form-control w-25  @error('beds') is-invalid @enderror" value="{{ old('beds', $home->beds) }}" required>
                        </div>
            
                        @if ($errors->get('beds'))
                        @foreach ($errors->get('beds') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <!-- Bagni -->
                    <div class="form-group mb-3 formcontainer flex-row">
                        <div class="d-flex">
                            <div class="col-2">
                                <label for="bathrooms" class="pt-2 @error('bathrooms') text-danger @enderror">Numero di bagni <small>*</small></label>
                            </div>
                            <input type="number" name="bathrooms" class="form-control w-25  @error('bathrooms') is-invalid @enderror" value="{{ old('bathrooms', $home->bathrooms) }}" required>
                        </div>
            
                        @if ($errors->get('bathrooms'))
                        @foreach ($errors->get('bathrooms') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <!-- Stanze -->
                    <div class="form-group mb-3 formcontainer flex-row">
                        <div class="d-flex">
                            <div class="col-2">
                                <label for="rooms" class="pt-2 @error('rooms') text-danger @enderror">Numero di stanze <small>*</small></label>
                            </div>
                            <input type="number" name="rooms" class="form-control w-25  @error('rooms') is-invalid @enderror" value="{{ old('rooms', $home->rooms) }}" required>
                        </div>
            
                        @if ($errors->get('rooms'))
                        @foreach ($errors->get('rooms') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <!-- Metri quadrati (mq) -->
                    <div class="form-group mb-3 formcontainer flex-row">
                        <div class="d-flex">
                            <div class="col-2">
                                <label for="square_metres" class="pt-2 @error('square_metres') text-danger @enderror">Metri quadri (mq) <small>*</small></label>
                            </div>
                            <input type="number" name="square_metres" class="form-control w-25  @error('square_metres') is-invalid @enderror" value="{{ old('square_metres', $home->square_metres) }}" required>
                        </div>
            
                        @if ($errors->get('square_metres'))
                        @foreach ($errors->get('square_metres') as $message)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @endforeach
                        @endif
                    </div>
            
                    <!-- Servizi -->
                    <div class="form-group mb-3">
                        <label for="services">Servizi <small>*</small></label>
                        <div class="d-flex flex-wrap">
                            @foreach ($services as $service)
                            <div class="col-3">
                                <div class="form-check px-5">
                                    <input class="form-check-input" type="checkbox" name="services[]" value="{{ $service->id }}"
                                        {{ in_array($service->id, $home->services->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="service{{ $service->id }}">
                                        {{ $service->name }}
                                    </label>
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
                    {{-- Immagini--}}
            
                    <div class="mb-3 ">
                        <label for="images" class="form-label">Immagine <small>*</small></label>
                        <input type="file" class="form-control" id="images" name="image" multiple>
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
                        {{ old('active', $home->active) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Annuncio On Line</label>
                    </div>
            
                    {{--? bottone modifica --}}
                    <p><small>*</small> Questi campi sono richiesti</p>
                    <button class="effect mb-3 submit-checkbox" onclick="validateForm()" type="submit">Modifica Casa</button>
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
