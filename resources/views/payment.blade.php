@extends('layouts.auth', ['title' => __('Make Payment!'), 'description' => '[lan name]', 'width' => 'col-3', 'step' => 'Payment'])

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

{{ __('Make Payment!') }}

<form action="{{route('processPayment', ['plan' => request()->plan])}}" method="POST" id="subscribe-form">
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <div class="subscription-option">
                    <label for="plan-silver">
                        <span class="plan-price">${{$price}}</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <label for="card-holder-name">Card Holder Name</label>
    <input id="card-holder-name" class="form-control" type="text" value="{{$user->name}}" disabled>
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
        <button type="button" id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-primary d-grid w-100">Make Payment</button>
    </div>
</form>
<script src="https://js.stripe.com/v3/"></script>
<script>
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
    console.log(document.getElementById('card-element'));
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
</script>

@endsection
