<!DOCTYPE html>
<html>

<head>
    @include('header')
</head>

<body class="white-bg">
    <div class="wrapper wrapper-content p-xl">
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
            <div class="table-responsive m-t">
                <table class="table invoice-table">
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

                        <td>{{$t->vehicle_number}}</td>
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
            </table>
        </div><!-- /table-responsive -->
    </div>

</div>

<!-- Mainly scripts -->
@include('js')

<script type="text/javascript">
window.print();
</script>

</body>

</html>
