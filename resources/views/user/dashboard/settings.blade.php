@extends('user.dashboard.layout')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-settings" type="button" role="tab" aria-controls="profile-settings" aria-selected="true">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="account-tab" data-bs-toggle="tab" data-bs-target="#account-settings" type="button" role="tab" aria-controls="account-settings" aria-selected="false">Account</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications-settings" type="button" role="tab" aria-controls="notifications-settings" aria-selected="false">Notifications</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="preferences-tab" data-bs-toggle="tab" data-bs-target="#preferences-settings" type="button" role="tab" aria-controls="preferences-settings" aria-selected="false">Preferences</button>
            </li>
        </ul>
        
        <div class="tab-content mt-4" id="settingsTabsContent">
            <!-- Profile Settings -->
            <div class="tab-pane fade show active" id="profile-settings" role="tabpanel" aria-labelledby="profile-tab">
                <div class="settings-section">
                    <h4 class="settings-section-title">Profile Information</h4>
                    <p class="text-muted">Update your profile information and how others see you on the platform.</p>
                    
                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <div class="profile-image-upload">
                                    <img id="profile-image-preview" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4299e1&color=fff" alt="Profile Image" class="profile-image mb-2">
                                    <div class="upload-btn-wrapper">
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-camera me-1"></i> Change
                                        </button>
                                        <input type="file" name="profile_image" id="profile-image-input" onchange="previewImage(this, document.getElementById('profile-image-preview'))">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text">@</span>
                                            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Tell us about yourself">{{ $user->bio ?? '' }}</textarea>
                                    <div class="form-text">Brief description for your profile. URLs are hyperlinked.</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Interests</label>
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Laravel" id="interest-laravel" name="interests[]" {{ in_array('Laravel', $user->interests ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="interest-laravel">Laravel</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="PHP" id="interest-php" name="interests[]" {{ in_array('PHP', $user->interests ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="interest-php">PHP</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="JavaScript" id="interest-js" name="interests[]" {{ in_array('JavaScript', $user->interests ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="interest-js">JavaScript</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Vue.js" id="interest-vue" name="interests[]" {{ in_array('Vue.js', $user->interests ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="interest-vue">Vue.js</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="React" id="interest-react" name="interests[]" {{ in_array('React', $user->interests ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="interest-react">React</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="NodeJS" id="interest-node" name="interests[]" {{ in_array('NodeJS', $user->interests ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="interest-node">Node.js</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="MySQL" id="interest-mysql" name="interests[]" {{ in_array('MySQL', $user->interests ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="interest-mysql">MySQL</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="DevOps" id="interest-devops" name="interests[]" {{ in_array('DevOps', $user->interests ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="interest-devops">DevOps</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" class="form-control" id="website" name="website" value="{{ $user->website ?? '' }}" placeholder="https://yourwebsite.com">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Social Profiles</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                <input type="text" class="form-control" id="twitter" name="social_links[twitter]" value="{{ isset($user->social_links) && isset($user->social_links['twitter']) ? $user->social_links['twitter'] : '' }}" placeholder="Twitter username">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"><i class="fab fa-github"></i></span>
                                <input type="text" class="form-control" id="github" name="social_links[github]" value="{{ isset($user->social_links) && isset($user->social_links['github']) ? $user->social_links['github'] : '' }}" placeholder="GitHub username">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text"><i class="fab fa-linkedin-in"></i></span>
                                <input type="text" class="form-control" id="linkedin" name="social_links[linkedin]" value="{{ isset($user->social_links) && isset($user->social_links['linkedin']) ? $user->social_links['linkedin'] : '' }}" placeholder="LinkedIn username">
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Account Settings -->
            <div class="tab-pane fade" id="account-settings" role="tabpanel" aria-labelledby="account-tab">
                <div class="settings-section">
                    <h4 class="settings-section-title">Account Settings</h4>
                    <p class="text-muted">Manage your account credentials and security.</p>
                    
                    <form action="{{ route('user.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password">
                                <button class="btn btn-outline-secondary" type="button" id="toggle-current-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password">
                                <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="form-text">Minimum 8 characters with a mix of letters, numbers & symbols.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                <button class="btn btn-outline-secondary" type="button" id="toggle-password-confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-lock me-1"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
                
                <hr class="my-4">
                
                <div class="settings-section">
                    <h4 class="settings-section-title">Account Management</h4>
                    <p class="text-muted">Manage your account data and account deletion.</p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5>Download Your Data</h5>
                            <p class="text-muted mb-0">Get a copy of your data including profile, comments, and activity.</p>
                        </div>
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-download me-1"></i> Download
                        </button>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="text-danger">Delete Account</h5>
                            <p class="text-muted mb-0">Permanently delete your account and all your data.</p>
                        </div>
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="fas fa-trash-alt me-1"></i> Delete Account
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Notifications Settings -->
            <div class="tab-pane fade" id="notifications-settings" role="tabpanel" aria-labelledby="notifications-tab">
                <div class="settings-section">
                    <h4 class="settings-section-title">Notification Preferences</h4>
                    <p class="text-muted">Manage how and when you receive notifications.</p>
                    
                    <form action="{{ route('user.notifications.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <h5>Email Notifications</h5>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="email_comments" name="notifications[email_comments]" {{ isset($user->notification_preferences) && isset($user->notification_preferences['email_comments']) && $user->notification_preferences['email_comments'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_comments">Comments on your activity</label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="email_follows" name="notifications[email_follows]" {{ isset($user->notification_preferences) && isset($user->notification_preferences['email_follows']) && $user->notification_preferences['email_follows'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_follows">New followers</label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="email_recommendations" name="notifications[email_recommendations]" {{ isset($user->notification_preferences) && isset($user->notification_preferences['email_recommendations']) && $user->notification_preferences['email_recommendations'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_recommendations">Article recommendations</label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="email_newsletter" name="notifications[email_newsletter]" {{ isset($user->notification_preferences) && isset($user->notification_preferences['email_newsletter']) && $user->notification_preferences['email_newsletter'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_newsletter">Weekly newsletter</label>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h5>Push Notifications</h5>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="push_comments" name="notifications[push_comments]" {{ isset($user->notification_preferences) && isset($user->notification_preferences['push_comments']) && $user->notification_preferences['push_comments'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="push_comments">Comments on your activity</label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="push_follows" name="notifications[push_follows]" {{ isset($user->notification_preferences) && isset($user->notification_preferences['push_follows']) && $user->notification_preferences['push_follows'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="push_follows">New followers</label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="push_recommendations" name="notifications[push_recommendations]" {{ isset($user->notification_preferences) && isset($user->notification_preferences['push_recommendations']) && $user->notification_preferences['push_recommendations'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="push_recommendations">Article recommendations</label>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Preferences
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Preferences Settings -->
            <div class="tab-pane fade" id="preferences-settings" role="tabpanel" aria-labelledby="preferences-tab">
                <div class="settings-section">
                    <h4 class="settings-section-title">Display Preferences</h4>
                    <p class="text-muted">Customize how content is displayed to you.</p>
                    
                    <form action="{{ route('user.preferences.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="theme" class="form-label">Theme</label>
                            <select class="form-select" id="theme" name="preferences[theme]">
                                <option value="light" {{ isset($user->display_preferences) && isset($user->display_preferences['theme']) && $user->display_preferences['theme'] === 'light' ? 'selected' : '' }}>Light</option>
                                <option value="dark" {{ isset($user->display_preferences) && isset($user->display_preferences['theme']) && $user->display_preferences['theme'] === 'dark' ? 'selected' : '' }}>Dark</option>
                                <option value="system" {{ isset($user->display_preferences) && isset($user->display_preferences['theme']) && $user->display_preferences['theme'] === 'system' ? 'selected' : '' }}>Use System Setting</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label d-block">Font Size</label>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="preferences[font_size]" id="font-small" value="small" {{ isset($user->display_preferences) && isset($user->display_preferences['font_size']) && $user->display_preferences['font_size'] === 'small' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="font-small">Small</label>
                                
                                <input type="radio" class="btn-check" name="preferences[font_size]" id="font-medium" value="medium" {{ !isset($user->display_preferences) || !isset($user->display_preferences['font_size']) || $user->display_preferences['font_size'] === 'medium' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="font-medium">Medium</label>
                                
                                <input type="radio" class="btn-check" name="preferences[font_size]" id="font-large" value="large" {{ isset($user->display_preferences) && isset($user->display_preferences['font_size']) && $user->display_preferences['font_size'] === 'large' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="font-large">Large</label>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="reduce_animations" name="preferences[reduce_animations]" {{ isset($user->display_preferences) && isset($user->display_preferences['reduce_animations']) && $user->display_preferences['reduce_animations'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="reduce_animations">Reduce animations</label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="compact_view" name="preferences[compact_view]" {{ isset($user->display_preferences) && isset($user->display_preferences['compact_view']) && $user->display_preferences['compact_view'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="compact_view">Compact view</label>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h5>Reading Preferences</h5>
                            
                            <div class="mb-3">
                                <label for="reading_layout" class="form-label">Reading Layout</label>
                                <select class="form-select" id="reading_layout" name="preferences[reading_layout]">
                                    <option value="standard" {{ !isset($user->display_preferences) || !isset($user->display_preferences['reading_layout']) || $user->display_preferences['reading_layout'] === 'standard' ? 'selected' : '' }}>Standard</option>
                                    <option value="focused" {{ isset($user->display_preferences) && isset($user->display_preferences['reading_layout']) && $user->display_preferences['reading_layout'] === 'focused' ? 'selected' : '' }}>Focused (hide sidebars)</option>
                                    <option value="comfortable" {{ isset($user->display_preferences) && isset($user->display_preferences['reading_layout']) && $user->display_preferences['reading_layout'] === 'comfortable' ? 'selected' : '' }}>Comfortable (wider spacing)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Preferences
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. All your data will be permanently deleted.
                </div>
                <p>Please type <strong>delete my account</strong> to confirm:</p>
                <input type="text" class="form-control" id="deleteConfirmation" placeholder="delete my account">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('user.account.delete') }}" method="POST" id="deleteAccountForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn" disabled>
                        <i class="fas fa-trash-alt me-1"></i> Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Profile image preview
        const profileImageInput = document.getElementById('profile-image-input');
        const profileImagePreview = document.getElementById('profile-image-preview');
        
        if (profileImageInput && profileImagePreview) {
            profileImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        profileImagePreview.src = e.target.result;
                    };
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
        // Password visibility toggles
        togglePasswordVisibility('current_password', 'toggle-current-password');
        togglePasswordVisibility('password', 'toggle-password');
        togglePasswordVisibility('password_confirmation', 'toggle-password-confirmation');
        
        // Delete account confirmation
        const deleteConfirmationInput = document.getElementById('deleteConfirmation');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        
        if (deleteConfirmationInput && confirmDeleteBtn) {
            deleteConfirmationInput.addEventListener('input', function() {
                confirmDeleteBtn.disabled = this.value !== 'delete my account';
            });
        }
    });
    
    // Toggle password visibility
    function togglePasswordVisibility(inputId, toggleBtnId) {
        const passwordInput = document.getElementById(inputId);
        const toggleBtn = document.getElementById(toggleBtnId);
        
        if (passwordInput && toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
    }
</script>
@endpush

@push('styles')
<style>
    .profile-image-upload {
        text-align: center;
    }
    
    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    
    .upload-btn-wrapper input[type=file] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
</style>
@endpush