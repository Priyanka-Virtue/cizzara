<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="{{ route('welcome') }}" class="app-brand-link">
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
                <div data-i18n="Videos">All videos list</div>
              </a>
            </li>
            @role('guru')
            <li class="menu-item active">
              <a href="{{route('admin.auditions.index')}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-human-female-dance"></i>
                <div data-i18n="Contestants">All Entries</div>
              </a>
            </li>
            @endrole
            @role('admin')


            <li class="menu-item active">
              <a href="{{route('admin.auditions.top')}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-star-check"></i>
                <div data-i18n="Contestants">Top 500</div>
              </a>
            </li>

            <!-- <li class="menu-item active">
              <a href="{{route('admin.auditions.top')}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-star-circle-outline"></i>

                <div data-i18n="Contestants">Top 100</div>
              </a>
            </li>

            <li class="menu-item active">
              <a href="{{route('admin.auditions.top')}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-numeric-10-circle"></i>
                <div data-i18n="Contestants">Top 10</div>
              </a>
            </li>

            <li class="menu-item active">
              <a href="{{route('admin.auditions.top')}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-trophy-award"></i>
                <div data-i18n="Contestants">Top 3</div>
              </a>
            </li> -->

            <li class="menu-item active">
              <a href="{{route('admin.users.index')}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-account-details"></i>
                <div data-i18n="Contestants">Contestants Profiles</div>
              </a>
            </li>
            <li class="menu-item">
              <hr/>
            </li>
            <li class="menu-item active">
              <a href="{{route('gurus.index')}}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-account-group"></i>
                <div data-i18n="Contestants">Gurus</div>
              </a>
            </li>
            @endcan
          </ul>
        </aside>
