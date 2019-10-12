<!DOCTYPE html>
<html>

<head>

    @include('header')
    
</head>

<body>

    <div id="wrapper">

        @include('leftnavigation_admin')

        <div id="page-wrapper" class="gray-bg">
            @include('topnavigation')

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2>Dealer</h2>
                    
                </div>
                <div class="col-lg-2">
                    <div class="title-action">
                       <a href="{{URL::route('dealerprintcsv',$customer->id)}}" target="_blank" class="btn btn-primary"><i class="fa fa-download"></i> Download CSV </a>
                   </div>
               </div>
               <div class="col-lg-2">
                <div class="title-action">
                   <a href="{{URL::route('dealerprint',$customer->id)}}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Details </a>
               </div>
           </div>

       </div>
       <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="ibox-content p-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>{{$customer->name}}</h5>
                            <address>
                                <strong>{{$customer->email}}</strong><br>

                                <abbr title="Phone">Contact:</abbr>  {{$customer->contact}}
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title">
                                    <h5>Customers</h5>
                                </div>
                                <div class="ibox-content">
                                    <input type="text" class="form-control input-sm m-b-xs" id="filter"
                                    placeholder="Search in table">

                                    <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                                        <thead>
                                            <tr>

                                                <th>Vehicle Number</th>
                                                <th >Name</th>
                                                <th >E-mail</th>
                                                <th >Contact</th>
                                                <th>Volume Filled</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($custs)
                                            @foreach($custs as $t)
                                            <tr class="gradeX">

                                                <td><a href = "{{URL::route('customers',$t->id)}}">{{$t->vehicle_number}}</a></td>
                                                <td>{{$t->name}}</td>
                                                <td class="center">{{$t->email}}</td>
                                                <td class="center">{{$t->contact}}</td>
                                                <td class="center">{{$t->total_volume}}</td>


                                            </tr>
                                            @endforeach
                                            @else
                                            <tr class="gradeX">
                                                <td colspan="6"><center>NO CUSTOMERS ADDED YET</center></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">
                                                    <ul class="pagination pull-right"></ul>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>
</div>

@include('js')
@if(Session::has('check'))
@if(Session::get('check'))
<script type="text/javascript">
$(window).load(function(){
    $('#check').modal('show');
});
</script>
@endif
@endif
@if(Session::has('success'))
<script>
$(document).ready(function() {
    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.success("{{Session::get('success')}}");

    }, 1300);

});
</script>
@endif

@if(Session::has('failure'))
<script>
$(document).ready(function() {
    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.error("{{Session::get('failure')}}");

    }, 1300);

});
</script>
@endif



</body>

</html>
