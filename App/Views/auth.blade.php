@if (auth()::check()) 

<div class="card mb-3" style="height:70px;">
  <div class="row g-0 h-100">
    <div class="col h-100" style="max-width:80px">
      @if(auth()::user()->avatar!==null)
        <img src="/Avatars/{{auth()::user()->avatar}}"
            class="h-100 rounded-start" alt="{{auth()::user()->name}}'s avatar">
        @endif
    </div>
    <div class="col">
        <div class="card-body">
            <div class="float-start">Welcome {{auth()::user()->name}} </div>
            <a href="#" class="btn btn-danger float-end" hx-get="?page=logout" hx-target="#container">Logout</a>
        </div>
    </div>
  </div>
</div>

<hr>
<a href="#" hx-get="?page=users" hx-target="#container" class="btn btn-primary">
    User List
</a>
@else
you need to 
<a href="#" hx-get="?page=register" hx-target="#container">
    Register
</a>
or <a href="#" hx-target="#container" hx-get="?page=login">Login</a>
@endif