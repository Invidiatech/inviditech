<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
            <div class="search-bar flex-grow-1">
                <div class="position-relative search-bar-box">
                    <div class="revenue-section">
                        {{-- Revenue section content --}}
                    </div>
                </div>
            </div>
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item mobile-search-icon">
                        <a class="nav-link" href="#"> <i class='bx bx-search'></i></a>
                    </li>
                    
                    <!-- Real-time Notifications Dropdown -->
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="alert-count" id="notification-count" style="display: none;">0</span>
                            <i class='bx bx-bell'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end notification-dropdown">
                            <a href="javascript:;" onclick="markAllAsRead()">
                                <div class="msg-header">
                                    <p class="msg-header-title">Notifications</p>
                                    <p class="msg-header-clear ms-auto">Mark all as read</p>
                                </div>
                            </a>
                            <div class="header-notifications-list" id="notifications-list">
                                <!-- Dynamic notifications will be loaded here -->
                                <div class="text-center p-3" id="no-notifications">
                                    <p class="text-muted">No new notifications</p>
                                </div>
                            </div>
                            <a href="{{ route('doctor.orders.index') }}">
                                <div class="text-center msg-footer">View All Orders</div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            
            <!-- User dropdown remains the same -->
            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('assets/images/avatars/logo.png') }}" class="user-img" alt="user avatar">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{ Auth::guard('doctor')->user()->name ?? 'Doctor' }}</p>
                        <p class="designattion mb-0">{{ Auth::guard('doctor')->user()->specialization ?? 'Specialist' }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('doctor.profile.edit') }}"><i class="bx bx-user"></i><span>Profile</span></a></li>
                    <li>
                        <form method="POST" action="{{ route('doctor.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="bx bx-log-out-circle"></i><span>Logout</span></button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<!-- Include Pusher JS -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
// Debug: Check if Pusher is loaded
console.log('Pusher loaded:', typeof Pusher !== 'undefined');

// Initialize Pusher with debug enabled
const pusher = new Pusher('859724ea34c4d0841a2f', {
    cluster: 'ap2',
    encrypted: true,
    enabledTransports: ['ws', 'wss'],
    disabledTransports: [],
    forceTLS: true
});

// Debug connection events
pusher.connection.bind('connected', function() {
    console.log('✅ Pusher connected successfully');
});

pusher.connection.bind('disconnected', function() {
    console.log('❌ Pusher disconnected');
});

pusher.connection.bind('error', function(error) {
    console.error('❌ Pusher connection error:', error);
});

// Subscribe to the doctor notifications channel
console.log('📡 Subscribing to doctor-notifications channel...');
const channel = pusher.subscribe('doctor-notifications');

// Debug channel events
channel.bind('pusher:subscription_succeeded', function() {
    console.log('✅ Successfully subscribed to doctor-notifications channel');
});

channel.bind('pusher:subscription_error', function(error) {
    console.error('❌ Subscription error:', error);
});

// Variables to track notifications
let notificationCount = 0;
let notifications = [];

// DOM elements
const notificationCountElement = document.getElementById('notification-count');
const notificationsList = document.getElementById('notifications-list');
const noNotificationsElement = document.getElementById('no-notifications');

// Load initial notifications on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔄 Loading initial notifications...');
    loadNotifications();
});

// Listen for new order notifications
channel.bind('order.created', function(data) {
    console.log('🔔 New order notification received:', data);
    
    // Add to notifications array
    notifications.unshift(data);
    
    // Update notification count
    updateNotificationCount();
    
    // Update notifications list
    updateNotificationsList();
    
    // Show browser notification if permission granted
    showBrowserNotification(data);
    
    // Play notification sound (optional)
    playNotificationSound();
});

// Test function to simulate notification (for debugging)
function testNotification() {
    const testData = {
        id: Math.floor(Math.random() * 1000),
        order_id: Math.floor(Math.random() * 1000),
        customer_name: 'Test Customer',
        customer_email: 'test@test.com',
        total_amount: 99.99,
        status: 'pending',
        created_at: 'just now',
        message: 'Test notification',
        is_read: false
    };
    
    console.log('🧪 Testing notification:', testData);
    
    // Add to notifications array
    notifications.unshift(testData);
    
    // Update UI
    updateNotificationCount();
    updateNotificationsList();
    
    // Show browser notification
    showBrowserNotification(testData);
    
    // Play sound
    playNotificationSound();
}

// Function to load initial notifications
function loadNotifications() {
    fetch('{{ route("doctor.notifications.index") }}', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        console.log('📥 Notifications response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('📥 Notifications data received:', data);
        if (data.success) {
            notifications = data.notifications.map(notification => ({
                id: notification.id,
                order_id: notification.order.id,
                customer_name: notification.order.customer ? notification.order.customer.name : 'Guest Customer',
                total_amount: notification.order.total || 0,
                status: notification.order.status,
                created_at: formatTimeAgo(notification.created_at),
                message: `New consultation order from ${notification.order.customer ? notification.order.customer.name : 'Guest Customer'}`,
                is_read: notification.is_read
            }));
            
            console.log('📊 Loaded notifications:', notifications.length);
            updateNotificationCount();
            updateNotificationsList();
        }
    })
    .catch(error => {
        console.error('❌ Error loading notifications:', error);
    });
}

// Function to update notification count
function updateNotificationCount() {
    const unreadCount = notifications.filter(n => !n.is_read).length;
    console.log('🔢 Updating notification count:', unreadCount);
    
    notificationCountElement.textContent = unreadCount;
    notificationCountElement.style.display = unreadCount > 0 ? 'inline-flex' : 'none';
}

// Function to update notifications list
function updateNotificationsList() {
    console.log('📝 Updating notifications list, total:', notifications.length);
    
    if (notifications.length === 0) {
        noNotificationsElement.style.display = 'block';
        notificationsList.innerHTML = '';
        return;
    }
    
    noNotificationsElement.style.display = 'none';
    
    const notificationsHtml = notifications.slice(0, 10).map(notification => `
        <a class="dropdown-item notification-item ${!notification.is_read ? 'unread' : ''}" 
           href="javascript:void(0)" 
           onclick="handleNotificationClick(${notification.id})">
            <div class="d-flex align-items-center">
                <div class="notify bg-light-success text-success">
                    <i class="bx bx-cart-alt"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="msg-name">
                        New Order #${notification.order_id}
                        <span class="msg-time">${notification.created_at}</span>
                    </h6>
                    <p class="msg-info">
                        ${notification.customer_name} - £${parseFloat(notification.total_amount).toFixed(2)}
                    </p>
                </div>
            </div>
        </a>
    `).join('');
    
    notificationsList.innerHTML = notificationsHtml;
}

// Handle notification click
function handleNotificationClick(notificationId) {
    console.log('🖱️ Notification clicked:', notificationId);
    markAsRead(notificationId);
    // Navigate to orders page
    window.location.href = '{{ route("doctor.orders.index") }}';
}

// Function to mark notification as read
function markAsRead(notificationId) {
    console.log('✅ Marking notification as read:', notificationId);
    
    fetch('{{ route("doctor.notifications.mark-read") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            notification_id: notificationId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update local notification status
            const notification = notifications.find(n => n.id === notificationId);
            if (notification) {
                notification.is_read = true;
                updateNotificationCount();
                updateNotificationsList();
            }
        }
    })
    .catch(error => {
        console.error('❌ Error marking notification as read:', error);
    });
}

// Function to mark all notifications as read
function markAllAsRead() {
    console.log('✅ Marking all notifications as read');
    
    fetch('{{ route("doctor.notifications.mark-all-read") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update all notifications as read
            notifications.forEach(notification => {
                notification.is_read = true;
            });
            updateNotificationCount();
            updateNotificationsList();
        }
    })
    .catch(error => {
        console.error('❌ Error marking all notifications as read:', error);
    });
}

// Function to show browser notification
function showBrowserNotification(data) {
    if (Notification.permission === 'granted') {
        const notification = new Notification('New Order Received', {
            body: `${data.customer_name} placed an order for £${parseFloat(data.total_amount).toFixed(2)}`,
            icon: '{{ asset("assets/images/avatars/logo.png") }}',
            tag: 'order-' + data.order_id
        });
        
        // Auto close after 5 seconds
        setTimeout(() => notification.close(), 5000);
    } else if (Notification.permission !== 'denied') {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                showBrowserNotification(data);
            }
        });
    }
}

// Function to play notification sound
function playNotificationSound() {
    try {
        // Create a simple beep sound
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = 800;
        oscillator.type = 'sine';
        
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.5);
    } catch (e) {
        console.log('🔇 Audio play failed:', e);
    }
}

// Function to format time ago
function formatTimeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffInSeconds = Math.floor((now - date) / 1000);
    
    if (diffInSeconds < 60) {
        return diffInSeconds + ' sec ago';
    } else if (diffInSeconds < 3600) {
        return Math.floor(diffInSeconds / 60) + ' min ago';
    } else if (diffInSeconds < 86400) {
        return Math.floor(diffInSeconds / 3600) + ' hrs ago';
    } else {
        return Math.floor(diffInSeconds / 86400) + ' days ago';
    }
}

// Request notification permission on page load
if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
}

// Add test button to console for debugging
console.log('🧪 To test notifications manually, run: testNotification()');

// Debug info
console.log('🔧 Debug Info:');
console.log('- Pusher App Key:', '859724ea34c4d0841a2f');
console.log('- Pusher Cluster:', 'ap2');
console.log('- Channel:', 'doctor-notifications');
console.log('- Event:', 'order.created');
</script>

<style>
.alert-count {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    font-size: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    z-index: 1;
}

/* Fix notification dropdown width and scrolling */
.notification-dropdown {
    width: 350px !important;
    max-width: 350px !important;
    max-height: 400px;
    overflow: hidden;
}

.header-notifications-list {
    max-height: 300px;
    overflow-y: auto;
    overflow-x: hidden;
}

.notification-item {
    padding: 12px 16px;
    border-bottom: 1px solid #f0f0f0;
    white-space: normal;
    word-wrap: break-word;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-item.unread {
    background-color: #e8f4f8;
    border-left: 3px solid #007bff;
}

.notify {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    flex-shrink: 0;
}

.msg-name {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 4px;
    line-height: 1.3;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.msg-info {
    font-size: 12px;
    color: #6c757d;
    margin: 0;
    line-height: 1.3;
}

.msg-time {
    font-size: 10px;
    color: #999;
    white-space: nowrap;
    margin-left: 8px;
}

.msg-header {
    padding: 12px 16px;
    border-bottom: 1px solid #dee2e6;
    background-color: #f8f9fa;
}

.msg-header-title {
    font-size: 14px;
    font-weight: 600;
    margin: 0;
}

.msg-header-clear {
    font-size: 12px;
    color: #007bff;
    margin: 0;
    cursor: pointer;
}

.msg-footer {
    padding: 10px;
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
    font-size: 12px;
    font-weight: 500;
    color: #007bff;
}

/* Custom scrollbar for notifications */
.header-notifications-list::-webkit-scrollbar {
    width: 6px;
}

.header-notifications-list::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.header-notifications-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.header-notifications-list::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .notification-dropdown {
        width: 300px !important;
        max-width: 300px !important;
    }
}
</style>