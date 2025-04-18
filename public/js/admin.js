// public/js/admin.js

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const closeSidebar = document.getElementById('close-sidebar');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }
    
    if (closeSidebar) {
        closeSidebar.addEventListener('click', function() {
            sidebar.classList.remove('active');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnToggle = sidebarToggle && sidebarToggle.contains(event.target);
        
        if (window.innerWidth < 992 && !isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });
    
    // Tooltips initialization (if Bootstrap 5)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Function to get initials from a name
    window.getInitials = function(name) {
        return name
            .split(' ')
            .map(word => word[0])
            .join('')
            .toUpperCase();
    };
});

// AJAX setup for Laravel
// Add CSRF token to all AJAX requests
document.addEventListener('DOMContentLoaded', function() {
    // Get the CSRF token from the meta tag
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Set up AJAX requests
    const setUpAjax = function() {
        const xhr = new XMLHttpRequest();
        const originalOpen = xhr.open;
        
        xhr.open = function() {
            originalOpen.apply(this, arguments);
            this.setRequestHeader('X-CSRF-TOKEN', token);
        };
        
        return xhr;
    };
    
    // Override the XMLHttpRequest constructor
    const originalXHR = window.XMLHttpRequest;
    window.XMLHttpRequest = function() {
        return setUpAjax();
    };
});

// Flash message disappear after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alertMessages = document.querySelectorAll('.alert:not(.alert-permanent)');
    
    alertMessages.forEach(function(alert) {
        setTimeout(function() {
            alert.classList.add('fade');
            setTimeout(function() {
                alert.remove();
            }, 500);
        }, 5000);
    });
});

// Confirmation dialogs for dangerous actions
document.addEventListener('DOMContentLoaded', function() {
    const confirmForms = document.querySelectorAll('form[data-confirm]');
    
    confirmForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const message = this.getAttribute('data-confirm');
            
            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
        });
    });
});