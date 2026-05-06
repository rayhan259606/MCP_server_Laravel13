@extends('layouts.app')

@section('title', 'Careers | Blade Voice AI')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <h2 style="margin-bottom: 0.5rem; text-align: center;">Join Our Team</h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem;">Apply for your dream job with your voice.</p>
        
        <form id="career-form" action="#" method="GET" onsubmit="event.preventDefault(); alert('Application Submitted!');">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" class="form-control" placeholder="Your name">
            </div>
            <div class="form-group">
                <label for="position">Interested Position</label>
                <input type="text" id="position" class="form-control" placeholder="e.g. Senior Developer">
            </div>
            <div class="form-group">
                <label for="message">Why should we hire you?</label>
                <textarea id="message" class="form-control" rows="4" placeholder="Tell us about yourself"></textarea>
            </div>
            <button type="submit" class="btn-primary">Submit Application</button>
        </form>
    </div>
    
    <div style="margin-top: 2rem; padding: 1rem; background: rgba(244, 63, 94, 0.1); border-radius: 12px; border: 1px dashed var(--accent);">
        <p style="font-size: 0.85rem; color: var(--accent);">
            <i class="fa-solid fa-lightbulb"></i> <strong>Voice Tip:</strong> Say "Fill career form" to submit your demo application instantly.
        </p>
    </div>
</div>
@endsection
