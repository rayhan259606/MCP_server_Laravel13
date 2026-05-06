@extends('layouts.app')

@section('title', 'Login | Blade Voice AI')

@section('content')
<div style="max-width: 450px; margin: 0 auto;">
    <div class="card">
        <h2 style="margin-bottom: 1.5rem; text-align: center;">Sign In</h2>
        <form id="login-form" action="#" method="GET" onsubmit="event.preventDefault(); alert('Login Submitted!');">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" class="form-control" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" placeholder="Enter password">
            </div>
            <button type="submit" class="btn-primary">Login Now</button>
        </form>
        <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted); font-size: 0.9rem;">
            Don't have an account? <a href="/register" style="color: var(--secondary); text-decoration: none;">Register</a>
        </p>
    </div>
    
    <div style="margin-top: 2rem; padding: 1rem; background: rgba(6, 182, 212, 0.1); border-radius: 12px; border: 1px dashed var(--secondary);">
        <p style="font-size: 0.85rem; color: var(--secondary);">
            <i class="fa-solid fa-lightbulb"></i> <strong>Voice Tip:</strong> Say "Fill form" to automatically enter credentials and login.
        </p>
    </div>
</div>
@endsection
