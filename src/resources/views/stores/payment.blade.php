@extends('layouts.app')

@section('content')
<div class="container">
    <?php if (session('flash_alert')): ?>
        <div class="error-message"><?= session('flash_alert') ?></div>
    <?php elseif (session('status')): ?>
        <div class="success-message"><?= session('status') ?></div>
    <?php endif; ?>

    <div class="payment-form-container">
        <h2>Stripe決済</h2>
        <form id="card-form" action="{{ route('store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="card-number">カード番号</label>
                <div id="card-number" class="input-field"></div>
            </div>

            <div class="form-group">
                <label for="card-expiry">有効期限</label>
                <div id="card-expiry" class="input-field"></div>
            </div>

            <div class="form-group">
                <label for="card-cvc">セキュリティコード</label>
                <div id="card-cvc" class="input-field"></div>
            </div>

            <div id="card-errors" class="error-text"></div>

            <button class="submit-button" type="submit">支払い</button>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    /* Stripeの基本設定 */
    const stripePublicKey = "{{ config('stripe.stripe_public_key') }}";
    const stripe = Stripe(stripePublicKey);
    const elements = stripe.elements();

    const cardNumber = elements.create('cardNumber');
    cardNumber.mount('#card-number');

    cardNumber.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        displayError.textContent = event.error ? event.error.message : '';
    });

    const cardExpiry = elements.create('cardExpiry');
    cardExpiry.mount('#card-expiry');

    const cardCvc = elements.create('cardCvc');
    cardCvc.mount('#card-cvc');

    const form = document.getElementById('card-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        stripe.createToken(cardNumber).then(function(result) {
            if (result.error) {
                document.getElementById('card-errors').textContent = result.error.message;
            } else {
                stripeTokenHandler(result.token);
            }
        });
    });

    function stripeTokenHandler(token) {
        const form = document.getElementById('card-form');
        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        form.submit();
    }
</script>

@endsection