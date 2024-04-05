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
            <!-- <li class="menu-item active">
              <a href="{{route('admin.videos.index')}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-table"></i>
                <div data-i18n="Videos">Videos</div>
              </a>
            </li> -->

            <li class="menu-item active">
              <a href="{{route('admin.auditions.index')}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-human-female-dance"></i>
                <div data-i18n="Contestants">All Entries</div>
              </a>
            </li>
            @role('admin')


            <li class="menu-item active">
              <a href="{{route('admin.auditions.top', 500)}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-human-female-dance"></i>
                <div data-i18n="Contestants">Top 500</div>
              </a>
            </li>

            <li class="menu-item active">
              <a href="{{route('admin.auditions.top', 100)}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-human-female-dance"></i>
                <div data-i18n="Contestants">Top 100</div>
              </a>
            </li>

            <li class="menu-item active">
              <a href="{{route('admin.auditions.top', 10)}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-human-female-dance"></i>
                <div data-i18n="Contestants">Top 10</div>
              </a>
            </li>

            <li class="menu-item active">
              <a href="{{route('admin.auditions.top', 3)}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-human-female-dance"></i>
                <div data-i18n="Contestants">Top 3</div>
              </a>
            </li>

            <li class="menu-item active">
              <a href="{{route('admin.users.index')}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-human-female-dance"></i>
                <div data-i18n="Contestants">Contestants Profiles</div>
              </a>
            </li>
            @endcan
          </ul>
        </aside>
