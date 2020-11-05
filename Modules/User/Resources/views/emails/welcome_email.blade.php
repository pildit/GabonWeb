Hey {{$firstname}}, Welcome to our website. <br>
Please click <a href="{!! url('/account/confirmation', ['token'=>$activationcode]) !!}"> Here</a> to confirm email
