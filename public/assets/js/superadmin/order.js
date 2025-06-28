let productCount = 1;

$(document).ready(function() {
    // Initialize select2 if available
    if ($.fn.select2) {
        $('.select2').select2({
            width: '100%'
        });
    }

    // Add product button click
    $('#addProductBtn').click(function() {
        addProductRow();
    });

    // Auto-fill shipping details from customer profile
    $('#user_id').change(function() {
        const customerId = $(this).val();
        if (customerId) {
            $.get(`/api/customers/${customerId}/shipping-info`)
                .done(function(data) {
                    if (data.success) {
                        const customerProfile = data.data;
                        $('#shipping_details_recipient_name').val(customerProfile.name);
                        $('#shipping_details_phone_number').val(customerProfile.phone_number);
                        $('#shipping_details_address_line1').val(customerProfile.address);
                        $('#shipping_details_city').val(customerProfile.city);
                        $('#shipping_details_state').val(customerProfile.state);
                        $('#shipping_details_postal_code').val(customerProfile.postal_code);
                        $('#shipping_details_country').val(customerProfile.country);
                    }
                });
        }
    });

    // Form validation before submit
    $('#createOrderForm').submit(function(e) {
        // Check if at least one product is added
        const validProducts = $('select[name$="[product_id]"]').filter(function() {
            return $(this).val() !== '';
        }).length;

        if (validProducts === 0) {
            e.preventDefault();
            alert('Please add at least one product to the order.');
            return false;
        }

        return true;
    });
});

// Add a new product row
function addProductRow() {
    const template = document.getElementById('product-template').innerHTML;
    const newRow = template.replace(/INDEX/g, productCount);
    $('.product-items').append(newRow);

    // Show the remove button for all product items
    $('.remove-product').show();

    // Initialize select2 for the new select if available
    if ($.fn.select2) {
        $('.product-select').select2({
            width: '100%'
        });
    }

    productCount++;
}

// Remove a product row
function removeProduct(button) {
    $(button).closest('.product-item').remove();

    // If only one product item left, hide its remove button
    if ($('.product-item').length === 1) {
        $('.remove-product').hide();
    }

    // Recalculate totals
    calculateOrderTotals();
}

// Update product details when product is selected
function updateProductDetails(selectElement, index) {
    const selectedOption = $(selectElement).find('option:selected');
    const price = selectedOption.data('price');

    const row = $(selectElement).closest('.product-item');
    row.find('.price-input').val(price);

    calculateSubtotal(index);
}

// Calculate subtotal for a product
function calculateSubtotal(index) {
    const price = parseFloat($(`input[name="items[${index}][price]"]`).val()) || 0;
    const quantity = parseInt($(`input[name="items[${index}][quantity]"]`).val()) || 0;

    // Calculate order totals
    calculateOrderTotals();
}

// Calculate order totals
function calculateOrderTotals() {
    let subtotal = 0;

    $('.product-item').each(function() {
        const price = parseFloat($(this).find('.price-input').val()) || 0;
        const quantity = parseInt($(this).find('.quantity-input').val()) || 0;
        subtotal += price * quantity;
    });

    // Calculate tax (5%)
    const taxRate = 0.05;
    const tax = subtotal * taxRate;

    // Get shipping and discount
    const shipping = parseFloat($('#shipping-input').val()) || 0;
    const discount = parseFloat($('#discount-input').val()) || 0;

    // Calculate total
    const total = subtotal + tax + shipping - discount;

    // Update displayed values
    $('#subtotal').text(subtotal.toFixed(2));
    $('#tax').text(tax.toFixed(2));
    $('#total').text(total.toFixed(2));

    // Update hidden inputs
    $('#subtotal-input').val(subtotal.toFixed(2));
    $('#tax-input').val(tax.toFixed(2));
    $('#total-input').val(total.toFixed(2));
}

// Calculate total when shipping or discount changes
function calculateTotal() {
    calculateOrderTotals();
}
