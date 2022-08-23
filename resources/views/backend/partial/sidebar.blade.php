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
        @can('read-settings')
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
        @endcan
        {{-- Divider --}}
        <li>
          <div class="dropdown-divider"></div>
        </li>

        {{-- Accounting Functionalites Menu --}}
        {{-- 1. Masters --}}
        <li>
          <div class="sidebar-small-cap">Masters</div>
        </li>
        <li>
          <a href="#" class="dropdown-toggle no-arrow">
            <span class="micon dw dw-invoice"></span><span class="mtext">Accounts Info</span>
          </a>
        </li>
        <li>
          <a href="#" class="dropdown-toggle no-arrow">
            <span class="micon dw dw-invoice"></span><span class="mtext">Payroll Info</span>
          </a>
        </li>
        <li>
          <a href="{{ route('voucher.manage.index') }}" class="dropdown-toggle no-arrow">
            <span class="micon dw dw-invoice"></span>
            <span class="mtext">Voucher Types</span></a>
        </li>
        <li>
          <a href="{{ route('ledger-head.index') }}" class="dropdown-toggle no-arrow">
            <span class="micon dw dw-invoice"></span>
            <span class="mtext">Ledgers</span></a>
        </li>
        {{-- 2. Transactions --}}
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <li>
          <div class="sidebar-small-cap">Transactions</div>
        </li>
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <li>
          <a href="{{ route('voucher.accounting.create') }}" class="dropdown-toggle no-arrow">
            <span class="micon dw dw-invoice"></span>
            <span class="mtext"> Accounting
              Vouchers</span></a>
        </li>
        {{-- 3. Reports --}}
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <li>
          <div class="sidebar-small-cap">Reports</div>
        </li>
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <li>
          <a href="{{ route('report.balance-sheet.index') }}" class="dropdown-toggle no-arrow">
            <span class="micon dw dw-invoice"></span>
            <span class="mtext">Balance Sheet</span></a>
        </li>
        <li>
          <a href="{{ route('report.income.index') }}" class="dropdown-toggle no-arrow">
            <span class="micon dw dw-invoice"></span>
            <span class="mtext"> Income & Expense A/C</span></a>
        </li>
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <li>
          <div class="sidebar-small-cap">Reports <i class="icon-copy dw dw-right-chevron"></i> Display</div>
        </li>
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <li>
          <a href="{{ route('report.display.ledger') }}" class="dropdown-toggle no-arrow">
            <span class="micon dw dw-invoice"></span>
            <span class="mtext">Ledger</span></a>
        </li>
      </ul>
    </div>
  </div>
  {{-- menu ends --}}
</div>
<div class="mobile-menu-overlay"></div>
