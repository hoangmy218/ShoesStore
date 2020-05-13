<div id="paypal-button"></div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>

  paypal.Button.render({
    // Configure environment
    env: 'sandbox',
    client: {
      sandbox: 'AQByb9RaFErl1oTeyv5HUdRyfAEwBsly5WkpvXRdrhueFmjUtDzlAvdpvzFfRos6o_yngGomvCh3MtWR',
      production: 'demo_production_client_id'
    },
    // Customize button (optional)
    locale: 'en_US',
    style: {
      size: 'small',
      color: 'gold',
      shape: 'pill',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // Set up a payment
    payment: function(data, actions) {
      return actions.payment.create({

        redirect_urls:{
          return_url:'http://localhost/GitHub/ShoesShopWebsite/shoesshop/execute-payment'
        },

        transactions: [{
          amount: {
            total: '2',
            currency: 'USD'
          }
        }]
      });
    },
    // Execute the payment
    onAuthorize: function(data, actions) {
      //Trả về thông báo Thanh toán thành công và trang hiện tại
      // return actions.payment.execute().then(function() {
      //   // Show a confirmation message to the buyer
      //   window.alert('Thank you for your purchase!');
      // });

      //Đến trang sandbox
      return actions.redirect();
    }
  }, '#paypal-button');

</script>