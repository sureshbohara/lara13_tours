<div class="tab-content h-100">
    {{-- General Tab --}}
    <div class="tab-pane fade show active" id="general">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">General Information</h6>
            <p class="text-muted small mb-0">Update basic contact details (Shows on Contact Us Page & Footer).</p>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">System Name</label>
                <input type="text" name="system_name" class="form-control @error('system_name') is-invalid @enderror"
                       value="{{ old('system_name', setting('system_name', config('app.name'))) }}"
                       placeholder="e.g., Ez Property">
                @error('system_name') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Primary Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', setting('email', '')) }}"
                       placeholder="support@ezproperty.com">
                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Secondary Email</label>
                <input type="email" name="extra_email" class="form-control"
                       value="{{ old('extra_email', setting('extra_email', '')) }}"
                       placeholder="booking@ezproperty.com">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Primary Phone</label>
                <input type="text" name="phone" class="form-control"
                       value="{{ old('phone', setting('phone', '')) }}"
                       placeholder="+977-1-XXXXXXX">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Secondary Phone</label>
                <input type="text" name="extra_phone" class="form-control"
                       value="{{ old('extra_phone', setting('extra_phone', '')) }}"
                       placeholder="+977-98XXXXXXXX">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Address</label>
                <input type="text" name="address" class="form-control"
                       value="{{ old('address', setting('address', '')) }}"
                       placeholder="Kathmandu, Nepal">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Opening Hours</label>
                <input type="text" name="opening_hr" class="form-control"
                       value="{{ old('opening_hr', setting('opening_hr', '')) }}"
                       placeholder="e.g., Sun - Fri: 9AM - 6PM">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Work Hours / Office Hours</label>
                <input type="text" name="work_hours" class="form-control"
                       value="{{ old('work_hours', setting('work_hours', '')) }}"
                       placeholder="e.g., 24/7 Support Available">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Google Map Embed Link</label>
                <input type="url" name="google_map" class="form-control"
                       value="{{ old('google_map', setting('google_map', '')) }}"
                       placeholder="Paste your Google Maps iframe embed URL here">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Copyright Text</label>
                <input type="text" name="footer_copyright" class="form-control"
                       value="{{ old('footer_copyright', setting('footer_copyright', '')) }}"
                       placeholder="© 2024 Ez Property. All rights reserved.">
            </div>
        </div>
    </div>

    {{-- Media Tab --}}
    <div class="tab-pane fade" id="media">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Media Management</h6>
            <p class="text-muted small mb-0">Upload images for your site layout.</p>
        </div>
        <div class="row g-4">
            @php
                $mediaFields = [
                    'logo' => ['label' => 'Website Logo', 'hint' => 'PNG/JPG. Recommended: 200x60px'],
                    'favicon' => ['label' => 'Favicon', 'hint' => 'ICO/PNG. Recommended: 32x32px'],
                    'bg_image' => ['label' => 'Section Background', 'hint' => 'Background image for Home Page'],
                    'image1' => ['label' => 'About Us Hero Image', 'hint' => 'Main image for the About Us page'],
                    'footer_gateway_img' => ['label' => 'Payment Gateway Image', 'hint' => 'Image for payment methods in footer'],
                    'image2' => ['label' => 'Footer Logo', 'hint' => 'Alternative logo for the footer'],
                    'breadcrumb' => ['label' => 'Breadcrumb Background (Desktop)', 'hint' => 'Wide background image for desktop breadcrumbs'],
                    'loader' => ['label' => 'Breadcrumb Background (Mobile)', 'hint' => 'Vertical background image for mobile breadcrumbs']
                ];
            @endphp
            @foreach($mediaFields as $field => $config)
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-uppercase text-muted">{{ $config['label'] }}</label>
                    <small class="text-muted d-block mb-2">{{ $config['hint'] }}</small>
                    <input type="file" name="{{ $field }}" class="form-control mb-2" onchange="previewImage(this, 'prev-{{ $field }}')">
                    <div class="border rounded p-2 text-center bg-light d-flex align-items-center justify-content-center" style="min-height: 100px;">
                        @php
                            $imagePath = old($field, setting($field, null));
                            $imageUrl = $imagePath && is_string($imagePath)
                                ? (filter_var($imagePath, FILTER_VALIDATE_URL) ? $imagePath : asset('images/' . $imagePath))
                                : asset('default/noimage.png');
                        @endphp
                       <img src="{{ $imageUrl }}" id="prev-{{ $field }}" class="img-fluid mh-100" style="max-height: 100px; object-fit: contain;" alt="{{ $config['label'] }}">
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <div class="tab-pane fade" id="smtp">
        <div class="card shadow-sm border-0 bg-light mb-4">
            <div class="card-body">
                <h5 class="mb-4">📧 SMTP Configuration Guidelines</h5>
                <div class="alert alert-warning">
                    <strong>⚠️ Warning:</strong> Incorrect settings may prevent emails from being sent.
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">🔒 Non-SSL (TLS)</h6>
                        <ul class="list-group mb-3">
                            <li class="list-group-item">Port: <strong>587</strong>, Encryption: <strong>tls</strong></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">🛡️ SSL</h6>
                        <ul class="list-group mb-3">
                            <li class="list-group-item">Port: <strong>465</strong>, Encryption: <strong>ssl</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Mail Configuration</h6>
        </div>
        <div class="row g-3 shadow-sm border-0 bg-light p-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Mail Transport</label>
                <input type="text" name="mail_transport" class="form-control" value="{{ old('mail_transport', setting('mail_transport', 'smtp')) }}" placeholder="e.g., smtp">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">SMTP Host</label>
                <input type="text" name="mail_host" class="form-control" value="{{ old('mail_host', setting('mail_host', '')) }}" placeholder="e.g., smtp.gmail.com">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Port</label>
                <input type="number" name="mail_port" class="form-control" value="{{ old('mail_port', setting('mail_port', '587')) }}" placeholder="587">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" name="mail_username" class="form-control" value="{{ old('mail_username', setting('mail_username', '')) }}" placeholder="your-email@gmail.com">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Password</label>
                <input type="text" name="mail_password" class="form-control" value="{{ old('mail_password', setting('mail_password', '')) }}" placeholder="Your email password or app password">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Encryption</label>
                <input type="text" name="mail_encryption" class="form-control" value="{{ old('mail_encryption', setting('mail_encryption', 'tls')) }}" placeholder="tls or ssl">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">From Email</label>
                <input type="email" name="mail_from" class="form-control" value="{{ old('mail_from', setting('mail_from', '')) }}" placeholder="noreply@ezproperty.com">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">From Name</label>
                <input type="text" name="mail_from_name" class="form-control" value="{{ old('mail_from_name', setting('mail_from_name', '')) }}" placeholder="Ez Property System">
            </div>
            <div class="col-12 mt-2">
                <div class="form-check form-switch ps-0">
                    <input class="form-check-input ms-0" type="checkbox" name="smtp_check" value="1" {{ old('smtp_check', setting('smtp_check', false)) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2 fw-bold">Enable SMTP</label>
                </div>
            </div>
        </div>
    </div>

    {{-- Social Tab --}}
    <div class="tab-pane fade" id="social">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Social Links</h6>
            <p class="text-muted small mb-0">Used in the footer and contact pages.</p>
        </div>
        <div class="row g-3">
            @php
                $socialFields = [
                    'facebook' => 'Facebook URL',
                    'twitter' => 'Twitter/X URL',
                    'linkedin' => 'LinkedIn URL',
                    'instagram' => 'Instagram URL',
                    'youtube' => 'YouTube URL',
                    'google' => 'Google URL',
                    'yelp' => 'Yelp URL',
                ];
            @endphp
            @foreach($socialFields as $field => $label)
                <div class="col-12">
                    <label class="form-label fw-semibold">{{ $label }}</label>
                    <input type="url" name="{{ $field }}" class="form-control"
                           value="{{ old($field, setting($field, '')) }}"
                           placeholder="https://{{ $field }}.com/ezproperty">
                </div>
            @endforeach
        </div>
    </div>

    {{-- API Tab --}}
    <div class="tab-pane fade" id="api">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">API & Third Party</h6>
        </div>
        <div class="row g-3">
            <h6 class="col-12 text-dark fw-bold">Google</h6>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Analytics ID</label>
                <input type="text" name="google_analytic_id" class="form-control" value="{{ old('google_analytic_id', setting('google_analytic_id', '')) }}" placeholder="G-XXXXXXXXXX">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Login Client ID</label>
                <input type="text" name="google_client_id" class="form-control" value="{{ old('google_client_id', setting('google_client_id', '')) }}" placeholder="xxxx.apps.googleusercontent.com">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Login Secret</label>
                <input type="text" name="google_client_secret" class="form-control" value="{{ old('google_client_secret', setting('google_client_secret', '')) }}" placeholder="GOCSPX-xxxxxxxx">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Login Redirect URI</label>
                <input type="url" name="google_redirect" class="form-control" value="{{ old('google_redirect', setting('google_redirect', '')) }}" placeholder="https://yourdomain.com/auth/google/callback">
            </div>

            <h6 class="col-12 text-dark fw-bold mt-3">Facebook</h6>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Pixel ID</label>
                <input type="text" name="facebook_analytic_id" class="form-control" value="{{ old('facebook_analytic_id', setting('facebook_analytic_id', '')) }}" placeholder="123456789012345">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Login Client ID</label>
                <input type="text" name="facebook_client_id" class="form-control" value="{{ old('facebook_client_id', setting('facebook_client_id', '')) }}" placeholder="1234567890">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Login Secret</label>
                <input type="text" name="facebook_client_secret" class="form-control" value="{{ old('facebook_client_secret', setting('facebook_client_secret', '')) }}" placeholder="abcdef1234567890">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Login Redirect URI</label>
                <input type="url" name="facebook_redirect" class="form-control" value="{{ old('facebook_redirect', setting('facebook_redirect', '')) }}" placeholder="https://yourdomain.com/auth/facebook/callback">
            </div>

            <h6 class="col-12 text-dark fw-bold mt-3">Recaptcha</h6>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Site Key</label>
                <input type="text" name="recaptcha_site_key" class="form-control" value="{{ old('recaptcha_site_key', setting('recaptcha_site_key', '')) }}" placeholder="6Lc...">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Secret Key</label>
                <input type="text" name="recaptcha_secret_key" class="form-control" value="{{ old('recaptcha_secret_key', setting('recaptcha_secret_key', '')) }}" placeholder="6Lc...">
            </div>
            <div class="col-12 mt-2">
                <div class="form-check form-switch ps-0">
                    <input class="form-check-input ms-0" type="checkbox" name="is_recaptcha" value="1" {{ old('is_recaptcha', setting('is_recaptcha', false)) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2 fw-bold">Enable Recaptcha</label>
                </div>
            </div>
        </div>
    </div>



       
    <div class="tab-pane fade" id="livechat">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Live Chat Configuration</h6>
            <p class="text-muted small mb-0">Integrate real-time customer support chat on your website.</p>
        </div>

     
        <div class="card shadow-sm border-0 bg-light mb-4">
            <div class="card-body">
                <h5 class="mb-3">💬 Live Chat Setup Guide</h5>
                <div class="alert alert-info">
                    <strong>📌 How it works:</strong> We use <strong>Tawk.to</strong> (100% free, professional live chat) for real-time customer support. No server load, mobile app available, unlimited chat history.
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">🎯 Step 1: Create Account</h6>
                        <ol class="small">
                            <li>Go to <a href="https://www.tawk.to" target="_blank">tawk.to</a></li>
                            <li>Sign up with your email (Free forever)</li>
                            <li>Verify your email</li>
                            <li>Create your first property (website)</li>
                        </ol>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">📋 Step 2: Get Widget Code</h6>
                        <ol class="small">
                            <li>Dashboard मा <strong>Administration → Channels → Chat Widget</strong> मा जानुहोस्</li>
                            <li>Copy the <strong>Installation Code</strong></li>
                            <li>तलको textarea मा paste गर्नुहोस्</li>
                            <li>Enable गर्नुहोस् र Save गर्नुहोस्</li>
                        </ol>
                    </div>
                </div>

              
            </div>
        </div>

     
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-semibold">Chat Provider</label>
                <select name="live_chat_provider" class="form-select @error('live_chat_provider') is-invalid @enderror">
                    <option value="tawk" {{ old('live_chat_provider', setting('live_chat_provider', 'tawk')) == 'tawk' ? 'selected' : '' }}>Tawk.to (Recommended - Free)</option>
                    <option value="custom" {{ old('live_chat_provider', setting('live_chat_provider', 'tawk')) == 'custom' ? 'selected' : '' }}>Custom HTML/JS Code</option>
                </select>
                <small class="text-muted">Currently we support Tawk.to (free) and Custom code</small>
                @error('live_chat_provider') <span class="text-danger small d-block">{{ $message }}</span> @enderror
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Widget Installation Code <span class="text-danger">*</span></label>
                <textarea name="live_chat_code" class="form-control @error('live_chat_code') is-invalid @enderror" 
                          rows="10" placeholder="Paste your Tawk.to widget code here...">{{ old('live_chat_code', setting('live_chat_code', '')) }}</textarea>
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Paste the complete <code>&lt;script&gt;</code> code from Tawk.to dashboard.
                </small>
                @error('live_chat_code') <span class="text-danger small d-block">{{ $message }}</span> @enderror
            </div>

            <div class="col-12 mt-3">
                <div class="form-check form-switch ps-0">
                    <input class="form-check-input ms-0" type="checkbox" name="is_live_chat" value="1" 
                           {{ old('is_live_chat', setting('is_live_chat', false)) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2 fw-bold">Enable Live Chat on Website</label>
                </div>
                <small class="text-muted d-block mt-1">
                    <i class="bi bi-info-circle me-1"></i>
                    When enabled, the chat widget will appear on all frontend pages. Disable to hide temporarily.
                </small>
            </div>
        </div>
    </div>


    {{-- SEO Tab --}}
    <div class="tab-pane fade" id="seo">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Search Engine Optimization</h6>
            <p class="text-muted small mb-0">Used in browser tabs and Google search results.</p>
        </div>
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-semibold">Meta Author</label>
                <input type="text" name="meta_author" class="form-control" value="{{ old('meta_author', setting('meta_author', '')) }}" placeholder="Ez Property Team">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Meta Title</label>
                <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', setting('meta_title', '')) }}" placeholder="Ez Property | Find Premium Homestays & Rentals in Nepal">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Keywords</label>
                <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', setting('meta_keywords', '')) }}" placeholder="nepal property, homestay nepal, kathmandu apartment">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Meta Description</label>
                <textarea name="meta_description" class="form-control" rows="4" placeholder="Discover authentic Nepali hospitality with Ez Property...">{{ old('meta_description', setting('meta_description', '')) }}</textarea>
            </div>
        </div>
    </div>

    {{-- Information Tab --}}
    <div class="tab-pane fade" id="information">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Information Content</h6>
            <p class="text-muted small mb-0">Used specifically for the About Us page content.</p>
        </div>
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-semibold">About Us Info</label>
                <textarea name="info1" class="form-control editor" rows="3" placeholder="Write a compelling introduction for the About Us page header...">{{ old('info1', setting('info1', '')) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">About Us Mission</label>
                <textarea name="info2" class="form-control editor" rows="3" placeholder="Tell your company's mission...">{{ old('info2', setting('info2', '')) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">About Us Vision</label>
                <textarea name="info3" class="form-control" rows="3" placeholder="Tell your company's vision...">{{ old('info3', setting('info3', '')) }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">About Us Goal</label>
                <textarea name="info4" class="form-control" rows="3" placeholder="e.g., Verified & Trusted Properties">{{ old('info4', setting('info4', '')) }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Footer Info</label>
                <textarea name="info5" class="form-control" rows="3" placeholder="e.g., Secure Online Payments">{{ old('info5', setting('info5', '')) }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Other Info 6</label>
                <textarea name="info6" class="form-control" rows="3" placeholder="e.g., 24/7 Local Support">{{ old('info6', setting('info6', '')) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Other Info 7</label>
                <textarea name="info7" class="form-control" rows="3" placeholder="Additional information block...">{{ old('info7', setting('info7', '')) }}</textarea>
            </div>

        </div>
    </div>

    {{-- Process Tab --}}
    <div class="tab-pane fade" id="additional">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Process Information (Why Choose Us)</h6>
            <p class="text-muted small mb-0">Displayed on the Home Page (Trust Section) and About Page (Core Values).</p>
        </div>
        <div class="row g-4">
            <div class="col-md-12">
                <label class="form-label fw-bold">Section Main Title</label>
                <input type="text" name="process_title" class="form-control" value="{{ old('process_title', setting('process_title', '')) }}" placeholder="e.g., Why Choose Ez Property?">
            </div>
            <div class="col-md-12">
                <label class="form-label fw-bold">Section Sub Title</label>
                <textarea name="process_sub_title" class="form-control form-control-sm" rows="4" placeholder="e.g., Experience the best of Nepal with our trusted platform">{{ old('process_sub_title', setting('process_sub_title', '')) }}</textarea>
            </div>
            <div class="col-12">
                <h6 class="fw-bold text-dark mb-3">Feature Items</h6>
                <div class="item-container border rounded p-3 bg-light">
                    <div class="itemDisplay">
                        @php
                            $processItems = old('process_item', setting('process_item', []));
                            $processItems = is_array($processItems) ? $processItems : [];
                        @endphp
                        @foreach($processItems as $index => $item)
                            <div class="row item-row align-items-start mb-3 border-bottom pb-3">
                                <div class="col-md-6 mb-2">
                                    <label class="small text-muted">Icon Class (Font Awesome)</label>
                                    <input type="text" name="process_item[{{ $index }}][icon]" class="form-control form-control-sm" value="{{ e($item['icon'] ?? '') }}" placeholder="e.g., fa-solid fa-shield-halved">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="small text-muted">Title</label>
                                    <input type="text" name="process_item[{{ $index }}][title]" class="form-control form-control-sm" value="{{ e($item['title'] ?? '') }}" placeholder="e.g., Verified Listings">
                                </div>
                                <div class="col-md-10 mb-2">
                                    <label class="small text-muted">Content</label>
                                    <textarea name="process_item[{{ $index }}][content]" class="form-control form-control-sm" rows="2" placeholder="Briefly describe this feature...">{{ e($item['content'] ?? '') }}</textarea>
                                </div>
                                <div class="col-md-2 pt-4 text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-item-btn w-100"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary add-item-btn"><i class="bi bi-plus-circle"></i> Add New Feature</button>
            </div>
        </div>
    </div>

    {{-- Work Tab --}}
    <div class="tab-pane fade" id="work">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Work Information (Host Steps)</h6>
            <p class="text-muted small mb-0">Displayed on the "Become a Host" page under "How it works".</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">Section Main Title</label>
                <input type="text" name="work_title" class="form-control" value="{{ old('work_title', setting('work_title', '')) }}" placeholder="e.g., How it works">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Section Sub Title</label>
                <input type="text" name="work_sub_title" class="form-control" value="{{ old('work_sub_title', setting('work_sub_title', '')) }}" placeholder="e.g., Start earning in minutes">
            </div>
            <div class="col-12">
                <h6 class="fw-bold text-dark mb-3">Step Items</h6>
                <div class="item-container border rounded p-3 bg-light">
                    <div class="itemDisplay">
                        @php
                            $workItems = old('work_item', setting('work_item', []));
                            $workItems = is_array($workItems) ? $workItems : [];
                        @endphp
                        @foreach($workItems as $index => $item)
                            <div class="row item-row align-items-start mb-3 border-bottom pb-3">
                                <div class="col-md-6 mb-2">
                                    <label class="small text-muted">Icon Class (Font Awesome)</label>
                                    <input type="text" name="work_item[{{ $index }}][icon]" class="form-control form-control-sm" value="{{ e($item['icon'] ?? '') }}" placeholder="e.g., fa-solid fa-user-plus">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="small text-muted">Step Title</label>
                                    <input type="text" name="work_item[{{ $index }}][title]" class="form-control form-control-sm" value="{{ e($item['title'] ?? '') }}" placeholder="e.g., Upgrade Your Account">
                                </div>
                                <div class="col-md-10 mb-2">
                                    <label class="small text-muted">Step Content</label>
                                    <textarea name="work_item[{{ $index }}][content]" class="form-control form-control-sm" rows="2" placeholder="Describe this step...">{{ e($item['content'] ?? '') }}</textarea>
                                </div>
                                <div class="col-md-2 pt-4 text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-item-btn w-100"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary add-item-btn"><i class="bi bi-plus-circle"></i> Add New Step</button>
            </div>
        </div>
    </div>

    {{-- Counter Tab --}}
    <div class="tab-pane fade" id="counter">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Counter Information (Statistics)</h6>
            <p class="text-muted small mb-0">Displayed on the Home Page statistics section (e.g., 500+ Properties).</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">Section Main Title</label>
                <input type="text" name="counter_title" class="form-control" value="{{ old('counter_title', setting('counter_title', '')) }}" placeholder="e.g., Why Book With Us">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Section Sub Title</label>
                <input type="text" name="counter_sub_title" class="form-control" value="{{ old('counter_sub_title', setting('counter_sub_title', '')) }}" placeholder="e.g., Trusted by Travelers Across the Globe">
            </div>
            <div class="col-12">
                <h6 class="fw-bold text-dark mb-3">Counter Items</h6>
                <div class="item-container border rounded p-3 bg-light">
                    <div class="itemDisplay">
                        @php
                            $counterItems = old('counter_item', setting('counter_item', []));
                            $counterItems = is_array($counterItems) ? $counterItems : [];
                        @endphp
                        @foreach($counterItems as $index => $item)
                            <div class="row item-row align-items-start mb-3 border-bottom pb-3">
                                <div class="col-md-6 mb-2">
                                    <label class="small text-muted">Icon Class (Font Awesome)</label>
                                    <input type="text" name="counter_item[{{ $index }}][icon]" class="form-control form-control-sm" value="{{ e($item['icon'] ?? '') }}" placeholder="e.g., fa-solid fa-building">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="small text-muted">Number/Value</label>
                                    <input type="text" name="counter_item[{{ $index }}][title]" class="form-control form-control-sm" value="{{ e($item['title'] ?? '') }}" placeholder="e.g., 500+">
                                </div>
                                <div class="col-md-10 mb-2">
                                    <label class="small text-muted">Label</label>
                                    <textarea name="counter_item[{{ $index }}][content]" class="form-control form-control-sm" rows="2" placeholder="e.g., Properties Listed">{{ e($item['content'] ?? '') }}</textarea>
                                </div>
                                <div class="col-md-2 pt-4 text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-item-btn w-100"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary add-item-btn"><i class="bi bi-plus-circle"></i> Add New Counter</button>
            </div>
        </div>
    </div>
</div>