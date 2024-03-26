<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="#" class="app-brand-link">
              <span class="app-brand-logo demo me-1">
                    <img src="{{ asset('images/logo-or.png') }}" width="190px" alt="{{ config('app.name', 'The United Production') }}">
              </span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">

            <!-- Tables -->
            <li class="menu-item active">
              <a href="{{route('admin.videos.index')}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-table"></i>
                <div data-i18n="Tables">Videos</div>
              </a>
            </li>
          </ul>
        </aside>
