@php
  $current_prefix = Request::route()->getPrefix();
  $current_route = Route::current()->getName();
@endphp

<aside class="main-sidebar">
  <!-- sidebar-->
  <section class="sidebar">	
        
    <div class="user-profile">
      <div class="ulogo">
        <a href="{{ route('dashboard') }}">
          <!-- logo for regular state and mobile devices -->
          <div class="d-flex align-items-center justify-content-center">					 	
            {{-- <img src="{{ asset('assets/images/logo-dark.png')}}"> --}}
            <h3>DMS</h3>
          </div>
        </a>
      </div>
    </div>
      
    <!-- sidebar menu-->
    <ul class="sidebar-menu" data-widget="tree">  
          
      <li class="{{ ($current_route == 'dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}">
          <i data-feather="pie-chart"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="treeview {{ ($current_prefix == 'manage-cities') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <!-- <i data-feather="book"></i> -->
          <i class="fa-solid fa-city"></i>
          <span>Cities Management</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'cities.add') ? 'active' : '' }}"><a href="{{ route('cities.add') }}"><i class="ti-more"></i>Add City</a></li>
          <li class="{{ ($current_route == 'cities.view') ? 'active' : '' }}"><a href="{{ route('cities.view') }}"><i class="ti-more"></i>Manage Cities</a></li>
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'manage-apps') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <!-- <i data-feather="book"></i> -->
          <i class="fa-solid fa-city"></i>
          <span>Apps Management</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'apps.add') ? 'active' : '' }}"><a href="{{ route('apps.add') }}"><i class="ti-more"></i>Add App</a></li>
          <li class="{{ ($current_route == 'apps.view') ? 'active' : '' }}"><a href="{{ route('apps.view') }}"><i class="ti-more"></i>Manage Apps</a></li>
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'drivers') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="users"></i>
          <span>Drivers</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'drivers.add') ? 'active' : '' }}"><a href="{{ route('drivers.add') }}"><i class="ti-more"></i>Add Drivers</a></li>
          <li class="{{ ($current_route == 'drivers.view') ? 'active' : '' }}"><a href="{{ route('drivers.view') }}"><i class="ti-more"></i>View Drivers</a></li>
          
        </ul>
      </li>

      <li class="{{ ($current_route == 'companies.view' || $current_route == 'companies.edit') ? 'active' : '' }}">
        <a href="{{ route('companies.view') }}">
          <i data-feather="briefcase"></i>
          <span>Companies</span>
        </a>
      </li>

      <li class="treeview {{ ($current_prefix == 'customers') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="users"></i>
          <span>Customers</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'customers.add') ? 'active' : '' }}"><a href="{{ route('customers.add') }}"><i class="ti-more"></i>Add Customer</a></li>
          <li class="{{ ($current_route == 'customers.view') ? 'active' : '' }}"><a href="{{ route('customers.view') }}"><i class="ti-more"></i>View Customers</a></li>
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'rent-transactions') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="clipboard"></i>
          <span>Rent Transactions</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'rent_transactions.add') ? 'active' : '' }}"><a href="{{ route('rent_transactions.add') }}"><i class="ti-more"></i>Add Transaction</a></li>
          <li class="{{ ($current_route == 'rent_transactions.view') ? 'active' : '' }}"><a href="{{ route('rent_transactions.view') }}"><i class="ti-more"></i>Active Transactions</a></li>
          <li class="{{ ($current_route == 'rent_transactions.view.pending') ? 'active' : '' }}"><a href="{{ route('rent_transactions.view.pending') }}"><i class="ti-more"></i>Pending Transactions</a></li>
          <li class="{{ ($current_route == 'rent_transactions.view.completed') ? 'active' : '' }}"><a href="{{ route('rent_transactions.view.completed') }}"><i class="ti-more"></i>Completed Transactions</a></li>
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'invoices' || $current_prefix == 'lowbed-invoices' || $current_prefix == 'common-invoices') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="file"></i>
          <span>Invoices</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'equip_invoices.view_all' || $current_route == 'equip_invoices.view' || $current_route == 'equip_invoices.create' || $current_route == 'equip_invoices.edit') ? 'active' : '' }}"><a href="{{ route('equip_invoices.view_all') }}"><i class="ti-more"></i>Rent Invoices</a></li>
          <li class="{{ ($current_route == 'lowbed_invoices.view' || $current_route == 'lowbed_invoices.add' || $current_route == 'lowbed_invoices.edit') ? 'active' : '' }}"><a href="{{ route('lowbed_invoices.view') }}"><i class="ti-more"></i>Lowbed Invoices</a></li>
          <li class="{{ ($current_route == 'common_invoices.view') ? 'active' : '' }}"><a href="{{ route('common_invoices.view') }}"><i class="ti-more"></i>Common Invoices</a></li>
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'lowbeds') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="truck"></i>
          <span>Lowbeds</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'lowbeds.status' || $current_route == 'lowbeds.status_filter') ? 'active' : '' }}"><a href="{{ route('lowbeds.status') }}"><i class="ti-more"></i>Equipment Status</a></li>
          <li class="{{ ($current_route == 'lowbeds.add') ? 'active' : '' }}"><a href="{{ route('lowbeds.add') }}"><i class="ti-more"></i>Add Lowbed</a></li>
          <li class="{{ ($current_route == 'lowbeds.view') ? 'active' : '' }}"><a href="{{ route('lowbeds.view') }}"><i class="ti-more"></i>View Lowbeds</a></li>
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'lowbed-transactions') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="clipboard"></i>
          <span>Lowbed Transactions</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'lowbed_transactions.add') ? 'active' : '' }}"><a href="{{ route('lowbed_transactions.add') }}"><i class="ti-more"></i>Add Transaction</a></li>
          <li class="{{ ($current_route == 'lowbed_transactions.view') ? 'active' : '' }}"><a href="{{ route('lowbed_transactions.view') }}"><i class="ti-more"></i>Pending Transactions</a></li>
          <li class="{{ ($current_route == 'lowbed_transactions.view_completed') ? 'active' : '' }}"><a href="{{ route('lowbed_transactions.view_completed') }}"><i class="ti-more"></i>Completed Transactions</a></li>
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'quotations') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="file-text"></i>
          <span>Quotations</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'quotations.add') ? 'active' : '' }}"><a href="{{ route('quotations.add') }}"><i class="ti-more"></i>Add Quotation</a></li>
          <li class="{{ ($current_route == 'quotations.view') ? 'active' : '' }}"><a href="{{ route('quotations.view') }}"><i class="ti-more"></i>View Quotations</a></li>
          <li class="{{ ($current_route == 'quotation_terms.view' || $current_route == 'quotation_terms.add' || $current_route == 'quotation_terms.edit') ? 'active' : '' }}">
            <a href="{{ route('quotation_terms.view') }}"><i class="ti-more"></i>Quotation Terms</a>
          </li>
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'lpos') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="file-text"></i>
          <span>LPOs</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'lpos.add') ? 'active' : '' }}"><a href="{{ route('lpos.add') }}"><i class="ti-more"></i>Add LPO</a></li>
          <li class="{{ ($current_route == 'lpos.view') ? 'active' : '' }}"><a href="{{ route('lpos.view') }}"><i class="ti-more"></i>View LPO</a></li>
          <li class="{{ ($current_route == 'lpo_item_names.view' || $current_route == 'lpo_item_names.add' || $current_route == 'lpo_item_names.edit') ? 'active' : '' }}">
            <a href="{{ route('lpo_item_names.view') }}"><i class="ti-more"></i>Item Names</a>
          </li>
          <li class="{{ ($current_route == 'lpo_terms.view' || $current_route == 'lpo_terms.add' || $current_route == 'lpo_terms.edit') ? 'active' : '' }}">
            <a href="{{ route('lpo_terms.view') }}"><i class="ti-more"></i>Terms</a>
          </li>
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'equipments') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="truck"></i>
          <span>Equipments</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'equipments.status' || $current_route == 'equipments.status_filter') ? 'active' : '' }}"><a href="{{ route('equipments.status') }}"><i class="ti-more"></i>Equipment Status</a></li>
          <li class="{{ ($current_route == 'equipments.add') ? 'active' : '' }}"><a href="{{ route('equipments.add') }}"><i class="ti-more"></i>Add Equipment</a></li>
          <li class="{{ ($current_route == 'equipments.view') ? 'active' : '' }}"><a href="{{ route('equipments.view') }}"><i class="ti-more"></i>View Equipments</a></li>
          <li class="{{ ($current_route == 'equipment_categories.view' || $current_route == 'equipment_categories.add' || $current_route == 'equipment_categories.edit') ? 'active' : '' }}">
            <a href="{{ route('equipment_categories.view') }}"><i class="ti-more"></i>Categories</a>
          </li>
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'employees') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="users"></i>
          <span>Employees</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'employees.add') ? 'active' : '' }}"><a href="{{ route('employees.add') }}"><i class="ti-more"></i>Add Employee</a></li>
          <li class="{{ ($current_route == 'employees.view') ? 'active' : '' }}"><a href="{{ route('employees.view') }}"><i class="ti-more"></i>View Employees</a></li>
          <li class="{{ ($current_route == 'employees.expense.view' || $current_route == 'employees.expense.add' || $current_route == 'employees.expense.edit') ? 'active' : '' }}">
            <a href="{{ route('employees.expense.view') }}"><i class="ti-more"></i>Expenses</a>
          </li>
          <li class="{{ ($current_route == 'employee_expense_names.view' || $current_route == 'employee_expense_names.add' || $current_route == 'employee_expense_names.edit') ? 'active' : '' }}">
            <a href="{{ route('employee_expense_names.view') }}"><i class="ti-more"></i>Expenses Names</a>
          </li>
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'fleet-services') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="shield"></i>
          <span>Fleet Services</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'fleet_services.add') ? 'active' : '' }}"><a href="{{ route('fleet_services.add') }}"><i class="ti-more"></i>Add Service</a></li>
          <li class="{{ ($current_route == 'fleet_services.view') ? 'active' : '' }}"><a href="{{ route('fleet_services.view') }}"><i class="ti-more"></i>View Services</a></li>
          <li class="{{ ($current_route == 'fleet_service_names.view' || $current_route == 'fleet_service_names.add' || $current_route == 'fleet_service_names.edit') ? 'active' : '' }}">
            <a href="{{ route('fleet_service_names.view') }}"><i class="ti-more"></i>Services Names</a>
          </li>
        
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'oil') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="activity"></i>
          <span>Oil</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'oil.view' || $current_route == 'oil.add') ? 'active' : '' }}"><a href="{{ route('oil.view') }}"><i class="ti-more"></i>View Oil</a></li>
          <li class="{{ ($current_route == 'oil_categories.view' || $current_route == 'oil_categories.add' || $current_route == 'oil_categories.edit') ? 'active' : '' }}">
            <a href="{{ route('oil_categories.view') }}"><i class="ti-more"></i>Categories</a>
          </li>
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'expired-documents') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="calendar"></i>
          <span>Expired Documents
            @if (count($expired_docs ) > 0)
              <span class="badge badge-danger ml-1">{{ count( $expired_docs ) }}</span>
            @endif
          </span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'expired_documents.equipments') ? 'active' : '' }}">
            <a href="{{ route('expired_documents.equipments') }}">
              <i class="ti-more"></i>
              Equipments
              @if (count($expired_equipment_docs) > 0)
                <span class="badge badge-danger ml-1">{{ count($expired_equipment_docs) }}</span>
              @endif
            </a>
          </li>
          <li class="{{ ($current_route == 'expired_documents.employees') ? 'active' : '' }}">
            <a href="{{ route('expired_documents.employees') }}">
              <i class="ti-more"></i>
              Employees
              @if (count($expired_employee_docs) > 0)
                <span class="badge badge-danger ml-1">{{ count($expired_employee_docs) }}</span>
              @endif
            </a>
          </li>
        </ul>
      </li>

      <li class="treeview {{ ($current_prefix == 'earnings') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="award"></i>
          <span>Earning Reports</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'earnings.equipment') ? 'active' : '' }}"><a href="{{ route('earnings.equipment') }}"><i class="ti-more"></i>Equipments</a></li>
          <li class="{{ ($current_route == 'earnings.customer') ? 'active' : '' }}"><a href="{{ route('earnings.customer') }}"><i class="ti-more"></i>Customers</a></li>
        </ul>
      </li>

      @if (Auth::user()->role == 'admin')
      <li class="treeview {{ ($current_prefix == 'users') ? 'active' : '' }}">
        <a href="javascript:void(0)">
          <i data-feather="users"></i>
          <span>Users</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($current_route == 'users.add') ? 'active' : '' }}"><a href="{{ route('users.add') }}"><i class="ti-more"></i>Add User</a></li>
          <li class="{{ ($current_route == 'users.view') ? 'active' : '' }}"><a href="{{ route('users.view') }}"><i class="ti-more"></i>View Users</a></li>
        </ul>
      </li>
      @endif
        
    </ul>
  </section>
    
  {{-- <div class="sidebar-footer">
    <!-- item-->
    <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Settings" aria-describedby="tooltip92529"><i class="ti-settings"></i></a>
    <!-- item-->
    <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i class="ti-email"></i></a>
    <!-- item-->
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <a href="{{ route('logout') }}" class="link" onclick="event.preventDefault(); this.closest('form').submit();" data-toggle="tooltip" title="" data-original-title="Logout"><i class="ti-lock"></i></a>
    </form>
  </div> --}}

</aside>