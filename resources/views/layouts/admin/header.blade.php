<header class="top-header">
    <nav class="navbar navbar-expand">
        <div class="mobile-toggle-icon d-xl-none">
            <i class="bi bi-list"></i>
        </div>
        <div class="top-navbar-right ms-3 ms-auto">
            <ul class="navbar-nav align-items-center">
                
               
                <li class="nav-item">
                    <a id="darkModeButton" class="nav-link" href="javascript:void(0);">
                        <div class="user-setting d-flex align-items-center gap-1">
                            <img id="moonIcon" src="{{ asset('default/moon_light.png') }}" class="user-img" alt="Theme">
                            <div class="user-name d-none d-sm-block">Light</div>
                        </div>
                    </a>
                </li>

            
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}" target="_blank">
                        <div class="user-setting d-flex align-items-center gap-1">
                            <img src="{{ asset('default/website.png') }}" class="user-img" alt="Website">
                            <div class="user-name d-none d-sm-block">View Website</div>
                        </div>
                    </a>
                </li>


                <li class="nav-item dropdown dropdown-large">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center gap-1">
                            <i class="bi bi-bell fs-4"></i>
                            @php
                                $unreadNotifications = \App\Models\Notification::where('admin_id', auth('admin')->id())
                                    ->whereNull('read_at')
                                    ->count();
                            @endphp
                            @if($unreadNotifications > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;margin-top: 15px;">
                                    {{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}
                                </span>
                            @endif
                        </div>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end" style="width: 380px;">
                        <li>
                            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Notifications</h6>
                                @if($unreadNotifications > 0)
                                    <span class="badge bg-primary rounded-pill">{{ $unreadNotifications }} New</span>
                                @endif
                            </div>
                        </li>
                        
                        
                        <li>
                            <div style="max-height: 350px; overflow-y: auto;">
                                @php
                                    $recentNotifications = \App\Models\Notification::where('admin_id', auth('admin')->id())
                                        ->latest()
                                        ->take(5)
                                        ->get();
                                @endphp
                                
                                @forelse($recentNotifications as $notification)
                                    <a href="javascript:void(0);" class="dropdown-item notification-item {{ $notification->isUnread() ? 'unread' : '' }}" data-id="{{ $notification->id }}">
                                        <div class="d-flex align-items-start">
                                            <div class="me-2">
                                                @if($notification->type === 'welcome')
                                                    <i class="bi bi-person-check-fill text-success fs-5"></i>
                                                @elseif($notification->type === 'login_alert')
                                                    <i class="bi bi-shield-exclamation text-warning fs-5"></i>
                                                @elseif($notification->type === 'password_changed')
                                                    <i class="bi bi-key-fill text-info fs-5"></i>
                                                @elseif($notification->type === 'password_reset')
                                                    <i class="bi bi-lock-fill text-primary fs-5"></i>
                                                @elseif($notification->type === 'account_status')
                                                    <i class="bi bi-person-gear text-secondary fs-5"></i>
                                                @else
                                                    <i class="bi bi-bell-fill text-muted fs-5"></i>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h6 class="mb-1 small">{{ $notification->title }}</h6>
                                                    @if($notification->isUnread())
                                                        <span class="badge bg-primary rounded-pill ms-2" style="font-size: 8px;">•</span>
                                                    @endif
                                                </div>
                                                <p class="mb-1 small text-muted">{{ Str::limit($notification->message, 60) }}</p>
                                                <small class="text-muted">
                                                    <i class="bi bi-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-center py-4">
                                        <i class="bi bi-bell-slash display-6 text-muted"></i>
                                        <p class="text-muted small mb-0 mt-2">No notifications yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </li>
                        
                     
                        <li>
                            <div class="p-2 border-top text-center">
                                <a href="{{ route('admin.notifications.index') }}" class="text-decoration-none small">
                                    <i class="bi bi-list-ul me-1"></i> View All Notifications
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>

         
                <li class="nav-item dropdown dropdown-large">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center gap-1">
                            <img src="{{ auth('admin')->user()->image_url }}" class="user-img" alt="User">
                            <div class="user-name d-none d-sm-block">{{ auth('admin')->user()->name }}</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <img src="{{ auth('admin')->user()->image_url }}" alt="Profile" class="rounded-circle" width="60" height="60">
                                    <div class="ms-3">
                                        <h6 class="mb-0">{{ auth('admin')->user()->name }}</h6>
                                        <small class="text-secondary">{{ auth('admin')->user()->role?->name }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('admin.profile.update') }}"><i class="bi bi-person-fill me-2"></i>Update Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.password.update') }}"><i class="bi bi-lock me-2"></i>Change Password</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-success">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
