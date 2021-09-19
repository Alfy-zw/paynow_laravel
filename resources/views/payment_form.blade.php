<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Paynow || laravel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


</head>

<body class="antialiased">
    <div class="center">
        <div class="card">
            <div class="card-body">
                <form action="" id="check_out">
                    @csrf
                    <img src="images/logo.jpg" alt="Avatar" class="avatar">
                    <br><br>
                    <h5 class="card-title text text-muted">Paynow Checkout</h5>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Mobile number</label>
                        <input type="text" class="form-control" id="mobileNumber" placeholder="Mobile number"
                            aria-describedby="mobileNumberHelp" required>
                        <div id="mobileNumberHelp" class="form-text">07x xxx xxxx</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="amount" placeholder="$0.00" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Check out </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>


<script>
$(document).ready(function() {
    $("#check_out").submit(function(e) {
        e.preventDefault();
       var mobileNumber =  document.getElementById('mobileNumber').value;
       var amount =  document.getElementById('amount').value;
       check_out(mobileNumber, amount);
    });
});

function check_out(mobileNumber, amount){
    //Ajax Function to send a get request
     alert('response will be logged to console')
  $.ajax({
    type: "get",
    url: "{{route('payment.process')}}",
    data: {mobileNumber: mobileNumber, amount:   amount},
    success: function(response){
        //if request if made successfully then the response represent the data
        console.log(response);
        alert(response);

        //form reset
        document.getElementById("check_out").reset();
    }
  });
  

}

</script>



<style>
body {
    font-family: 'Nunito', sans-serif;
    background-color: #fff;
    height: 100vh;
}

.center {
    width: 35%;
    right: 50%;
    bottom: 50%;
    transform: translate(50%, 50%);
    position: absolute;
}

.avatar {
    vertical-align: middle;
    width: 60px;
    height: 50px;
    border-radius: 50%;
}

/* On screens that are 992px or less, set the background color to blue */
@media screen and (max-width: 992px) {
    .center {
        width: 65%;
    }
}

/* On screens that are 600px or less, set the background color to olive */
@media screen and (max-width: 600px) {
    .center {
        width: 75%;
    }
}
</style>