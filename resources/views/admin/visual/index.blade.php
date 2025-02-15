@extends('layouts.app')
@section('content')

<div class="home-show p-5">
    <div class="container">
        <div class="button-menage">
            {{--? bottone indietro --}}
            <div class="back mb-5">
                <a href="{{route('admin.homes.index') }}">{{ __('Indietro')}}</a>
            </div>
        </div>
        <div class="card no-hover mb-5">
            <div class="bg-btn pt-4 px-5">
                <h3 class="mb-4 color-text2">Statistiche visualizzazioni<small>:</small></h3>
            </div>
            <div class="pb-4 px-5">
                <div class="row p-5">
                    <div class="chart-container d-flex mt-5 w-50" data-visitors='@php echo json_encode($visitors); @endphp'>
                        <canvas id="chart" class="me-4"></canvas>
                        <canvas id="chart-apartments" class="ms-4"></canvas>
                    </div>
                </div>
            </div>           
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="{{ asset('js/visuals.js') }}"></script>
@endsection