<div class="left-side-bar">
    {{-- menu starts --}}
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                {{-- Dashoboard --}}
                <li class="mt-2">
                    <a href="{{ route('home') }}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-home"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>
                {{-- super-admin --}}
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-settings2"></span><span class="mtext">Settings</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('user-profile.index') }}"
                                class="{{ Request::routeIs('user-profile.*') ? 'active' : '' }}">Users</a>
                        </li>
                        <li>
                            <a href="{{ route('permission.index') }}"
                                class="{{ Request::routeIs('permission.*') ? 'active' : '' }}">Access Control List</a>
                        </li>
                        <li>
                            <a href="{{ route('audit.index') }}"
                                class="{{ Request::routeIs('audit.*') ? 'active' : '' }}">Check Audtis</a>
                        </li>
                        <li>
                            <a href="{{ route('voucher.manage.index') }}"
                                class="{{ Request::routeIs('voucher.manage.*') ? 'active' : '' }}">Voucher
                                Management</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('ledger-head.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-list"></span><span class="mtext">Ledger Heads</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
            </ul>
        </div>
    </div>
    {{-- menu ends --}}
</div>
<div class="mobile-menu-overlay"></div>
