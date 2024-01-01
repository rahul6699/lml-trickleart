<!-- removeNotificationModal -->
<div
        id="removeNotificationModal"
        class="modal fade zoomIn"
        tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                id="NotificationModalbtn-close"
              ></button>
            </div>
            <div class="modal-body">
              <div class="mt-2 text-center">
                <lord-icon
                  src="https://cdn.lordicon.com/gsqxdxog.json"
                  trigger="loop"
                  colors="primary:#f7b84b,secondary:#f06548"
                  style="width: 100px; height: 100px"
                ></lord-icon>
                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                  <h4>Are you sure ?</h4>
                  <p class="text-muted mx-4 mb-0">
                    Are you sure you want to remove this Notification ?
                  </p>
                </div>
              </div>
              <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                <button
                  type="button"
                  class="btn w-sm btn-light"
                  data-bs-dismiss="modal"
                >
                  Close
                </button>
                <button
                  type="button"
                  class="btn w-sm btn-danger"
                  id="delete-notification"
                >
                  Yes, Delete It!
                </button>
              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}">
                    <i class="ri-dashboard-2-line"></i> 
                    <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarTables" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarTables">
                        <i class="ri-layout-grid-line"></i> <span data-key="t-tables">Source</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarTables">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.source.index') }}" class="nav-link" data-key="t-basic-tables">List</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#leadStatusTables" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="leadStatusTables">
                        <i class="ri-layout-grid-line"></i> <span data-key="t-tables">Lead Status</span>
                    </a>
                    <div class="collapse menu-dropdown" id="leadStatusTables">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.lead_status.index') }}" class="nav-link" data-key="t-basic-tables">List</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#leadsTables" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="leadsTables">
                        <i class="ri-layout-grid-line"></i> <span data-key="t-tables">Leads</span>
                    </a>
                    <div class="collapse menu-dropdown" id="leadsTables">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.leads.index') }}" class="nav-link" data-key="t-basic-tables">List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.leads.create') }}" class="nav-link" data-key="t-basic-tables">Add</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#leadsTables" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="leadsTables">
                        <i class="ri-layout-grid-line"></i> <span data-key="t-tables">Users List</span>
                    </a>
                    <div class="collapse menu-dropdown" id="leadsTables">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link" data-key="t-basic-tables">List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.create') }}" class="nav-link" data-key="t-basic-tables">Add</a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>