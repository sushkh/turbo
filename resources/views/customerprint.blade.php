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
                                    Total Volume Filled: {{$customer->total_volume}}<br>
                                    <abbr title="Phone">Contact:</abbr>  {{$customer->contact}}
                                </address>
                            </div>
                            </div>
                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
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
