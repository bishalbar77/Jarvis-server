@php
$configData = Helper::applClasses();
@endphp
<div
  class="main-menu menu-fixed {{($configData['theme'] === 'light') ? "menu-light" : "menu-dark"}} menu-accordion menu-shadow"
  data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
        <a class="navbar-brand" href="/dashboard-analytics">
          <div class="brand-logo"></div>
          <h2 class="brand-text mb-0">Jarvis</h2>
        </a>
      </li>
      <li class="nav-item nav-toggle">
        <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
          <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
          <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block primary collapse-toggle-icon"
            data-ticon="icon-disc">
          </i>
        </a>
      </li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

      @can('dashboard')
      <li class="nav-item active">
        <a href="/">
          <i class="feather icon-home"></i>
          <span class="menu-title" data-i18n="nav.dashboard_ecommerce">Dashboard</span>
        </a>
      </li>
      @endcan

      @can('users.index')
        <li class="navigation-header">
          <span>Users & Permission</span>
        </li>
        <li class="nav-item has-sub">
          <a href="/users">
            <i class="feather icon-users"></i>
            <span class="menu-title" data-i18n="">Users</span>
          </a>
          <ul class="menu-content" style="">
            <li class="">
              <a href="/users">
                <i class="feather icon-list"></i>
                <span class="menu-title" data-i18n="">List</span>
              </a>
            </li>
            <li class="">
              <a href="/users/create">
                <i class="feather icon-plus-circle"></i>
                <span class="menu-title" data-i18n="">Add</span>
              </a>
            </li>
          </ul>
        </li>
      @endcan

      <li class="navigation-header">
          <span>Employers / Employee</span>
      </li>

      @can('employers.index')
        <li class="nav-item has-sub">
            <a href="/employers">
              <i class="feather icon-briefcase"></i>
              <span class="menu-title" data-i18n="">Employers</span>
            </a>
            <ul class="menu-content">
              <li class="">
                  <a href="/employers">
                    <i class="feather icon-list"></i>
                    <span class="menu-title" data-i18n="">List</span>
                  </a>
              </li>
              <li class="">
                  <a href="/employers/create">
                      <i class="feather icon-plus-circle"></i>
                      <span class="menu-title" data-i18n="">Add</span>
                  </a>
              </li>
            </ul>
        </li>
      @endcan
      
      @can('employees.index')
        <li class="nav-item has-sub">
          <a href="/employees">
            <i class="feather icon-user"></i>
            <span class="menu-title" data-i18n="">Employees</span>
          </a>
          <ul class="menu-content">
            <li class="">
              <a href="/employees">
                <i class="feather icon-list"></i>
                <span class="menu-title" data-i18n="">List</span>
              </a>
            </li>
            <li class="">
              <a href="/employees/create">
                <i class="feather icon-plus-circle"></i>
                <span class="menu-title" data-i18n="">Add</span>
              </a>
            </li>
          </ul>
        </li>
      @endcan

      @can('orders.index')
        <li class="navigation-header">
            <span>Order & Tasks</span>
        </li>

        <li class="nav-item has-sub">
            <a href="/orders">
              <i class="feather icon-clipboard"></i>
              <span class="menu-title" data-i18n="">Orders</span>
            </a>
            <ul class="menu-content">
              <li class="">
                <a href="/orders">
                  <i class="feather icon-list"></i>
                  <span class="menu-title" data-i18n="">List</span>
                </a>
              </li>
              <li class="">
                <a href="/orders/create">
                  <i class="feather icon-plus-circle"></i>
                  <span class="menu-title" data-i18n="">Add</span>
                </a>
              </li>
            </ul>
        </li>
      @endcan

      @can('documents.index')
        <li class="navigation-header">
          <span>Settings</span>
        </li>
      @endcan
      
      @can('documents.index')
        <li class="nav-item has-sub">
            <a href="/documents">
                <i class="feather icon-clipboard"></i>
                <span class="menu-title" data-i18n="">Documents Type</span>
            </a>
            <ul class="menu-content">
                <li class="">
                    <a href="/documents">
                        <i class="feather icon-list"></i>
                        <span class="menu-title" data-i18n="">List</span>
                    </a>
                </li>
                <li class="">
                    <a href="/documents/create">
                        <i class="feather icon-plus-circle"></i>
                        <span class="menu-title" data-i18n="">Add</span>
                    </a>
                </li>
            </ul>
        </li>
      @endcan

      @can('employeetype.index')
      <li class="nav-item has-sub hover">
          <a href="/employeetype">
              <i class="feather icon-pocket"></i>
              <span class="menu-title" data-i18n="">Employee Type</span>
          </a>
          <ul class="menu-content">
              <li class="">
                  <a href="/employeetype">
                      <i class="feather icon-list"></i>
                      <span class="menu-title" data-i18n="">List</span>
                  </a>
              </li>
              <li class="">
                  <a href="/employeetype/create">
                      <i class="feather icon-plus-circle"></i>
                      <span class="menu-title" data-i18n="">Add</span>
                  </a>
              </li>
          </ul>
      </li>
      @endcan

      @can('employeetype.index')
      <li class="nav-item has-sub">
          <a href="/verificationtype">
              <i class="feather icon-file-text"></i>
              <span class="menu-title" data-i18n="">Verification Type</span>
          </a>
          <ul class="menu-content">
              <li class="">
                  <a href="/verificationtype">
                      <i class="feather icon-list"></i>
                      <span class="menu-title" data-i18n="">List</span>
                  </a>
              </li>
              <li class="">
                  <a href="/verificationtype/create">
                      <i class="feather icon-plus-circle"></i>
                      <span class="menu-title" data-i18n="">Add</span>
                  </a>
              </li>
          </ul>
      </li>
      @endcan

      <li class="nav-item">
          <a href="/account-settings">
              <i class="feather icon-settings"></i>
              <span class="menu-title" data-i18n="nav.page_account_settings">Account Settings</span>
          </a>
      </li>
      
   

      {{-- Foreach menu item starts --}}
      @if(isset($menuData[0]))
      @foreach($menuData[0]->menu as $menu)
      @if(isset($menu->navheader))
      <li class="navigation-header">
        <span>{{ $menu->navheader }}</span>
      </li>
      @else
      {{-- Add Custom Class with nav-item --}}
      @php
      $custom_classes = "";
      if(isset($menu->classlist)) {
      $custom_classes = $menu->classlist;
      }
      $translation = "";
      if(isset($menu->i18n)){
      $translation = $menu->i18n;
      }
      @endphp
      <li class="nav-item {{ (request()->is($menu->url)) ? 'active' : '' }} {{ $custom_classes }}">
        <a href="{{ $menu->url }}">
          <i class="{{ $menu->icon }}"></i>
          <span class="menu-title" data-i18n="{{ $translation }}">{{ $menu->name }}</span>
          @if (isset($menu->badge))
          <?php $badgeClasses = "badge badge-pill badge-primary float-right" ?>
          <span
            class="{{ isset($menu->badgeClass) ? $menu->badgeClass.' test' : $badgeClasses.' notTest' }} ">{{$menu->badge}}</span>
          @endif
        </a>
        @if(isset($menu->submenu))
        @include('panels/submenu', ['menu' => $menu->submenu])
        @endif
      </li>
      @endif
      @endforeach
      @endif
      {{-- Foreach menu item ends --}}
    </ul>
  </div>
</div>
<!-- END: Main Menu-->