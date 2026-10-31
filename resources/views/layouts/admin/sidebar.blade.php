<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ setting('logo_url') }}" class="logo-icon" alt="{{ config('app.name') }} Logo">
        </div>
        <div>
            <h4 class="logo-text">SP DASH</h4>
        </div>
        <div class="toggle-icon ms-auto">
            <i class="bi bi-chevron-double-left"></i>
        </div>
    </div>

    <ul class="metismenu" id="menu">
     
      
        <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class="bi bi-grid-1x2-fill"></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>



      
        <li class="menu-label">Manage Bookings</li>
        <li class="{{ request()->routeIs('admin.bookings.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.bookings.index') }}">
                <div class="parent-icon"><i class="bi bi-cart-check-fill"></i></div>
                <div class="menu-title">
                    Bookings
                    @php
                        $pendingBookings = \App\Models\Booking::where('status', 'pending')->count();
                    @endphp
                    @if($pendingBookings > 0)
                        <span class="badge bg-danger rounded-pill ms-auto">{{ $pendingBookings }}</span>
                    @endif
                </div>
            </a>
        </li>


  
        @canany(['category.read', 'package.read'])
            <li class="menu-label">Tour & Travel</li>
            <li class="{{ request()->routeIs(['admin.category.*', 'admin.package.*', 'admin.fix-depature-package', 'admin.package.prices']) ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi bi-globe-americas"></i></div>
                    <div class="menu-title">Trip Manager</div>
                </a>
                <ul>
                    @can('category.read')
                    <li class="{{ request()->routeIs('admin.category.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.category.index') }}"><i class="bi bi-tags"></i> Categories</a>
                    </li>
                    @endcan

                    @can('package.read')
                    <li class="{{ request()->routeIs('admin.package.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.package.index') }}"><i class="bi bi-suitcase-lg"></i> Trip Packages</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.fix-depature-package') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.fix-depature-package') }}"><i class="bi bi-calendar-event"></i> Fixed Departures</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.package.prices') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.package.prices') }}"><i class="bi bi-currency-dollar"></i> Trip Pricing</a>
                    </li>
                    @endcan
                </ul>
            </li>
        @endcanany

  
        @canany(['page.read', 'blog.read'])
            <li class="menu-label">Content Management</li>
            <li class="{{ request()->routeIs(['admin.page.*', 'admin.blogs.*', 'admin.media.*']) ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi bi-file-earmark-richtext"></i></div>
                    <div class="menu-title">Content</div>
                </a>
                <ul>
                    @can('page.read')
                    <li class="{{ request()->routeIs('admin.page.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.page.index') }}"><i class="bi bi-file-earmark-text"></i> Pages</a>
                    </li>
                    @endcan

                    @can('blog.read')
                    <li class="{{ request()->routeIs('admin.blogs.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.blogs.index') }}"><i class="bi bi-newspaper"></i> Blog Posts</a>
                    </li>
                    @endcan
                    
               
                    <li class="{{ request()->routeIs('admin.media.*') ? 'mm-active' : '' }}">
                        <a href="#"><i class="bi bi-folder2-open"></i> Media Library <span class="badge bg-warning text-dark ms-1" style="font-size: 10px;">Soon</span></a>
                    </li>
                </ul>
            </li>
        @endcanany

     
        @canany(['subscriber.read'])
            <li class="menu-label">Marketing</li>
            <li class="{{ request()->routeIs(['admin.subscribers.*', 'admin.email-templates.*','admin.coupons.*']) ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi bi-megaphone"></i></div>
                    <div class="menu-title">Marketing</div>
                </a>
                <ul>
                    <li class="{{ request()->routeIs('admin.subscribers.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.subscribers.index') }}"><i class="bi bi-envelope"></i> Subscribers</a>
                    </li>


                    <li class="{{ request()->routeIs('admin.coupons.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.coupons.index') }}">
                            <i class="bi bi-ticket-perforated"></i> Coupons Code
                        </a>
                    </li>

             
                </ul>
            </li>
        @endcanany

       
        @canany(['banner.read', 'faq.read', 'review.read', 'gallery.read', 'team.read'])
            <li class="menu-label">Site Elements</li>
            <li class="{{ request()->routeIs(['admin.banner.*', 'admin.faq.*', 'admin.review.*', 'admin.gallery.*', 'admin.team.*']) ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                    <div class="menu-title">Site Elements</div>
                </a>
                <ul>
                    @can('banner.read')
                    <li class="{{ request()->routeIs('admin.banner.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.banner.index') }}"><i class="bi bi-card-image"></i> Banners</a>
                    </li>
                    @endcan

                    @can('faq.read')
                    <li class="{{ request()->routeIs('admin.faq.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.faq.index') }}"><i class="bi bi-question-circle"></i> FAQs</a>
                    </li>
                    @endcan

                    @can('review.read')
                    <li class="{{ request()->routeIs('admin.review.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.review.index') }}"><i class="bi bi-star-half"></i> Reviews</a>
                    </li>
                    @endcan

                    @can('gallery.read')
                    <li class="{{ request()->routeIs('admin.gallery.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.gallery.index') }}"><i class="bi bi-images"></i> Gallery</a>
                    </li>
                    @endcan

                    @can('team.read')
                    <li class="{{ request()->routeIs('admin.team.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.team.index') }}"><i class="bi bi-people"></i> Team Members</a>
                    </li>
                    @endcan
                </ul>
            </li>
        @endcanany


      
        @canany(['user.read', 'permission.read'])
            <li class="menu-label">Administration</li>
            <li class="{{ request()->routeIs(['admin.user.*', 'admin.permission.*', 'admin.audit-logs.*','admin.login-activities.*',]) ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi bi-shield-lock"></i></div>
                    <div class="menu-title">Administration</div>
                </a>
                <ul>
                    @can('user.read')
                    <li class="{{ request()->routeIs('admin.user.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.user.index') }}"><i class="bi bi-person-vcard-fill"></i> Admin Users</a>
                    </li>
                    @endcan

                    @can('permission.read')
                    <li class="{{ request()->routeIs('admin.permission.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.permission.index') }}"><i class="bi bi-key"></i> Roles & Permissions</a>
                    </li>
                    @endcan


                      <li class="{{ request()->routeIs('admin.login-activities.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.login-activities.index') }}"><i class="bi bi-clock-history"></i> Login Activities</a>
                    </li>
                    
             
                </ul>
            </li>
        @endcanany

     
        @canany(['setting.read'])
            <li class="menu-label">System</li>
            <li class="{{ request()->routeIs(['admin.settings.*', 'admin.site.health', 'admin.backups.*', 'admin.notifications.*']) ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi bi-gear-fill"></i></div>
                    <div class="menu-title">System</div>
                </a>
                <ul>
                    <li class="{{ request()->routeIs('admin.settings.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.settings.index') }}"><i class="bi bi-sliders2"></i> General Settings</a>
                    </li>

                    <li class="{{ request()->routeIs('admin.site.health') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.site.health') }}"><i class="bi bi-heart-pulse"></i> System Health</a>
                    </li>

                  

                    <li class="{{ request()->routeIs('admin.backups.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.backups.index') }}"><i class="bi bi-database"></i> Database Backups</a>
                    </li>

                    <li class="{{ request()->routeIs('admin.notifications.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.notifications.index') }}">
                            <i class="bi bi-bell"></i> Notifications
                            @php
                                $unreadCount = \App\Models\Notification::where('admin_id', auth('admin')->id())
                                    ->whereNull('read_at')
                                    ->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="badge bg-danger rounded-pill ms-auto">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
        @endcanany

    </ul>
</aside>