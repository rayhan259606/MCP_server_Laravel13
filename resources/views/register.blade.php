@extends('layouts.app')

@section('title', 'Register | Blade Voice AI')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <div class="card">
        <h2 style="margin-bottom: 1.5rem; text-align: center;">Create Account</h2>
        <form id="register-form" action="#" method="GET" onsubmit="event.preventDefault(); alert('Registration Submitted!');">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" class="form-control" placeholder="Enter full name">
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" class="form-control" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" placeholder="Enter password">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" class="form-control" placeholder="Confirm password">
            </div>
            <button type="submit" class="btn-primary">Register Now</button>
        </form>
    </div>
    
    <div style="margin-top: 2rem; padding: 1rem; background: rgba(139, 92, 246, 0.1); border-radius: 12px; border: 1px dashed var(--primary);">
        <p style="font-size: 0.85rem; color: var(--primary);">
            <i class="fa-solid fa-lightbulb"></i> <strong>Voice Tip:</strong> Say "Registration form fill up" to automate this process.
        </p>
    </div>
</div>
@endsection
