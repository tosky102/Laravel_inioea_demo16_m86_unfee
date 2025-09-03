function openWidgetOrGoBank() {

    var payment_selector = $('.payment_selector:checked');

    if (payment_selector[0] == undefined) {
        alert('決済方法を選択してください。');
        return;
    }

    var point_selector = $('.point_selector:checked');

    if (point_selector[0] == undefined) {
        alert('購入ポイントを選択してください。');
        return;
    }

    if (payment_selector[0].value == 'bank_transfer') {
        goBank();
    } else if (payment_selector[0].value == 'credit_card') {
        openWidget();
    } else {

    }

}

function goBank() {
    $('#buyPointForm').submit();
}


function openWidget() {
    var point_selector = $('.point_selector:checked');

    var price = point_selector.data('price');
    var check_code = document.getElementById('check_code').value;
    var app_id = document.getElementById('app_id').value;
    if (price > 0) {

        var checkout = UnivapayCheckout.create({
            appId: app_id,
            checkout: "payment",
            paymentType: "card",
            amount: price,
            currency: "jpy",
            metadata: {
                'checkcode' : check_code
            },
            onSuccess: function (result) {
                var response = result.response;
                if (response.error == null) {
                    // Success
                    var response_id = response.id;
                    var price = response.chargedAmount;
                    var checkcode = response.metadata.checkcode;

                    location.href='/mypage/add_point?response_id=' + response_id + '&price=' + price + '&checkcode=' + checkcode;

                }
            }
        });

        checkout.open();

    }
}