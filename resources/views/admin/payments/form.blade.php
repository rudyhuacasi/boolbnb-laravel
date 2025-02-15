@extends('layouts.app')

@section('content')
<div class="home-show">

    <div class="container my-5 m-auto">
         {{--? bottone torna indietro --}}
         <div class="button-manage text-end">
             <div class="manage">
                <a class="d-block" href="{{route('admin.homes.show', $home->slug)}}"><span class="orange">Torna indietro</span></a>
            </div>
         </div>
        <h2 class="mb-5"><span class="color-text">Compra Visibilità per la casa: </span>{{ $home->title }}</h2>
    
        <form id="payment-form" action="{{route('payment.store', $home->slug)}}" method="POST">
            @csrf
    
            <div class="row">
                <!-- Cicla attraverso le opzioni di sponsorizzazione definite nel file di configurazione -->
                @foreach(config('ads') as $ad)
                <div class="col-md-4">
                    <div class="card h-100">
                        <!-- Radio button per selezionare il tipo di sponsorizzazione -->
                        <input type="radio" id="ad_{{ $ad['id'] }}" name="sponsorship" value="{{ $ad['id'] }}" required>
                        <label for="ad_{{ $ad['id'] }}">
                            <div class="card-header fw-bolder">
                                
                                <span class="ms-3"> {{ ucfirst($ad['title']) }} Sponsorizzazione</span>

                            </label>
                        </div>
                        <div class="card-body">
                            <!-- Durata e prezzo della sponsorizzazione -->
                            <ul>
                                <li>
                                    <p><span> Durata: </span> {{ explode(':', $ad['duration'])[0] }} ore</p>
                                </li>
                                <li>
                                    <p><span>Prezzo: </span> € {{ $ad['price'] }} </p>                                       
                                </li>
                                <!-- Descrizione dei vantaggi -->
                                @if ($ad['title'] == 'platinum')
                                <li><span><i class="fas fa-check color-text"></i> </span>Massima priorità nei risultati di ricerca</li>
                                <li><span><i class="fas fa-check color-text"></i> </span>Visibilità garantita su tutte le pagine principali</li>
                                @elseif ($ad['title'] == 'gold')
                                <li><span><i class="fas fa-check color-text"></i> </span>Alta priorità nei risultati di ricerca</li>
                                <li><span><i class="fas fa-check color-text"></i> </span>Visibilità in primo piano su determinate pagine</li>
                                @elseif ($ad['title'] == 'silver')
                                <li><span><i class="fas fa-check color-text"></i> </span>Priorità nei risultati di ricerca</li>
                                <li><span><i class="fas fa-check color-text"></i> </span>Visibilità su alcune pagine principali</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
    
            <!-- Campo nascosto per lo slug della casa -->
            <input type="hidden" id="home-slug" name="home_slug" value="{{ $home->slug }}">
    
            <!-- Drop-in di Braintree -->
            <div id="dropin-container" class="card no-hover p-4 my-4"></div>
    
            {{--? MODALE BREINTREE--}}
            <div id="dropin-container">
                {{--? apre modale --}}
            </div>
            <div class="button-manage">
                <div class="back">
                    <div id="error-message" class="alert alert-danger mb-3" style="display: none"></div>
                    <button id="submit-button" type="button">Procedi con il pagamento</button>
                </div>

            </div>
        </form>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://js.braintreegateway.com/web/dropin/1.43.0/js/dropin.js"></script>
<script src="{{ asset('js/braintree.js') }}"></script>
@endsection