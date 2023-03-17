<nav class="header-section navbar navbar-expand-md navbar-light">
  <a class="navbar-brand" href="#">
    <img src="{{asset('images/logo.svg')}}">    
  </a>
  <button class="navbar-toggler" type="button" onclick="openNav()">
     <span class="navbar-toggler-icon"></span>
  </button>
  <div id="mySidenav" class="sidenav">
    <ul class="navbar-nav">
    	<li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
      <li class="nav-item">
        <select id="id_select2_example">
          <option data-img_src="{{asset('images/Flags/EN.svg')}}">EN</option>
          <option data-img_src="{{asset('images/Flags/france.svg')}}">FR</option>
          <option data-img_src="{{asset('images/Flags/india.svg')}}">IND</option>
          <option data-img_src="{{asset('images/Flags/usa.svg')}}">USA</option>
        </select>
      </li>
      <li class="nav-item coins-list">
        <select id="id_select2_examples">
          <option data-img_src="{{asset('images/coins/EUR.svg')}}">EUR</option>
          <option data-img_src="{{asset('images/coins/INR.svg')}}">INR</option>
          <option data-img_src="{{asset('images/coins/GBP.svg')}}">GBP</option>
          <option data-img_src="{{asset('images/coins/USD.svg')}}">USD</option>
        </select>
      </li>
      <li class="nav-item login">
        <a class="nav-link" href="#">Login</a>
      </li>    
    </ul>
  </div>  
</nav>