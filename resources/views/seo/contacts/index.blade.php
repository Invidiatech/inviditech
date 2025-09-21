@extends('layouts.seo')
@section('seo-content')
<link rel="stylesheet" href="{{ asset('assets/css/backend/category.css') }}" />
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Contacts</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('seo.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact Messages</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bx bx-filter"></i> Filter
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('seo.contacts.index') }}">All Messages</a></li>
                    <li><a class="dropdown-item" href="{{ route('seo.contacts.index', ['status' => 'unread']) }}">Unread</a></li>
                    <li><a class="dropdown-item" href="{{ route('seo.contacts.index', ['status' => 'read']) }}">Read</a></li>
                    <li><a class="dropdown-item" href="{{ route('seo.contacts.index', ['status' => 'replied']) }}">Replied</a></li>
                    <li><a class="dropdown-item" href="{{ route('seo.contacts.index', ['status' => 'archived']) }}">Archived</a></li>
                </ul>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6">
            <div class="card radius-10 bg-gradient-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-white">Total Messages</p>
                            <h4 class="mb-0 text-white">{{ $statusCounts['total'] }}</h4>
                        </div>
                        <div class="ms-auto text-white">
                            <i class="bx bx-envelope fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card radius-10 bg-gradient-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-dark">Unread</p>
                            <h4 class="mb-0 text-dark">{{ $statusCounts['unread'] }}</h4>
                        </div>
                        <div class="ms-auto text-dark">
                            <i class="bx bx-envelope-open fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card radius-10 bg-gradient-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-white">Replied</p>
                            <h4 class="mb-0 text-white">{{ $statusCounts['replied'] }}</h4>
                        </div>
                        <div class="ms-auto text-white">
                            <i class="bx bx-check-circle fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card radius-10 bg-gradient-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-white">Archived</p>
                            <h4 class="mb-0 text-white">{{ $statusCounts['archived'] }}</h4>
                        </div>
                        <div class="ms-auto text-white">
                            <i class="bx bx-archive fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="card-title mb-0">Contact Messages</h5>
                <div class="badge bg-primary">{{ $contacts->total() }} Total</div>
            </div>
            
            <!-- Search and Bulk Actions -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('seo.contacts.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search contacts..." value="{{ request('search') }}">
                            <input type="hidden" name="status" value="{{ request('status') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bx bx-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form id="bulkActionForm" method="POST" action="{{ route('seo.contacts.bulk-action') }}">
                        @csrf
                        <div class="d-flex gap-2">
                            <select name="action" class="form-select" style="max-width: 200px;">
                                <option value="">Bulk Actions</option>
                                <option value="mark_read">Mark as Read</option>
                                <option value="mark_replied">Mark as Replied</option>
                                <option value="mark_archived">Mark as Archived</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                            <button type="submit" class="btn btn-secondary" onclick="return confirmBulkAction()">Apply</button>
                        </div>
                    </form>
                </div>
            </div>

            <hr>
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="contactsTable">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                            </th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                        <tr class="{{ $contact->status === 'unread' ? 'table-warning' : '' }}">
                            <td>
                                <input type="checkbox" name="contact_ids[]" value="{{ $contact->id }}" class="contact-checkbox">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $contact->name }}</h6>
                                        @if($contact->status === 'unread')
                                            <span class="badge bg-warning text-dark">New</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="mailto:{{ $contact->email }}" class="text-primary">{{ $contact->email }}</a>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $contact->subject }}</span>
                            </td>
                            <td>
                                <div style="max-width: 200px;">
                                    <p class="mb-0 text-truncate">{{ $contact->short_message }}</p>
                                </div>
                            </td>
                            <td>
                                <select class="form-select form-select-sm status-select" 
                                        data-contact-id="{{ $contact->id }}" 
                                        onchange="updateContactStatus({{ $contact->id }}, this.value)">
                                    <option value="unread" {{ $contact->status === 'unread' ? 'selected' : '' }}>Unread</option>
                                    <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Read</option>
                                    <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Replied</option>
                                    <option value="archived" {{ $contact->status === 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </td>
                            <td>
                                <div>
                                    <small class="text-muted">{{ $contact->formatted_date }}</small><br>
                                    <small class="text-muted">{{ $contact->time_ago }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle custom-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-custom">
                                        <li><a class="dropdown-item" href="{{ route('seo.contacts.show', $contact) }}"><i class="bx bx-show me-1"></i> View Details</a></li>
                                        <li><a class="dropdown-item" href="mailto:{{ $contact->email }}"><i class="bx bx-envelope me-1"></i> Send Email</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('seo.contacts.destroy', $contact) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this contact?')"
                                                  style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bx bx-envelope display-4 text-muted mb-2"></i>
                                    <p class="text-muted mb-2">No contact messages found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($contacts->hasPages())
            <div class="mt-3">
                {{ $contacts->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Include CSRF token for JavaScript -->
<meta name="csrf-token" content="{{ csrf_token() }}">

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
            body: JSON.stringify({
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                // Update row styling based on status
                const row = document.querySelector(`select[data-contact-id="${id}"]`).closest('tr');
                if (status === 'unread') {
                    row.classList.add('table-warning');
                } else {
                    row.classList.remove('table-warning');
                }
            } else {
                showAlert('error', data.message || 'Failed to update status');
                // Revert the select if failed
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while updating status');
            location.reload();
        });
    }

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

    // Select all functionality
    function toggleSelectAll(checkbox) {
        const checkboxes = document.querySelectorAll('.contact-checkbox');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
    }

    // Bulk action confirmation
    function confirmBulkAction() {
        const selectedContacts = document.querySelectorAll('.contact-checkbox:checked');
        const action = document.querySelector('select[name="action"]').value;
        
        if (selectedContacts.length === 0) {
            alert('Please select at least one contact.');
            return false;
        }
        
        if (!action) {
            alert('Please select an action.');
            return false;
        }
        
        const actionTexts = {
            'mark_read': 'mark as read',
            'mark_replied': 'mark as replied',
            'mark_archived': 'archive',
            'delete': 'delete'
        };
        
        return confirm(`Are you sure you want to ${actionTexts[action]} ${selectedContacts.length} selected contact(s)?`);
    }

    // Add contact IDs to bulk action form
    document.getElementById('bulkActionForm').addEventListener('submit', function(e) {
        const selectedContacts = document.querySelectorAll('.contact-checkbox:checked');
        
        // Remove existing hidden inputs
        const existingInputs = this.querySelectorAll('input[name="contact_ids[]"]');
        existingInputs.forEach(input => input.remove());
        
        // Add selected contact IDs
        selectedContacts.forEach(checkbox => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'contact_ids[]';
            hiddenInput.value = checkbox.value;
            this.appendChild(hiddenInput);
        });
    });

    // Auto-hide success alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.remove();
            }, 5000);
        }
    });
</script>
@endsection