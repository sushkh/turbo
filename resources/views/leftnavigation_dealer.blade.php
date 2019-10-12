<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                    <img alt="image" src="{{URL::asset('img/bpcl.png')}}"/>
                </span>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Welcome {{$name}}</strong>
                    </span> <span class="text-muted text-xs block"></span> </span> </a>
                    
                </div>
                <div class="logo-element">
                    TURBO                </div>
                </li>   @if(Request::path() == 'dashboard')

            <li class="active">
                <a href="{{URL::route('dashboard')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span></a>
            </li>
            @else

            <li >
                <a href="{{URL::route('dashboard')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span></a>
            </li>
            @endif
            
                @if(Request::path() == 'devices')
            <li class = "active" >
                <a href="{{URL::route('devices')}}"><i class="fa fa-diamond"></i> <span class="nav-label">Devices</span></a>
            </li>
            @else
            <li >
                <a href="{{URL::route('devices')}}"><i class="fa fa-diamond"></i> <span class="nav-label">Devices</span></a>
            </li>
            @endif
                @if(Request::path() == 'offers')
            <li class = "active" >
                <a href="{{URL::route('offers')}}"><i class="fa fa-gift"></i> <span class="nav-label">Offers</span></a>
            </li>
            @else
            <li >
                <a href="{{URL::route('offers')}}"><i class="fa fa-gift"></i> <span class="nav-label">Offers</span></a>
            </li>
            @endif
                @if(Request::path() == 'items')
            <li class = "active" >
                <a href="{{URL::route('items')}}"><i class="fa fa-gift"></i> <span class="nav-label">Items</span></a>
            </li>
            @else
            <li >
                <a href="{{URL::route('items')}}"><i class="fa fa-gift"></i> <span class="nav-label">Items</span></a>
            </li>
            @endif
            
             <li >
                <a href="" data-toggle="modal" data-target="#check"  ><i class="fa fa-inr"></i> <span class="nav-label">Settings</span></a>
            </li>
       
            </ul>

        </div>
    </nav>

            <div class="modal inmodal fade" id="check" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <form action = "{{URL::route('save_settings')}}" method = "post">

                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title">Settings</h4>
                            </div>
                            <div class="modal-body">
                                {{csrf_field()}}
                                <p><strong>Kindly Enter The Following Details</strong> </p>
                                <div class="form-group"><label class="col-sm-2 control-label">Speed Price</label>

                                    <div class="col-sm-10">
                                        <div class="input-group m-b"><span class="input-group-addon ">&#8377;</span> 
                                            @if(Session::has('speed_price'))
                                            <input type="text" value ="{{Session::get('speed_price')}}" required id ="speed"  name = "speed_price" class="form-control"> <span class="input-group-addon">per ltr</span>
                                            @else
                                            <input type="text"  required id ="speed"  name = "speed_price" class="form-control"> <span class="input-group-addon">per ltr</span>

                                            @endif
                                            </div>
                                    </div>
                                </div>
                                   <div class="form-group"><label class="col-sm-2 control-label">Diesel Price</label>

                                    <div class="col-sm-10">
                                        <div class="input-group m-b"><span class="input-group-addon ">&#8377;</span> 
                                            @if(Session::has('diesel_price'))
                                            <input type="text" value ="{{Session::get('diesel_price')}}" required id ="diesel"  name = "diesel_price" class="form-control"> <span class="input-group-addon">per ltr</span>
                                            @else
                                            <input type="text"  required id ="diesel"  name = "diesel_price" class="form-control"> <span class="input-group-addon">per ltr</span>

                                            @endif
                                            </div>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Petrol Price</label>

                                    <div class="col-sm-10">
                                        <div class="input-group m-b"><span class="input-group-addon">&#8377;  </span> 
                                            @if(Session::has('petrol_price'))

                                            <input type="text" required id ="petrol" value ="{{Session::get('petrol_price')}}" name = "petrol_price" class="form-control"> <span class="input-group-addon">per ltr</span>
                                            @else
                                            <input type="text" required id ="petrol" name = "petrol_price" class="form-control"> <span class="input-group-addon">per ltr</span>

                                            @endif
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>