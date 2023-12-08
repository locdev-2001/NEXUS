@extends('client.pages.layout')
@section('main-content')
    <div class="content-area" style="flex-basis: 80%">
                {{ $slot }}
    </div>
    @stack('scripts')
@endsection
