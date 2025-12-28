@extends('layouts.main')

@section('title', 'Home Page')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

 <table>
    <tr>
        <td width="300" valign="top">
            <h3>Latest News:</h3>
            <ol>
                <li>New Admissions 2024</li>
                <li>Annual Cultural Event from <br> <b> 30 Sept to 5 Oct 2024</b></li>
                <li>Seminar on AI - 15th Oct</li>
            </ol>
        </td>
        <td valign="top">
            <h3>About Our Institute</h3>
            <p>At Government MCA College, Maninagar, we provide high-quality education in the field of Computer
                Applications. Our experienced faculties, and Principal Dr. Chetan B. Bhatt, are dedicated to
                imparting practical and theoretical knowledge.
            </p>
            <h3>Our Mission</h3>
            <p>We aim to produce professionals who excel in their respective fields. With state-of-the-art
                infrastructure and innovative teaching methods, we strive for academic excellence.</p>
            <br />
            <form align="left">

                <h3>Contact Us</h3>
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name"><br><br>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email"><br><br>
                <label for="message">Message:</label><br>
                <textarea id="message" name="message" rows="4" cols="50"></textarea><br><br>
                <button>Submit</button>
            </form>
        </td>
        <td width="200" valign="top">
            <h3>Important Links:</h3>
            <ul>
                <li><a href="#">NPTEL</a></li>
                <li><a href="#">UGC</a></li>
                <li><a href="#">AICTE</a></li>
            </ul>
        </td>
    </tr>
</table>
@endsection