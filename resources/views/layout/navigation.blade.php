<nav class="col-md-2 d-none d-md-block bg-light sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link @if(class_basename(request()->route()->getController())=='VoucherController') active @endif" href="{{URL::to('/')}}">
          <span data-feather="home"></span>
          Vouchers
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link @if(class_basename(request()->route()->getController())=='OfferController') active @endif" href="{{URL::to('offers')}}">
          <span data-feather="shopping-cart"></span>
          Offers
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link @if(class_basename(request()->route()->getController())=='RecipientController') active @endif" href="{{URL::to('recipients')}}">
          <span data-feather="users"></span>
          Recipients
        </a>
      </li>
    </ul>
  </div>
</nav>