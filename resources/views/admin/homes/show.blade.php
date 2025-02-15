@extends('layouts.app')

@section('content')
<div class="screen">
</div>
    <div class="home-show p-5">
        <div class="container">
            <div class="button-manage">
                {{--? bottone indietro --}}
                <div class="back">
                    <a href="{{route('admin.homes.index') }}">{{ __('Indietro')}}</a>
                </div>

                {{--? bottoni gestione --}}
                <div class="manage">
                    <div class="create">
                        <a href="{{route('admin.homes.create') }}">{{ __('Crea Nuovo')}}</a>
                    </div>
                    <a href="{{route('admin.homes.edit', $home)}}" class="ml-45 mr-10">
                        <i class="fas fa-pen orange"></i>
                    </a>
                    <a href="{{$home->slug}}" class="modale" data-slug="{{$home->slug}}">
                        <i class="fas fa-trash"></i>
                    </a> 

                    {{--? modale --}}
                    <div class="modale__modale holding" id="modale-{{$home->slug}}">
                        <span class="modale__exit">CHIUDI</span>
                        <h4>Sei sicuro di voler cancellare?</h4>
                        <p>La cancellazione è irreversibile</p>
                        <form id="delete-form-{{$home->slug}}" action="{{route('admin.homes.destroy', $home->slug)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input class="delete" type="submit" value="Elimina Casa">
                        </form>
                    </div>

                </div>
            </div>

            {{--? dettaglio informazioni --}}
            <div class="card no-hover p-5">
                <h2>{{$home->title}}</h2>
                <hr class="mb-5">

                <div class="crd">
                    <div class="image">
                        {{--? immagine da url --}}
                        @if (Str::startsWith($home->image, 'http'))
                        <img src="{{ $home->image }}" alt="{{ $home->title }}" class="rounded">
                        @else
                        {{--? immagine da storage --}}
                        <img src="{{ asset('storage/' . $home->image) }}" alt="{{ $home->title }}" class="rounded">
                        @endif
                    </div>
                    <div class="text">
                        <ul>
                            <li class="mb-3">
                                <span>Indirizzo: </span>{{$home->address}}
                            </li>
                            <li class="mb-3">
                                <span>Numero Stanze: </span>{{$home->rooms}}
                            </li>
                            <li class="mb-3">
                                <span>Numero Letti: </span>{{$home->beds}}
                            </li>
                            <li class="mb-3">
                                <span>Numero Bagni: </span>{{$home->bathrooms}}
                            </li>
                            <li class="mb-3">
                                <span>Superficie: </span>{{$home->square_metres}} mq
                            </li>
                            <li class="mb-3">
                                <span>Servizi: </span>
                                @forelse ($home->services as $service)
                                {{ $service->name }} {{ !$loop->last ? ',' : '' }}
                                @empty
                                Nessuna servizio selezionato
                                @endforelse
                            </li>
                            <li class="mb-3">
                                @if ($home->ads->last())
                                <p><span>tipo di sponsorizzata: </span>{{$home->ads->last()->title}}</p>
                                <p><span>data inizio </span>{{$home->ads->last()->created_at->format('d/m/Y')}}</p>
                                <p><span>Tempo rimanente: </span>{{ $activeSponsorship['remaining_time']?? 'Non Attiva' }}</p>
                                @else
                                <p>Non ci sono sponsorizzate!</p>   
                                @endif   
                            </li>
                        </ul>
                    </div>
                </div>
                <p>
                    <span>Descrizione: </span>{{$home->description}}
                </p>

                {{--? visualizzazioni & bottone per la sponsorizzazione --}}
                <div class="view-ads">
                    <div class="view mt-4">
                        <p>
                            <span class="fs-4">visualizzazioni: </span>
                            @if ($home->visuals()->count() > 0)
                            {{$home->visuals()->count()}}
                            @else
                            Il tuo annuncio non ha visualizzazioni                      
                            @endif

                        </p>
                    </div>
                    @if (!$activeSponsorship)
                    <div class="ads button-manage my-4 d-block"">
                        <p><span class="fs-4 d-block mb-4">Metti in evidenza la tua casa!</span></p>
                        <div class="back">
                            <a href="{{ route('payment.form', $home->slug) }}">
                                Compra Visibilità
                            </a>
                        </div>
                    </div>
                    @endif

                    {{--? messaggio di avvenuto pagamento --}}
                    @if (session('success'))
                    <div class="alert alert-success my-3" id="messaggio">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>

                <hr class="mt-4">
                {{--? messaggi da frontend: --}}
                <div class="row row-gap-3 my-4">
                    <h3 class="com">Messaggi:</h3>
                    @forelse ($home->messages->reverse() as $message)
                    <div class="col-12">
                        <div class="card-body">
                            <h4 class="card-title">{{ $message ->name}}</h4>
                            <em>{{ $message ->email}}</em>
                            <p class="card-text">{{ $message ->content }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="">
                        <h3>Non ci sono messaggi</h3>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/modale.js') }}"></script>
@endsection

@section('scripts')
<script src="{{ asset('js/timeout.js') }}"></script>
@endsection
    