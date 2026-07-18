@extends('layouts.admin')

@section('title', 'Contact Inquiry')

@section('content')
<div class="page-header d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h1><i class="bi bi-envelope me-2" style="color: var(--primary);"></i>Contact Inquiry</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}">Contacts</a></li>
                <li class="breadcrumb-item active">{{ $contact->subject ?? 'Inquiry' }}</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<x-alert type="success" :message="session('success')" />
<x-alert type="error" :message="session('error')" />

<div class="row g-3">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold">{{ $contact->subject }}</span>
                <small class="text-muted">{{ $contact->created_at->format('M d, Y h:i A') }}</small>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>From:</strong> {{ $contact->name }} &lt;{{ $contact->email }}&gt;
                    @if($contact->phone) <span class="ms-3"><strong>Phone:</strong> {{ $contact->phone }}</span> @endif
                </div>
                <hr>
                <div style="white-space: pre-wrap;">{{ $contact->message }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header fw-semibold">Status</div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Read:</strong>
                    @if($contact->read_at)
                        <span class="badge badge-soft-success">Yes</span>
                        <small class="text-muted d-block">{{ $contact->read_at->format('M d, Y h:i A') }}</small>
                    @else
                        <span class="badge badge-soft-warning">Unread</span>
                    @endif
                </div>
                <div class="mb-2">
                    <strong>Replied:</strong>
                    @if($contact->replied_at)
                        <span class="badge badge-soft-success">Yes</span>
                        <small class="text-muted d-block">{{ $contact->replied_at->format('M d, Y h:i A') }}</small>
                    @else
                        <span class="badge badge-soft-secondary">Not yet</span>
                    @endif
                </div>
            </div>
        </div>

        @unless($contact->replied_at)
        <div class="card">
            <div class="card-header fw-semibold">Send Reply</div>
            <div class="card-body">
                <form action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <textarea name="reply_message" class="form-control" rows="5" placeholder="Type your reply..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-send"></i> Send Reply</button>
                </form>
            </div>
        </div>
        @endunless

        <div class="mt-3">
            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Delete this inquiry?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-trash"></i> Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection