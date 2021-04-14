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
      <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
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
        <li class="nav-item has-sub {{ Request::is('users*') ? 'active' : '' }}">
          <a href="/users">
            <i class="feather icon-users"></i>
            <span class="menu-title" data-i18n="">Jarvis Users</span>
          </a>
          <ul class="menu-content" style="">
            <li class="{{ Request::is('users') ? 'active' : '' }}">
              <a href="/users">
                <i class="feather icon-list"></i>
                <span class="menu-title" data-i18n="">List</span>
              </a>
            </li>
            <li class="{{ Request::is('users/create') ? 'active' : '' }}">
              <a href="/users/create">
                <i class="feather icon-plus-circle"></i>
                <span class="menu-title" data-i18n="">Add</span>
              </a>
            </li>            
            
            @can('users.index')            
            <li class="{{ Request::is('roles*') ? 'active' : '' }}">
              <a href="/roles">
                <i class="feather icon-list"></i>
                <span class="menu-title" data-i18n="">Roles</span>
              </a>
            </li>
            @endcan
          </ul>
        </li>

        <li class="nav-item has-sub {{ Request::is('b2b*') ? 'active' : '' }}">
          <a href="/b2b">
            <i class="feather icon-users"></i>
            <span class="menu-title" data-i18n="">B2B Users</span>
          </a>
          <ul class="menu-content" style="">
            <li class="{{ Request::is('b2b') ? 'active' : '' }}">
              <a href="/b2b">
                <i class="feather icon-list"></i>
                <span class="menu-title" data-i18n="">List</span>
              </a>
            </li>
            <li class="{{ Request::is('b2b/create') ? 'active' : '' }}">
              <a href="/b2b/create">
                <i class="feather icon-plus-circle"></i>
                <span class="menu-title" data-i18n="">Add</span>
              </a>
            </li>
          </ul>
        </li>

      @endcan

      @can('employers.index')
        <li class="navigation-header">
            <span>Employers / Employee</span>
        </li>

        <li class="nav-item has-sub {{ Request::is('employers*') ? 'active' : '' }}">
            <a href="/employers">
              <i class="feather icon-briefcase"></i>
              <span class="menu-title" data-i18n="">Employers</span>
            </a>
            <ul class="menu-content">
              <li class="{{ Request::is('employers') ? 'active' : '' }}">
                  <a href="/employers">
                    <i class="feather icon-list"></i>
                    <span class="menu-title" data-i18n="">Employers</span>
                  </a>
              </li>
              @can('schools.index')
              <li class="{{ Request::is('employers/schools') ? 'active' : '' }}">
                  <a href="/employers/schools">
                    <i class="feather icon-list"></i>
                    <span class="menu-title" data-i18n="">Schools</span>
                  </a>
              </li>
              @endcan
              <li class="{{ Request::is('employers/create') ? 'active' : '' }}">
                  <a href="/employers/create?source=B2B">
                      <i class="feather icon-plus-circle"></i>
                      <span class="menu-title" data-i18n="">Add</span>
                  </a>
              </li>
            </ul>
        </li>
      @endcan
      
      @can('employees.index')
        <li class="nav-item has-sub {{ Request::is('employees*') ? 'active' : '' }}">
          <a href="/employees">
            <i class="feather icon-user"></i>
            <span class="menu-title" data-i18n="">Employees</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::is('employees') ? 'active' : '' }}">
              <a href="/employees">
                <i class="feather icon-list"></i>
                <span class="menu-title" data-i18n="">List</span>
              </a>
            </li>
            <li class="{{ Request::is('employees/create') ? 'active' : '' }}">
              <a href="/employees/create">
                <i class="feather icon-plus-circle"></i>
                <span class="menu-title" data-i18n="">Add</span>
              </a>
            </li>
            <li class="{{ Request::is('employees/upload') ? 'active' : '' }}">
              <a href="/employees/upload">
                <i class="feather icon-plus-circle"></i>
                <span class="menu-title" data-i18n="">Upload</span>
              </a>
            </li>
          </ul>
        </li>
      @endcan

      @can('orders.index')
        <li class="navigation-header">
            <span>Order & Tasks</span>
        </li>

        <li class="nav-item has-sub {{ Request::is('orders*') ? 'active' : '' }}">
            <a href="/orders">
              <i class="feather icon-clipboard"></i>
              <span class="menu-title" data-i18n="">Orders</span>
            </a>
            <ul class="menu-content">
              <li class="{{ Request::is('orders') ? 'active' : '' }}">
                <a href="/orders">
                  <i class="feather icon-list"></i>
                  <span class="menu-title" data-i18n="">List</span>
                </a>
              </li>
              <li class="{{ Request::is('orders/tasks') || Request::is('orders/task*') ? 'active' : '' }}">
                <a href="/orders/tasks">
                  <i class="feather icon-list"></i>
                  <span class="menu-title" data-i18n="">Tasks</span>
                </a>
              </li>
              <li class="{{ Request::is('orders/create') ? 'active' : '' }}">
                <a href="/orders/create">
                  <i class="feather icon-plus-circle"></i>
                  <span class="menu-title" data-i18n="">Add</span>
                </a>
              </li>
            </ul>
        </li>
      @endcan

      @can('surveys.index')
        <li class="nav-item has-sub {{ Request::is('surveys*') ? 'active' : '' }}">
          <a href="/surveys">
            <i class="feather icon-clipboard"></i>
            <span class="menu-title" data-i18n="">Surveys</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::is('surveys') ? 'active' : '' }}">
              <a href="/surveys">
                <i class="feather icon-list"></i>
                <span class="menu-title" data-i18n="">List</span>
              </a>
            </li>
            <li class="{{ Request::is('surveys/create') ? 'active' : '' }}">
              <a href="/surveys/create">
                <i class="feather icon-plus-circle"></i>
                <span class="menu-title" data-i18n="">Add</span>
              </a>
            </li>
          </ul>
        </li>
      @endcan

      @can('searches.index')
        <li class="navigation-header">
          <span>Internal Tools</span>
        </li>

        <li class="nav-item has-sub {{ Request::is('searches*') ? 'active' : '' }}">
          <a href="/searches/crc">
            <i class="feather icon-clipboard"></i>
            <span class="menu-title" data-i18n="">CRC</span>
          </a>
          <ul class="menu-content">
            @can('searches.cosmos')
            <li class="{{ Request::is('searches/cosmos') ? 'active' : '' }}">
              <a href="/searches/cosmos">
                <i class="feather icon-list"></i>
                <span class="menu-title" data-i18n="">Cosmos</span>
              </a>
            </li>
            @endcan
            @can('searches.vp')
            <li class="{{ Request::is('searches/vp') ? 'active' : '' }}">
              <a href="/searches/vp">
                <i class="feather icon-list"></i>
                <span class="menu-title" data-i18n="">VP</span>
              </a>
            </li>
            @endcan
            @can('searches.fir')
            <li class="{{ Request::is('searches/fir') ? 'active' : '' }}">
              <a href="/searches/fir">
                <i class="feather icon-list"></i>
                <span class="menu-title" data-i18n="">FIR</span>
              </a>
            </li>
            @endcan
            @can('searches.webmedia')
            <li class="{{ Request::is('searches/webmedia') ? 'active' : '' }}">
              <a href="/searches/webmedia">
                <i class="feather icon-list"></i>
                <span class="menu-title" data-i18n="">WEB MEDIA</span>
              </a>
            </li>
            @endcan
          </ul>
        </li>
      @endcan

      @can('billing.clients')
        <li class="navigation-header">
          <span>Billing</span>
        </li>
        <li class="nav-item {{ Request::is('billing/clients') ? 'active' : '' }}">
          <a href="/billing/clients">
            <i class="feather icon-settings"></i>
            <span class="menu-title" data-i18n="nav.page_account_settings">Client Billing</span>
          </a>
        </li>
      @endcan

      @can('billing.plans.index')
        <li class="nav-item has-sub {{ Request::is('billing-plans*') ? 'active' : '' }}">
            <a href="/billing-plans">
                <i class="feather icon-clipboard"></i>
                <span class="menu-title" data-i18n="">Billing Plans</span>
            </a>
            <ul class="menu-content">
                <li class="{{ Request::is('billing-plans') ? 'active' : '' }}">
                    <a href="/billing-plans">
                        <i class="feather icon-list"></i>
                        <span class="menu-title" data-i18n="">List</span>
                    </a>
                </li>
                <li class="{{ Request::is('billing-plans/create') ? 'active' : '' }}">
                    <a href="/billing-plans/create">
                        <i class="feather icon-plus-circle"></i>
                        <span class="menu-title" data-i18n="">Add</span>
                    </a>
                </li>
            </ul>
        </li>
      @endcan

      @can('activity.index')
        <li class="navigation-header">
          <span>Tech Operation</span>
        </li>
        <li class="nav-item {{ Request::is('activity*') ? 'active' : '' }}">
          <a href="/activity/logs">
            <i class="feather icon-settings"></i>
            <span class="menu-title" data-i18n="nav.page_account_settings">Activity Logs</span>
          </a>
        </li>
        <li class="nav-item {{ Request::is('allactivity*') ? 'active' : '' }}">
          <a href="/allactivity/logs">
            <i class="feather icon-settings"></i>
            <span class="menu-title" data-i18n="nav.page_account_settings">All Logs</span>
          </a>
        </li>
      @endcan

      <li class="navigation-header">
        <span>Settings</span>
      </li>
      
      @can('documents.index')
        <li class="nav-item has-sub {{ Request::is('documents*') ? 'active' : '' }}">
            <a href="/documents">
                <i class="feather icon-clipboard"></i>
                <span class="menu-title" data-i18n="">Documents Type</span>
            </a>
            <ul class="menu-content">
                <li class="{{ Request::is('documents') ? 'active' : '' }}">
                    <a href="/documents">
                        <i class="feather icon-list"></i>
                        <span class="menu-title" data-i18n="">List</span>
                    </a>
                </li>
                <li class="{{ Request::is('documents/create') ? 'active' : '' }}">
                    <a href="/documents/create">
                        <i class="feather icon-plus-circle"></i>
                        <span class="menu-title" data-i18n="">Add</span>
                    </a>
                </li>
            </ul>
        </li>
      @endcan

      @can('employeetype.index')
      <li class="nav-item has-sub {{ Request::is('employeetype*') ? 'active' : '' }}">
          <a href="/employeetype">
              <i class="feather icon-pocket"></i>
              <span class="menu-title" data-i18n="">Employee Type</span>
          </a>
          <ul class="menu-content">
              <li class="{{ Request::is('employeetype') ? 'active' : '' }}">
                  <a href="/employeetype">
                      <i class="feather icon-list"></i>
                      <span class="menu-title" data-i18n="">List</span>
                  </a>
              </li>
              <li class="{{ Request::is('employeetype/create') ? 'active' : '' }}">
                  <a href="/employeetype/create">
                      <i class="feather icon-plus-circle"></i>
                      <span class="menu-title" data-i18n="">Add</span>
                  </a>
              </li>
          </ul>
      </li>
      @endcan

      @can('verificationtype.index')
      <li class="nav-item has-sub {{ Request::is('verificationtype*') ? 'active' : '' }}">
          <a href="/verificationtype">
              <i class="feather icon-file-text"></i>
              <span class="menu-title" data-i18n="">Verification Type</span>
          </a>
          <ul class="menu-content">
              <li class="{{ Request::is('verificationtype') ? 'active' : '' }}">
                  <a href="/verificationtype">
                      <i class="feather icon-list"></i>
                      <span class="menu-title" data-i18n="">List</span>
                  </a>
              </li>
              <li class="{{ Request::is('verificationtype/create') ? 'active' : '' }}">
                  <a href="/verificationtype/create">
                      <i class="feather icon-plus-circle"></i>
                      <span class="menu-title" data-i18n="">Add</span>
                  </a>
              </li>
          </ul>
      </li>
      @endcan

      @can('severity.index')
      <li class="nav-item has-sub {{ Request::is('severity*') ? 'active' : '' }}">
          <a href="/severity">
              <i class="feather icon-file-text"></i>
              <span class="menu-title" data-i18n="">Task Severity</span>
          </a>
          <ul class="menu-content">
            <li class="{{ Request::is('severity') ? 'active' : '' }}">
                <a href="/severity">
                    <i class="feather icon-list"></i>
                    <span class="menu-title" data-i18n="">List</span>
                </a>
            </li>
            <li class="{{ Request::is('severity/create') ? 'active' : '' }}">
                <a href="/severity/create">
                    <i class="feather icon-plus-circle"></i>
                    <span class="menu-title" data-i18n="">Add</span>
                </a>
            </li>
            
            @can('severitymessage.index')
            <li class="{{ Request::is('severity/messages') ? 'active' : '' }}">
                  <a href="/severity/messages">
                      <i class="feather icon-list"></i>
                      <span class="menu-title" data-i18n="">Severity Messeges</span>
                  </a>
              </li>
              <li class="{{ Request::is('severity/messages/create') ? 'active' : '' }}">
                  <a href="/severity/messages/create">
                      <i class="feather icon-plus-circle"></i>
                      <span class="menu-title" data-i18n="">Add Severity Messege</span>
                  </a>
              </li>
              @endcan
          </ul>
      </li>
      @endcan

      @can('surveyquestions.index')
      <li class="nav-item has-sub {{ Request::is('surveyquestions*') ? 'active' : '' }}">
          <a href="/surveyquestions">
              <i class="feather icon-file-text"></i>
              <span class="menu-title" data-i18n="">Survey Question</span>
          </a>
          <ul class="menu-content">
              <li class="{{ Request::is('surveyquestions') ? 'active' : '' }}">
                  <a href="/surveyquestions">
                      <i class="feather icon-list"></i>
                      <span class="menu-title" data-i18n="">List</span>
                  </a>
              </li>
              <li class="{{ Request::is('surveyquestions/create') ? 'active' : '' }}">
                  <a href="/surveyquestions/create">
                      <i class="feather icon-plus-circle"></i>
                      <span class="menu-title" data-i18n="">Add</span>
                  </a>
              </li>
          </ul>
      </li>
      @endcan

      @can('apis.index')
        <li class="nav-item {{ Request::is('apis*') ? 'active' : '' }}">
          <a href="/apis">
            <i class="feather icon-settings"></i>
            <span class="menu-title" data-i18n="nav.page_account_settings">API Keys</span>
          </a>
        </li>
      @endcan

      <li class="nav-item {{ Request::is('profile') ? 'active' : '' }}">
          <a href="/profile">
              <i class="feather icon-settings"></i>
              <span class="menu-title" data-i18n="nav.page_account_settings">Profile</span>
          </a>
      </li>
    </ul>
  </div>
</div>
<!-- END: Main Menu-->