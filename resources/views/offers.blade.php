<!DOCTYPE html>
<html>

<head>
    @include('header')
</head>

<body>
    <div id="wrapper">
        @include('leftnavigation_dealer')
        <div id="page-wrapper" class="gray-bg dashbard-1">
           @include('topnavigation')


           <div class="wrapper wrapper-content animated fadeIn">
               <div class="signup-form" id="error">
                @if($errors->has())
                <p>
                  {{$errors->first('amount',':message')}} </p>
                  <p>  {{$errors->first('percent',':message')}} </p>
                  <p>  {{$errors->first('type',':message')}} </p>
                  <p>  {{$errors->first('email',':message')}} </p>
                  <p>  {{$errors->first('password',':message')}} </p>
                  <p>  {{$errors->first('city',':message')}} </p>
                  <p>  {{$errors->first('pump_name',':message')}} </p>
                  
                  @endif
              </div>


              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Offers list</h5>
                            <div class="ibox-tools">
                                <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal5">Add new offer</a>


                            </div>
                        </div>
                        <div class="ibox-content">
                            <input type="text" class="form-control input-sm m-b-xs" id="filter"
                            placeholder="Search in table">

                            <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                                <thead>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Discount Type</th>
                                        <th>Discounts</th>
                                        <th>Discount Volume</th>
                                        <th>Discount On</th>



                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($offers))
                                    <?php $i = 1;?>
                                    @foreach($offers as $offer)
                                    <tr class="gradeX">
                                        <td>{{$i}}</td>
                                        <td>{{$offer->type}}</td>
                                        @if($offer->type=="rupees")
                                        <td>&#8377;{{$offer->discount_objects}}</td>
                                        @elseif($offer->type =="item_list")
                                        <td>{{$offer->quantity}}*{{$offer->discount_objects}}</td>
                                        @else
                                        <td>{{$offer->discount_percent}} %</td>
                                        @endif
                                        <td>{{$offer->discount_volume}}</td>

                                        <td>{{$offer->refill_type}}</td>

                                        <td><a href = "{{URL::route('delete_offer',$offer->id)}}"class="btn btn-outline btn-danger" type="button">
                                            <i class="fa fa-trash-o"></i> <span class="bold">Delete</span>
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                                @else
                                <tr class="gradeX">
                                    <td colspan="5"><center>NO OFFER ADDED</center></td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
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
    <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Add New Offer</h4>
                </div>
                <form method="post" action = "{{URL::route('add_offer')}}" class="form-horizontal" novalidate>
                    {{csrf_field()}}

                    <div class="modal-body">
                        <div class="form-group"><label class="col-sm-2 control-label">Discount On :</label>

                            <div class="col-sm-10"><select class="form-control m-b" required name="refill_type" onchange = "handler()" id="refill">
                                <option value = "" >Select Refill Type</option>
                                <option value = "ft">First Timers</option>
                                <option value = "diesel">Diesel</option>
                                <option value = "petrol">Petrol</option>
                                <option value = "speed">Speed</option>
                                <option value = "reference">Reference</option>


                            </select>
                        </div>
                    </div>



                    <div class="form-group"><label class="col-sm-2 control-label">Type of Offer in :</label>

                        <div class="col-sm-10"><select class="form-control m-b" required name="type" onchange = "hider()" id = "type">
                            <option value = "" >Select Type</option>
                            <option value = "rupees">Rupees</option>
                            <option value = "percent">Percent</option>
                            <option value = "item_list">Item</option>
                        </select>
                    </div>
                </div>


                <div id = "amt" class="form-group"><label class="col-sm-2 control-label">Offer Availability</label>

                    <div class="col-sm-10">
                        <div class="input-group m-b"><input type="text" name = "discount_volume" id ="amount" placeholder = "Discount Available After Specified Amount Of Fuel Purchase" required  class="form-control"> <span class="input-group-addon">Liters</span></div>
                    </div>
                </div>

                <div style = "display:none;" id = "percent_disc" class="form-group"><label class="col-sm-2 control-label">Discount Percentage</label>

                    <div class="col-sm-10">
                        <div class="input-group m-b"><input type="text" class="form-control" name = "discount_percent" id ="percent" maxlength = "2" placeholder = "Percentage Of Discount" required> <span class="input-group-addon">%</span></div>
                    </div>
                </div>

                <div style = "display:none;" id = "rupees_disc" class="form-group"><label class="col-sm-2 control-label">Discount Rupees</label>

                    <div class="col-sm-10">
                        <div class="input-group m-b"><input type="text" class="form-control" name = "discount_rupees" id ="rupees" maxlength = "5" placeholder = "Amount of Discount" required> <span class="input-group-addon">&#8377;</span></div>
                    </div>
                </div>
                <div style = "display:none;" id = "item_disc" class="form-group"><label class="col-sm-2 control-label">Discount item</label>

                    <div class="col-sm-10">
                       <div class="col-sm-10"><select class="form-control m-b" onchange ="checkitem()"  required name="item_list" id = "item_list">
                        <option value = "" >Select Item</option>
                       
                        @foreach($items as $item)
                        <option value = "{{$item->id}}">{{$item->item}}</option>
                        @endforeach
                    </select>
                </div>



            </div>
        </div>
        <div style = "display:none;" id = "item_qty" class="form-group"><label class="col-sm-2 control-label">Quantity</label>

            <div class="col-sm-10">
               <div class="col-sm-10"><select class="form-control m-b" required name="quantity" id = "qty">
            </select>
        </div>



    </div>
</div>


<input type = "hidden" name = "_token" id = "token" value = "{{csrf_token()}}">
</div>
<div class="modal-footer">
    <button type="submit"  class="btn btn-primary">Add</button>
</div>
</form>
</div>
</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content">
            <div class="row">

            </div>
        </div>
        @include('footer')
    </div>
</div>

</div>
</div>

@include('js')
<!-- FooTable -->
<script src="js/plugins/footable/footable.all.min.js"></script>
<script>
$(document).ready(function() {

    $('.footable').footable();
    $('.footable2').footable();


});

function handler() {
    var str = document.getElementById("refill").value; 
    if(!str.localeCompare("ft")||!str.localeCompare("reference")){
        document.getElementById("amount").value = "0";
        $('#amt').hide();
    }else{
        document.getElementById("amount").value = "";
        $('#amt').show();
        
    }
    
}

function checkitem(){
    var str = document.getElementById('item_list').value;
    jQuery.ajax({
      url:"{{URL::route('item_list')}}",
      type:"post",
      data: {'item_id':str,'_token':jQuery('#token').val()},
      success:function(data){
            $('#qty')
            .find('option')
            .remove()
            .end();
            for( var i = data; i > 0;i--){
                $('#qty').append($('<option>', {
                    value: i,
                    text: i
                }));
            }
        
    }
});
}
function hider(){
    var str = document.getElementById("type").value;
    if(!str.localeCompare("rupees")){
        document.getElementById("percent").value = "0";
        document.getElementById("item_list").value = "";
        document.getElementById("qty").value = "";
        $('#percent_disc').hide();
        $('#item_disc').hide();
        $('#rupees_disc').show();
        $('#item_qty').hide();
    }
    else if(!str.localeCompare("percent")){
     document.getElementById("rupees").value = "0";
     document.getElementById("item_list").value = "";
     document.getElementById("qty").value = "";
     $('#percent_disc').show();
     $('#item_disc').hide();
     $('#rupees_disc').hide();
     $('#item_qty').hide();
 }
 else if(!str.localeCompare("item_list")){
  console.log(qty);
     document.getElementById("rupees").value = "0";
     document.getElementById("percent").value = "0";
     document.getElementById("qty").value = "";
     $('#percent_disc').hide();
     $('#item_disc').show();
     $('#rupees_disc').hide();
     $('#item_qty').show();
 }
 else{
   document.getElementById("rupees").value = "0";
   document.getElementById("percent").value = "0";
   document.getElementById("item_list").value = "";
   document.getElementById("qty").value = "";

   $('#percent_disc').hide();
   $('#item_disc').hide();
   $('#rupees_disc').hide();
   $('#item_qty').hide();
}
}
</script>


<script>
document.getElementById('amount').addEventListener('keydown', function(e)
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


document.getElementById('percent').addEventListener('keydown', function(e)
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
