@extends('layouts.main')

@section('title', 'Home Page')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/calculator.css') }}">
@endpush

@section('content')
<main>
    <div class="container" >
    <input type="text" name="user-input" id="user-input" disabled />

    <table id="user-input-table">
        <tr>
            <td >CI</td>
            <td >+/-</td>
            <td>%</td>
            <td >/</td>
        </tr>
        <tr>
            <td>7</td>
            <td >8</td>
            <td >9</td>
            <td>*</td>
        </tr>
        <tr>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>-</td>
        </tr>
        <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>+</td>
        </tr>
        <tr>
            <td>0</td>
            <td>.</td>
            <td>=</td>
        </tr>
    </table>
    </div>
</main>
@endsection

@push('scripts')
    <script src="js/calculator.js"></script>
@endpush