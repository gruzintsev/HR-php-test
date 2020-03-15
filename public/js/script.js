$('.product .product-price').click(function (event) {
    $(this).find('.product-price-value').addClass('hidden');
    $(this).find('.product-price-form').removeClass('hidden');
});

$(".product-price-form").submit(function (e) {
    e.preventDefault();

    var form = $(this);

    $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: form.serialize(),
        success: function (data) {
            form.next('.product-price-value')
                .html(form.find('input[name="price"]').val())
                .removeClass('hidden');
            form.addClass('hidden');
        },
        error: function (error) {
            alert(error.responseJSON.message);
        }
    });
});