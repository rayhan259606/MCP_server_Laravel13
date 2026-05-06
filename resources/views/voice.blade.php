@extends('layouts.app')

@section('title', 'Dashboard | Blade Voice AI')

@section('content')
<div style="text-align: center; margin-top: 5rem;">
    <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem;">Welcome to <span style="color: var(--secondary);">Voice AI</span></h1>
    <p style="color: var(--text-muted); font-size: 1.2rem; max-width: 600px; margin: 0 auto 3rem;">
        Control your entire application using just your voice. Navigate pages, fill forms, and manage data effortlessly.
    </p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 3rem;">
        <div class="card">
            <i class="fa-solid fa-right-to-bracket" style="font-size: 2rem; color: var(--primary); margin-bottom: 1rem;"></i>
            <h3>Navigation</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Say "Go to Login" or "Registration" to navigate instantly.</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-keyboard" style="font-size: 2rem; color: var(--secondary); margin-bottom: 1rem;"></i>
            <h3>Auto-Fill</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Say "Fill Form" on any page to populate demo data.</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-paper-plane" style="font-size: 2rem; color: var(--accent); margin-bottom: 1rem;"></i>
            <h3>Auto-Submit</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">The system will automatically submit the form after filling.</p>
        </div>
    </div>
</div>
@endsection
