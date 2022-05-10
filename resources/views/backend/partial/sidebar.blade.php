<div class="left-side-bar">
  {{-- menu starts --}}
  <div class="menu-block customscroll">
    <div class="sidebar-menu">
      <ul id="accordion-menu">
        {{-- Dashoboard --}}
        <li class="mt-2">
          <a href="{{ route('home') }}" class="dropdown-toggle no-arrow {{ Request::routeIs('home') ? 'active' : '' }}">
            <span class="micon dw dw-home"></span><span class="mtext">{{ auth()->user()->company_name }}</span>
          </a>
        </li>
        {{-- Divider --}}
        <li>
          <div class="dropdown-divider"></div>
        </li>
        {{-- super-admin --}}
        <li class="dropdown">
          <a href="javascript:;" class="dropdown-toggle">
            <span class="micon dw dw-settings2"></span><span class="mtext">Settings</span>
          </a>
          <ul class="submenu">
            <li>
              <a href="{{ route('user-profile.index') }}" class="{{ Request::routeIs('user-profile.*') ? 'active' : '' }}">Users</a>
            </li>
            <li>
              <a href="{{ route('permission.index') }}" class="{{ Request::routeIs('permission.*') ? 'active' : '' }}">Access Control List</a>
            </li>
            <li>
              <a href="{{ route('audit.index') }}" class="{{ Request::routeIs('audit.*') ? 'active' : '' }}">Check Audtis</a>
            </li>
            <li>
              <a href="{{ route('company.create') }}">Create New Company</a>
            </li>
          </ul>
        </li>
        {{-- Divider --}}
        <li>
          <div class="dropdown-divider"></div>
        </li>
        {{-- Accounting Functionalites Menu --}}
        {{-- 1. Masters --}}
        <li class="dropdown">
          <a href="javascript:;" class="dropdown-toggle">
            <span class="micon dw dw-analytics-19"></span><span class="mtext">Masters</span>
          </a>
          <ul class="submenu">
            <li>
              <a href="{{ route('voucher.manage.index') }}" class="{{ Request::routeIs('voucher.manage.*') ? 'active' : '' }}">Voucher
                Types</a>
            </li>
            <li>
              <a href="{{ route('ledger-head.index') }}" class="{{ Request::routeIs('ledger-head.*') ? 'active' : '' }}">Ledgers
              </a>
            </li>
          </ul>
        </li>
        {{-- 2. Transactions --}}
        <li class="dropdown">
          <a href="javascript:;" class="dropdown-toggle">
            <span class="micon dw dw-calculator"></span><span class="mtext">Transactions</span>
          </a>
          <ul class="submenu">
            <li>
              <a href="{{ route('voucher.accounting.create') }}" class="{{ Request::routeIs('voucher.accounting.*') ? 'active' : '' }}">
                Accounting
                Vouchers
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" class="">
                Payroll Vouchers
              </a>
            </li>
          </ul>
        </li>
        {{-- 3. Reports --}}
        <li class="dropdown">
          <a href="javascript:;" class="dropdown-toggle">
            <span class="micon dw dw-invoice"></span><span class="mtext">Reports</span>
          </a>
          <ul class="submenu">
            <li>
              <a href="{{ route('report.balance-sheet.index') }}" class="{{ Request::routeIs('report.balance-sheet.*') ? 'active' : '' }}">
                Balance Sheet
              </a>
            </li>
            <li>
              <a href="{{ route('report.income.index') }}" class="{{ Request::routeIs('report.income.*') ? 'active' : '' }}">
                Income & Expense A/C
              </a>
            </li>
            <li>
              <a href="#" class="">
                Display
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
  {{-- menu ends --}}
</div>
<div class="mobile-menu-overlay"></div>
