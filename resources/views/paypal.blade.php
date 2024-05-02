@extends('layouts.auth', ['title' => __('Make Payment!'), 'description' => '[lan name]', 'width' => 'col-md-6', 'step' => 'Payment'])

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if (config('paypal.mode') == 'sandbox')
        <div class="alert alert-warning" role="alert">
            This is a sandbox environment, please do not use your real credit/debit card or paypal account.
        </div>
    @endif

    <div class="row">
        <div class="col-md-6" style="border-right: 1px solid rgba(100,100,100,0.1);">
            <form action="{{ route('processPayment', ['plan' => request()->plan]) }}" method="POST" id="subscribe-form">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="subscription-option">
                                <label for="plan-type">
                                    Select team type
                                </label>

                                <select name="plan-type" id="plan-type" class="form-select mb-2"
                                    onchange="$(this).planTypeChanged()">
                                    @foreach ($plan['prices'] as $price_name => $plan_amount)
                                        <option value="{{ $price_name }}">
                                            {{ $price_name . ' $' . $plan_amount['Price'] . ' ' . $plan_amount['Note'] ?? '' }}
                                        </option>
                                    @endforeach
                                </select>

                                @if (isset($plan['prices']['Group']))
                                    <div id="group-members" style="display: none;">
                                        <label for="members">
                                            Select group members
                                        </label>
                                        <input type="number" name="members" id="members" value=""
                                            onchange="$(this).calculateTotal({{ $plan['prices']['Group']['Price'] }})"
                                            max="{{ $plan['prices']['Group']['MaxMembers'] }}" min="1"
                                            class="form-control">
                                        X $ {{ $plan['prices']['Group']['Price'] }} <span id="total"> = $80</span>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div id="paypal-button-container"></div>



            {{-- <form action="{{ route('processPayment', ['plan' => request()->plan]) }}" method="POST" id="subscribe-form">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <div class="subscription-option">
                        <label for="plan-type">
                            Select team type
                        </label>

                        <select name="plan-type" id="plan-type" class="form-control" onchange="$(this).planTypeChanged()">
                            @foreach ($plan['prices'] as $price_name => $plan_amount)
                                <option value="{{ $price_name }}">
                                    {{ $price_name . ' $' . $plan_amount['Price'] . ' ' . $plan_amount['Note'] ?? '' }}</option>
                            @endforeach
                        </select>

                        <div id="group-members" style="display: none;">
                            <label for="members">
                                Select group members
                            </label>
                            <input type="number" name="members" id="members" value="" onchange="$(this).calculateTotal({{ $plan['prices']['Group']['Price'] }})"
                                max="{{ $plan['prices']['Group']['MaxMembers'] }}" min="1" class="form-control"> X $  {{ $plan['prices']['Group']['Price'] }} <span id="total"> = $80</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <label for="card-holder-name">Card Holder Name</label>
        <input id="card-holder-name" class="form-control" type="text" value="{{ $user->name }}" required>
        @csrf
        <div class="form-row">
            <label for="card-element">Credit or debit card</label>
            <div id="card-element" class="form-control"> </div>
            <!-- Used to display form errors. -->
            <div id="card-errors" role="alert"></div>
        </div>
        <div class="stripe-errors"></div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif
        <div class="form-group text-center mt-3">
            <button type="button" id="card-button" data-secret="{{ $intent->client_secret }}"
                class="btn btn-primary d-grid w-100">Make Payment</button>
        </div>
        </form> --}}

        </div>
        <div class="col-md-6">
        <p>Pay with confidence with our <b>encrypted</b> payment system.</p>
                {{-- <hr style="border: 1px solid rgba(100,100,100,0.1);margin-top: 15px; width: 100%;" /> --}}
            <div class="d-flex justify-content-center align-items-center" style="flex-direction: column; margin-top: 2rem">

                {{-- <div class="text-center text-sm sm:text-center"> --}}
                <img src="{{ asset('images/cards.png') }}" alt="all payment cards">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('images/secure.png') }}" style="max-width: 110px;" alt="100% secure">
                    <img src="{{ asset('images/ssl-secure.png') }}" style="max-height: 120px;" alt="100% secure">

                </div>


                {{-- </div> --}}

                {{-- <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                    Copyright &copy; <?php echo date('Y'); ?> The United Production.<br/>All rights reserved. Powered by Cizzara Studios.
                </div> --}}
            </div>
        </div>
    </div>
    {{-- <script src="https://js.stripe.com/v3/"></script> --}}

    {{-- <script>
        var stripe = Stripe("{{ env('STRIPE_KEY') }}");
        var elements = stripe.elements();
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
        var card = elements.create('card', {
            hidePostalCode: true,
            style: style
        });
        card.mount('#card-element');
        //console.log(document.getElementById('card-element'));
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;
        cardButton.addEventListener('click', async (e) => {
            console.log("attempting payment");
            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: card,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );
            if (error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                paymentMethodHandler(setupIntent.payment_method);
            }
        });

        function paymentMethodHandler(payment_method) {
            var form = document.getElementById('subscribe-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'payment_method');
            hiddenInput.setAttribute('value', payment_method);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script> --}}
@endsection

@section('bottom')
    <script>
        $.fn.planTypeChanged = function() {
            $('#group-members').hide();
            $('#members').attr('required', false).val('');
            if ($(this).val() == 'Group') {
                $('#group-members').show();
                $('#members').attr('required', true);
            }
        };
        $.fn.calculateTotal = function(price) {
            var total = 0;
            total = parseFloat(price) * $('#members').val();
            $('#total').html(' = $' + total.toFixed(2));
        }
    </script>

    <script
        src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.sandbox.client_id') }}&currency={{ config('paypal.currency') }}">
    </script>

    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return fetch("{{ route('paypal.create') }}", {
                    method: 'POST',
                    body: JSON.stringify({
                        'plan': "{{ request()->plan }}",
                        //'user_id' : "{{ auth()->user()->id }}",
                        'members': $("#members").val(),
                        'plan_type': $("#plan-type").val(),
                    })
                }).then(function(res) {
                    //res.json();
                    return res.json();
                }).then(function(orderData) {
                    //console.log(orderData);
                    return orderData.id;
                });
            },

            // Call your server to finalize the transaction
            onApprove: function(data, actions) {
                console.log(data);
                return fetch("{{ route('paypal.capture') }}", {
                    method: 'POST',
                    body: JSON.stringify({
                        orderId: data.orderID,
                        //'plan': "{{ request()->plan }}",
                        //payment_gateway_id: $("#payapalId").val(),
                        //user_id: "{{ auth()->user()->id }}",
                    })
                }).then(function(res) {
                    // console.log(res.json());
                    return res.json();
                }).then(function(orderData) {

                    // Successful capture! For demo purposes:
                    //  console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    //var transaction = orderData.purchase_units[0].payments.captures[0];

                    alert('Payment completed, you can now upload your video!');
                    window.location.reload();

                });
            }

        }).render('#paypal-button-container');
    </script>
@endsection
