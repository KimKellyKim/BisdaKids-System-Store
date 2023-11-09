<html>

<head>
    <title>trial paymongo gcash bisdakids</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        @media (min-width: 1200px) {
            .container {
                max-width: 780px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Billing address</h4>
                <form class="needs-validation" method="GET" action="paymongo.php">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">Username</label>
                            <input type="text" class="form-control" name="firstName" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                            <div class="invalid-feedback"> Valid first name is required. </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" name="price" value="450000">
                        <div class="invalid-feedback"> Please enter a valid mobile number for shipping updates. </div>
                    </div>
                    <div class="mb-3">
                        <label for="email">Mobile</label>
                        <input type="number" class="form-control" name="mobile" value="639171234567">
                        <div class="invalid-feedback"> Please enter a valid mobile number for shipping updates. </div>
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" value="kingpauloaquino@gmail.com">
                        <div class="invalid-feedback"> Please enter a valid email address for shipping updates. </div>
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
