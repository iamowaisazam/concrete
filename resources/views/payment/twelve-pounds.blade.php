<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay £12</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyfQPSDccLnRgYibVwvBGlcWf0ZASjGPwFVDzPAyOI9cgxnOTyCwNBpjQm8" crossorigin="anonymous">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        /* Custom styling for Stripe Element containers */
        .stripe-element {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.75rem 0.75rem; /* Adjusted padding for better appearance */
            height: calc(1.5em + 0.75rem + 2px); /* Match Bootstrap input height */
            background-color: white;
        }

        /* Style for error messages */
        .error {
            color: #dc3545; /* Bootstrap danger color */
            margin-top: 0.5rem;
            font-size: 0.875em;
        }

        /* Ensure labels have some bottom margin */
        .form-label {
            margin-bottom: 0.5rem;
        }

        /* Adjust card body padding if needed */
        .card-body {
            padding: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h1 class="mb-0 h4">Secure Payment of £12</h1> </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('process.payment') }}" method="POST" id="payment-form">
                            @csrf

                            <div class="mb-3">
                                <label for="card-number-element" class="form-label">
                                    Card Number
                                </label>
                                <div id="card-number-element" class="stripe-element">
                                    </div>
                            </div>

                            <div class="mb-3">
                                <label for="card-expiry-element" class="form-label">
                                    Expiration Date (MM/YY)
                                </label>
                                <div id="card-expiry-element" class="stripe-element">
                                    </div>
                            </div>

                            <div class="mb-3">
                                <label for="card-cvc-element" class="form-label">
                                    CVC
                                </label>
                                <div id="card-cvc-element" class="stripe-element">
                                    </div>
                            </div>

                            <div class="mb-3">
                                <label for="postal-code-element" class="form-label">
                                    Postal Code
                                </label>
                                <div id="postal-code-element" class="stripe-element">
                                    </div>
                            </div>

                            <div id="card-errors" class="error" role="alert"></div>

                            <button class="btn btn-success w-100 mt-3">Pay £12</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        // Initialize Stripe with your publishable key
        var stripe = Stripe('{{ env('STRIPE_PUBLISHABLE_KEY') }}');
        var elements = stripe.elements();

        // Custom styling for Stripe Elements (optional, but recommended)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create and mount individual Stripe Elements
        var cardNumberElement = elements.create('cardNumber', {style: style});
        cardNumberElement.mount('#card-number-element');

        var cardExpiryElement = elements.create('cardExpiry', {style: style});
        cardExpiryElement.mount('#card-expiry-element');

        var cardCvcElement = elements.create('cardCvc', {style: style});
        cardCvcElement.mount('#card-cvc-element');

        var postalCodeElement = elements.create('postalCode', {
            style: style,
            placeholder: 'e.g. SW1A 1AA' // Example placeholder
        });
        postalCodeElement.mount('#postal-code-element');

        // Handle real-time validation errors from the card Elements.
        cardNumberElement.on('change', function(event) {
            displayError(event);
        });
        cardExpiryElement.on('change', function(event) {
            displayError(event);
        });
        cardCvcElement.on('change', function(event) {
            displayError(event);
        });
        postalCodeElement.on('change', function(event) {
            displayError(event);
        });
        
        function displayError(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        }


        // Get the form and button elements
        var form = document.getElementById('payment-form');
        var cardErrors = document.getElementById('card-errors');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Disable the submit button to prevent multiple submissions
            form.querySelector('button').disabled = true;

            stripe.createToken(cardNumberElement).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    cardErrors.textContent = result.error.message;
                    // Re-enable the submit button
                    form.querySelector('button').disabled = false;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submits the token to your server
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>
</body>
</html>
