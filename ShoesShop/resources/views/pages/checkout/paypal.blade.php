
<form action="{{URL::to('create-payment')}}" method="post">

@csrf
<input name="submit" type="image" id="paypalbtn" src="https://www.paypalobjects.com/webstatic/en_AU/i/buttons/btn_paywith_primary_m.png" value="PayPal">
</form> 

