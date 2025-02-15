@extends('layouts.app')
@section('content')
    <section id="welcome">
        <div class="home-show">
            {{--? headline --}}
            <div class="bg01">
                <div class="container py-75">
                    <div class="headline ">
                        <h1>
                            La <span>Tua Casa </span>Merita di Essere Vista! 
                            <br> 
                            Pubblica il Tuo Annuncio su <span>BoolBnb</span> e Ottieni il <span>Massimo</span> della Visibilità!
                        </h1>
                    </div>
                </div>
            </div>
            {{--? subheadline --}}
            <div class="subheadline">
                <div class="container mt-75">
                    <p>
                        Pubblica il tuo annuncio su BoolBnb e assicurati che la tua casa sia vista da migliaia di potenziali acquirenti! 
                    </p>
                    <p>
                        Con le nostre sponsorizzazioni Platinum, Gold e Silver, hai la possibilità di apparire in cima ai risultati di ricerca e ottenere una visibilità mirata e strategica. 
                    </p> 
                    <h3 class="mt-4"> 
                        Non aspettare <span>scegli BoolBnb</span> per dare al tuo immobile l’<span>attenzione che merita</span>
                    </h3>
                    {{--? bottone --}}
                    <div class="manage">
                        <div class="create py-5">
                            <a href="{{route('admin.homes.create') }}">{{ __('Crea Nuovo')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection