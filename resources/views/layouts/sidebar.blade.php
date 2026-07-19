<div id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-white sidebar border-start shadow-sm p-0">
    <div class="list-group list-group-flush mt-3">

        <a href="{{ route('dashboard') }}" 
           class="list-group-item list-group-item-action py-3 fw-semibold fs-6 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2 fs-5"></i> {{ __('layout.dashboard') }}
        </a>
        
          <a href="{{ route('suppliers.index') }}" 
           class="list-group-item list-group-item-action py-3 fw-semibold fs-6 {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            <i class="bi bi-truck me-2 fs-5"></i> {{ __('layout.suppliers') }}
        </a>

        <a href="{{ route('products.index') }}" 
           class="list-group-item list-group-item-action py-3 fw-semibold fs-6 {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam me-2 fs-5"></i> {{ __('layout.products') }}
        </a>
        
        <a href="{{ route('purchases.index') }}" 
        class="list-group-item list-group-item-action py-3 fw-semibold fs-6 {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
            <i class="bi bi-bag-check me-2 fs-5"></i> {{ __('layout.purchases') }}
        </a>
        
        <a href="{{ route('inventory.index') }}" 
            class="list-group-item list-group-item-action py-3 fw-semibold fs-6 {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
        <i class="bi bi-boxes me-2 fs-5"></i> {{ __('layout.inventory') }}
        </a>

        <a href="{{ route('prices.index') }}"
            class="list-group-item list-group-item-action py-3 fw-semibold fs-6 {{ request()->routeIs('prices.*') ? 'active' : '' }}">
            <i class="bi bi-tags me-2 fs-5"></i>
            {{ __('layout.prices') }}
        </a>

        <a href="{{ route('customers.index') }}" 
           class="list-group-item list-group-item-action py-3 fw-semibold fs-6 {{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <i class="bi bi-people me-2 fs-5"></i> {{ __('layout.customers') }}
        </a>

        <a href="{{ route('sales.index') }}" 
           class="list-group-item list-group-item-action py-3 fw-semibold fs-6 {{ request()->routeIs('sales.*') ? 'active' : '' }}">
            <i class="bi bi-receipt me-2 fs-5"></i> {{ __('layout.sales') }}
        </a>

        <a href="{{ route('payments.index') }}" 
           class="list-group-item list-group-item-action py-3 fw-semibold fs-6 {{ request()->routeIs('payments.*') ? 'active' : '' }}">
            <i class="bi bi-cash-coin me-2 fs-5"></i> {{ __('layout.payments') }}
        </a>

<a href="{{ route('stock_movements.index') }}" 
   class="list-group-item list-group-item-action py-3 fw-semibold fs-6 {{ request()->routeIs('stock_movements.*') ? 'active' : '' }}">
    <i class="bi bi-arrow-left-right me-2 fs-5"></i>
    {{ __('layout.stock_movements') }}
</a>

    </div>
</div>
