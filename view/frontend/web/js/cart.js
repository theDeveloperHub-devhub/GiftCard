require(['jquery'], function($) {
    $(document).ready(function() {
        $('.add-to-cart-button').on('click', function() {
            var qty = $('#qty').val();

            var data = {
                cartItem: {
                    sku: '',
                    qty: qty,
                    quoteId: '',
                    productOption: {
                        extensionAttributes: {
                            customAttributes: []
                        }
                    }
                }
            };

            $.ajax({
                url: '/rest/V1/carts/mine/items',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    console.log('Product added to cart successfully');
                    // Optionally, you can redirect to the cart page or perform any other actions
                },
                error: function(xhr, status, error) {
                    console.log('Failed to add product to cart');
                    // Handle errors
                }
            });
        });
    });
});
