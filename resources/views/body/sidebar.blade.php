

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <p class="brand-text font-weight-light">AdminLTE 3</p>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="storage/users/{{Auth::user()->photo}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item {{ Request::is('dashboard') ? 'menu-open ' : '' }}">
                    <a href="{{ route('dashboard') }}" class='nav-link {{ Request::is('dashboard') ? 'active ' : '' }}'>
                        <i class="fas fa-th-large"></i>
                        <p class="ms-2" >Dashboard</p>
                    </a>
                </li>

                <hr />

                <li class="text-light">Sale</li>

                <li class="nav-item {{ Request::is('pos') ? 'menu-open ' : '' }}">
                    <a href="{{ route('Pos.index') }}" class='nav-link {{ Request::is('pos') ? 'active ' : '' }}'>
                        <i class="fa-brands fa-usps"></i>
                        <p class="ms-2" >POS</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('sale') ? 'menu-open ' : '' }}">
                    <a href="{{ route('sale.index') }}" class='nav-link {{ Request::is('sale') ? 'active ' : '' }}'>
                        <i class="far fa-file-alt"></i>
                        <p class="ms-2" >Sale</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('order') ? 'menu-open ' : '' }}">
                    <a href="{{ route('order.index') }}" class='nav-link {{ Request::is('order') ? 'active ' : '' }}'>
                        <i class="fas fa-cart-shopping"></i>
                        <p class="ms-2" >Order</p>
                    </a>
                </li>

                <hr />

                <li class="text-light">Inventory</li>

                <li class="nav-item {{ Request::is('products') ? 'menu-open ' : '' }}">
                    <a href="{{ route('products.index') }}" class="nav-link {{ Request::is('products') ? 'active' : '' }}" >
                        <i class="fab fa-product-hunt"></i>
                        <p class="ms-2" >Products</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('category') ? 'menu-open ' : '' }}">
                    <a  href="{{ route('category.index') }}" class="nav-link {{ Request::is('category') ? 'active' : '' }}">
                        <i class="fas fa-layer-group"></i>
                        <p class="ms-2" >Categories</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('units') ? 'menu-open' : '' }}">
                    <a href="{{ route('units.index') }}" class="nav-link {{ Request::is('units') ? 'active' : '' }}">
                        <i class="fab fa-unity"></i>
                        <p class="ms-2" >Units</p>
                    </a>
                </li>

                <hr />

                <li class="text-light">Stock</li>

                <li class="nav-item">
                    <a href="#" class='nav-link '>
                        <i class="fas fa-boxes-stacked"></i>  
                        <p class="ms-2" >Manage Stock</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="" class='nav-link'>
                        <i class="fas fa-warehouse"></i>  
                        <p class="ms-2" >Warehouse</p>
                    </a>
                </li>
                
                <hr />

                <li class="text-light">Purchase</li>

                <li class="nav-item {{ Request::is('purchase') ? 'menu-open' : '' }}">
                    <a href="{{ route('Purchase.index') }}" class='nav-link {{ Request::is('purchase') ? 'active' : '' }}'>
                        <i class="fa-solid fa-bag-shopping"></i>  
                        <p class="ms-2" >Purchase</p>
                    </a>
                </li>
                <li class="nav-item {">
                    <a href="" class='nav-link'>
                        <i class="fa-solid fa-file-lines"></i> 
                        <p class="ms-2" >Purchase Order</p>
                    </a>
                </li>

                <hr />

                <li class="text-light">People</li>

                <li class="nav-item {{ Request::is('employees') ? 'menu-open' : '' }}" >
                    <a href="{{ route('employee.index') }}" id="employee" class='nav-link {{ Request::is('employees') ? 'active ' : '' }}'>
                        <i class="fas fa-users"></i>  
                        <p class="ms-2" >Employees</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('suppliers') ? 'menu-open' : '' }}">
                    <a href="{{ route('supplier.index') }}" class='nav-link {{ Request::is('suppliers') ? 'active ' : '' }}'>
                        <i class="fas fa-user-group"></i>  
                        <p class="ms-2" >Suppliers</p>
                    </a>
                </li>
                <li class="nav-item  {{ Request::is('user') ? 'menu-open' : '' }}">
                    <a href="{{ route('user.index') }}" class='nav-link {{ Request::is('user') ? 'active ' : '' }}'>
                        <i class="fas fa-user"></i>  
                        <p class="ms-2" >Users</p>
                    </a>
                </li>
        </ul>
      </nav>
      <script>
        document.addEventListener("DOMContentLoaded", function() {
                var sidebar = document.querySelector(".nav-sidebar");
                var activeLink = document.querySelector(".nav-link.active");

                if (activeLink) {
                    var offsetTop = activeLink.offsetTop;
                }
            });
      </script>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>