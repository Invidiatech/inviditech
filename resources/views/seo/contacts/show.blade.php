@extends('layouts.seo')
@section('seo-content')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Contact Details</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('seo.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('seo.contacts.index') }}">Contacts</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $contact->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('seo.contacts.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Back to Contacts
                </a>
                <a href="mailto:{{ $contact->email }}" class="btn btn-primary">
                    <i class="bx bx-envelope"></i> Reply via Email
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Contact Details -->
        <div class="col-lg-8">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Contact Message</h5>
                        <div class="contact-status">
                            <select class="form-select" onchange="updateContactStatus({{ $contact->id }}, this.value)">
                                <option value="unread" {{ $contact->status === 'unread' ? 'selected' : '' }}>Unread</option>
                                <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Read</option>
                                <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Replied</option>
                                <option value="archived" {{ $contact->status === 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="contact-header mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-circle me-3">
                                <span>{{ substr($contact->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h4 class="mb-1">{{ $contact->name }}</h4>
                                <p class="mb-0 text-muted">{{ $contact->email }}</p>
                            </div>
                        </div>
                        <div class="subject-line p-3 bg-light rounded">
                            <h6 class="mb-0">Subject: {{ $contact->subject }}</h6>
                        </div>
                    </div>

                    <div class="message-content">
                        <h6 class="mb-3">Message:</h6>
                        <div class="message-text p-3 border rounded">
                            {!! nl2br(e($contact->message)) !!}
                        </div>
                    </div>

                    <div class="message-meta mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="bx bx-time me-1"></i>
                                    Received: {{ $contact->formatted_date }}
                                </small>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted">
                                    <i class="bx bx-map me-1"></i>
                                    IP: {{ $contact->ip_address }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Notes -->
            <div class="card radius-10 mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Admin Notes</h6>
                </div>
                <div class="card-body">
                    <form id="notesForm">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control" id="admin_notes" name="admin_notes" rows="4" 
                                      placeholder="Add your private notes about this contact...">{{ $contact->admin_notes }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Save Notes
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Information Sidebar -->
        <div class="col-lg-4">
            <div class="card radius-10">
                <div class="card-header">
                    <h6 class="mb-0">Contact Information</h6>
                </div>
                <div class="card-body">
                    <div class="contact-info-item mb-3">
                        <label class="form-label text-muted">Name</label>
                        <p class="mb-0">{{ $contact->name }}</p>
                    </div>
                    <div class="contact-info-item mb-3">
                        <label class="form-label text-muted">Email</label>
                        <p class="mb-0">
                            <a href="mailto:{{ $contact->email }}" class="text-primary">
                                {{ $contact->email }}
                            </a>
                        </p>
                    </div>
                    <div class="contact-info-item mb-3">
                        <label class="form-label text-muted">Subject Category</label>
                        <p class="mb-0">
                            <span class="badge bg-info">{{ $contact->subject }}</span>
                        </p>
                    </div>
                    <div class="contact-info-item mb-3">
                        <label class="form-label text-muted">Status</label>
                        <p class="mb-0">{!! $contact->status_badge !!}</p>
                    </div>
                    <div class="contact-info-item mb-3">
                        <label class="form-label text-muted">Received</label>
                        <p class="mb-0">{{ $contact->formatted_date }}</p>
                        <small class="text-muted">{{ $contact->time_ago }}</small>
                    </div>
                    @if($contact->read_at)
                    <div class="contact-info-item mb-3">
                        <label class="form-label text-muted">Read At</label>
                        <p class="mb-0">{{ $contact->read_at->format('M d, Y H:i A') }}</p>
                    </div>
                    @endif
                    @if($contact->replied_at)
                    <div class="contact-info-item mb-3">
                        <label class="form-label text-muted">Replied At</label>
                        <p class="mb-0">{{ $contact->replied_at->format('M d, Y H:i A') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Technical Information -->
            <div class="card radius-10 mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Technical Details</h6>
                </div>
                <div class="card-body">
                    <div class="contact-info-item mb-3">
                        <label class="form-label text-muted">IP Address</label>
                        <p class="mb-0 font-monospace">{{ $contact->ip_address ?? 'N/A' }}</p>
                    </div>
                    <div class="contact-info-item mb-3">
                        <label class="form-label text-muted">User Agent</label>
                        <p class="mb-0 small text-break">{{ $contact->user_agent ?? 'N/A' }}</p>
                    </div>
                    <div class="contact-info-item">
                        <label class="form-label text-muted">Privacy Consent</label>
                        <p class="mb-0">
                            @if($contact->privacy)
                                <span class="badge bg-success">Agreed</span>
                            @else
                                <span class="badge bg-danger">Not Agreed</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card radius-10 mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-primary">
                            <i class="bx bx-envelope me-2"></i>Reply via Email
                        </a>
                        <button class="btn btn-success" onclick="markAsReplied({{ $contact->id }})">
                            <i class="bx bx-check me-2"></i>Mark as Replied
                        </button>
                        <button class="btn btn-secondary" onclick="markAsArchived({{ $contact->id }})">
                            <i class="bx bx-archive me-2"></i>Archive
                        </button>
                        <button class="btn btn-danger" onclick="deleteContact({{ $contact->id }})">
                            <i class="bx bx-trash me-2"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include CSRF token for JavaScript -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
.avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #044168, #00A9FF);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
}

.message-text {
    background-color: #f8f9fa;
    line-height: 1.6;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.contact-info-item label {
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.subject-line {
    border-left: 4px solid #044168;
}
</style>

<script>
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Function to update contact status via AJAX
    function updateContactStatus(id, status) {
        fetch(`/seo/contacts/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                // Reload page to update timestamps
                if (status === 'replied' || status === 'archived') {
                    setTimeout(() => location.reload(), 1000);
                }
            } else {
                showAlert('error', data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while updating status');
        });
    }

    // Quick action functions
    function markAsReplied(id) {
        if (confirm('Mark this contact as replied?')) {
            updateContactStatus(id, 'replied');
        }
    }

    function markAsArchived(id) {
        if (confirm('Archive this contact?')) {
            updateContactStatus(id, 'archived');
        }
    }

    function deleteContact(id) {
        if (confirm('Are you sure you want to delete this contact? This action cannot be undone.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/seo/contacts/${id}`;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            
            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Handle notes form submission
    document.getElementById('notesForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const notes = document.getElementById('admin_notes').value;
        
        fetch(`/seo/contacts/{{ $contact->id }}/notes`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ admin_notes: notes })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
            } else {
                showAlert('error', data.message || 'Failed to save notes');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while saving notes');
        });
    });

    // Function to show alert messages
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'bx-check-circle' : 'bx-error-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="bx ${iconClass} me-1"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Insert alert at the top of page content
        const pageContent = document.querySelector('.page-content');
        const breadcrumb = document.querySelector('.page-breadcrumb');
        breadcrumb.insertAdjacentHTML('afterend', alertHtml);
        
        // Auto-remove alert after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }
</script>
@endsection