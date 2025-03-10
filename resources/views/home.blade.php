@extends('app')

@section('content')
<div class="container text-center mt-5">
    <h1>Welcome to the Informatics Center Request and Support System</h1>
    <p class="lead">A system designed to manage IT support requests efficiently.</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <h3>Our Goals</h3>
            <ul class="text-left">
                <li>Reduce the need for in-person requests.</li>
                <li>Improve response time for IT support.</li>
                <li>Enhance request tracking and management.</li>
                <li>Provide a messaging system for communication.</li>
            </ul>
        </div>
        <div class="col-md-4">
            <h3>System Features</h3>
            <ul class="text-left">
                <li>Submit and track IT requests.</li>
                <li>Manage hardware assignments.</li>
                <li>Role-based access control.</li>
                <li>Internal messaging system.</li>
            </ul>
        </div>
        <div class="col-md-4">
            <h3>System Users</h3>
            <ul class="text-left">
                <li><strong>Employees:</strong> Submit and track requests.</li>
                <li><strong>IT Staff:</strong> Manage and prioritize requests.</li>
                <li><strong>Admins:</strong> Oversee users and system settings.</li>
            </ul>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
    </div>
</div>
@endsection