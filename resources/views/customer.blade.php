<!DOCTYPE html>
<html>

<head>

    @include('header')
    
</head>

<body>

    <div id="wrapper">
        @if(Auth::user()->level > 5)
        @include('leftnavigation_admin')
        @else
        @include('leftnavigation_dealer')
        @endif
        <div id="page-wrapper" class="gray-bg">
            @include('topnavigation')

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2>Customer</h2>
                    
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
                     <a href="{{URL::route('customerprint',$customer->id)}}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Details </a>
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

                                    Total Volume Filled: {{$customer->total_volume}}<br>
                                    <abbr title="Phone">Contact:</abbr>  {{$customer->contact}}
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h5>Transactions</h5>
                                    </div>
                                    <div class="ibox-content">
                                        <input type="text" class="form-control input-sm m-b-xs" id="filter"
                                        placeholder="Search in table">

                                        <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                                            <thead>
                                                <tr>

                                                    <th>Vehicle Number</th>
                                                    <th >Type</th>
                                                    <th >Volume filled</th>
                                                    <th >Cost</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($transactions)
                                                @foreach($transactions as $t)
                                                <tr class="gradeX">

                                                    <td>{{$t->vehicle_number}}</td>
                                                    <td>{{$t->type}}</td>
                                                    <td class="center">{{$t->volume}}</td>
                                                    <td class="center">{{$t->total_cost}}</td>
                                                    <td class="center">{{$t->created_at}}</td>


                                                </tr>
                                                @endforeach
                                                @else
                                                <tr class="gradeX">
                                                    <td colspan="6"><center>NO TRANSACTIONS DONE YET</center></td>
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
<script type="text/javascript">

document.getElementById('diesel').addEventListener('keydown', function(e)
{
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
             (e.keyCode == 65 && e.ctrlKey === true) ||
             // Allow: Ctrl+C
             (e.keyCode == 67 && e.ctrlKey === true) ||
             // Allow: Ctrl+X
             (e.keyCode == 88 && e.ctrlKey === true) ||
             // Allow: home, end, left, right
             (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
             return;
         }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

document.getElementById('speed').addEventListener('keydown', function(e)
{
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
             (e.keyCode == 65 && e.ctrlKey === true) ||
             // Allow: Ctrl+C
             (e.keyCode == 67 && e.ctrlKey === true) ||
             // Allow: Ctrl+X
             (e.keyCode == 88 && e.ctrlKey === true) ||
             // Allow: home, end, left, right
             (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
             return;
         }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });


document.getElementById('petrol').addEventListener('keydown', function(e)
{
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
             (e.keyCode == 65 && e.ctrlKey === true) ||
             // Allow: Ctrl+C
             (e.keyCode == 67 && e.ctrlKey === true) ||
             // Allow: Ctrl+X
             (e.keyCode == 88 && e.ctrlKey === true) ||
             // Allow: home, end, left, right
             (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
             return;
         }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

</script>

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
