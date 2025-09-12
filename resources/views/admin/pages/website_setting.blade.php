@extends('backend.global.master')

@section('title', 'Settings')
@section('heading', 'Website Settings')


@section('backend_custom_style')
@endsection


@section('backend_content')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-wrench me-1"></i>
            Wedsite Settings
        </div>
        <form action="{{ route('storeWebsiteSettings') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <div class="mb-3">
                        <label for="website_name" class="form-label">Website Name</label>
                        <input type="text" class="form-control" name="website_name" id="website_name"
                            value="{{ $setting->website_name }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="mb-3">
                        <label for="website_short_name" class="form-label">Website Short Name</label>
                        <input type="text" class="form-control" name="website_short_name" id="website_short_name"
                            value="{{ $setting->website_short_name }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="mb-3">
                        <label for="website_url" class="form-label">Website URL</label>
                        <input type="text" class="form-control" name="website_url" id="website_url"
                            value="{{ $setting->website_url }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="mb-3">
                        <label for="website_email" class="form-label">Official Email</label>
                        <input type="email" class="form-control" name="website_email" id="website_email"
                            value="{{ $setting->website_email }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="mb-3">
                        <label for="website_contact" class="form-label">Website Contact</label>
                        <input type="text" class="form-control" name="website_contact" id="website_contact"
                            value="{{ $setting->website_contact }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="mb-3">
                        <label for="website_address" class="form-label">Website Address</label>
                        <input type="text" class="form-control" name="website_address" id="website_address"
                            value="{{ $setting->website_address }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="mb-3">
                        <label for="website_copy_right_text" class="form-label">Copyright Text</label>
                        <textarea type="text" class="form-control" name="website_copy_right_text" id="website_copy_right_text" cols="50"
                            rows="4">{{ $setting->website_copy_right_text }}</textarea>
                    </div>
                </div>

                <div class="form-group d-flex">
                    <div class="mt-4 mb-3">
                        <label for="phone" class="form-label">Official Logo</label>
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <input type="file" name="website_logo" id="website_logo"
                                    accept="image/png, image/jpeg, image/jpg" />
                            </div>
                        </div>
                    </div>
                    @if (isset($setting->website_logo))
                        <div style="width:350px; margin-top:30px">
                            @php
                                $imagePath = \App\UtilityFunction::globalImagePath('website', $setting->website_logo);
                            @endphp
                            <img src="{{ $imagePath }}" alt="image not found" class="img-fluid">
                        </div>
                    @endif
                </div>
                <div class="form-group d-flex">
                    <div class="mt-4 mb-3">
                        <label for="phone" class="form-label">Official Favicon</label>
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <input type="file" name="website_favicon" id="website_favicon"
                                    accept="image/png, image/jpeg, image/jpg" />
                            </div>
                        </div>
                    </div>
                    @if (isset($setting->website_favicon))
                        <div style="width:350px; margin-top:30px">
                            @php
                                $imagePath = \App\UtilityFunction::globalImagePath(
                                    'website',
                                    $setting->website_favicon,
                                );
                            @endphp
                            <img src="{{ $imagePath }}" alt="image not found" class="img-fluid">
                        </div>
                    @endif
                </div>

                <!-- IP and User Restriction Section -->
                <div class="form-group mt-4">
                    <h5 class="text-primary mb-3">
                        <i class="fas fa-shield-alt me-2"></i>
                        Access Control Settings
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="allowed_ips" class="form-label">Allowed IP Addresses</label>
                                <select class="form-control select2" name="allowed_ips[]" id="allowed_ips" multiple>
                                    @php
                                        $allowedIps = $setting->allowed_ips ? explode(',', $setting->allowed_ips) : [];
                                    @endphp
                                    @foreach ($allowedIps as $ip)
                                        <option value="{{ trim($ip) }}" selected>{{ trim($ip) }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Enter IP addresses (one per line or comma separated).
                                    Leave empty to allow all IPs.</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="allowed_users" class="form-label">Allowed Users (Bypass IP Check)</label>
                                <select class="form-control select2" name="allowed_users[]" id="allowed_users" multiple>
                                    @php
                                        $allowedUsers = $setting->allowed_users
                                            ? explode(',', $setting->allowed_users)
                                            : [];
                                        $users = \App\Models\User::select('id', 'name', 'email')->get();
                                    @endphp
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ in_array($user->id, $allowedUsers) ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Selected users can login from any IP address.</small>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>How it works:</strong>
                        <ul class="mb-0 mt-2">
                            <li>If no IPs are specified, all IPs are allowed</li>
                            <li>If IPs are specified, only those IPs can access the system</li>
                            <li>Users in the "Allowed Users" list can login from any IP address</li>
                            <li>IP restrictions are checked first, then user exceptions are applied</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success text-center">Update</button>
            </div>
        </form>
    </div>
@endsection

@section('backend_custom_js')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for IP addresses
            $('#allowed_ips').select2({
                tags: true,
                placeholder: 'Enter IP addresses',
                allowClear: true,
                width: '100%',
                tokenSeparators: [',', ' '],
                createTag: function(params) {
                    var term = $.trim(params.term);

                    // Validate IP address format
                    var ipRegex =
                        /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
                    var cidrRegex =
                        /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\/([0-9]|[1-2][0-9]|3[0-2])$/;

                    if (term === '') {
                        return null;
                    }

                    if (ipRegex.test(term) || cidrRegex.test(term)) {
                        return {
                            id: term,
                            text: term,
                            newTag: true
                        };
                    }

                    return null;
                }
            });

            // Initialize Select2 for allowed users
            $('#allowed_users').select2({
                placeholder: 'Select users who can bypass IP restrictions',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
