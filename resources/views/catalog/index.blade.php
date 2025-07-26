<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Product Catalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="display-5 text-center mb-4"> Product Catalog</h1>
        <form id="product-form" class="bg-white p-4 rounded shadow mb-5">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="product_name" class="form-control" placeholder="Product Name" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="quantity" class="form-control" placeholder="Quantity in Stock" required min="0">
                </div>
                <div class="col-md-4">
                    <input type="number" name="price" class="form-control" placeholder="Price per Item" step="0.01" required min="0">
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">➕ Add Product</button>
            </div>
        </form>
        <div class="bg-white p-3 rounded shadow overflow-auto">
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Datetime</th>
                        <th scope="col">Total Value</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="product-table">
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Total Inventory Value:</td>
                        <td id="grand-total" class="fw-bold text-success">0.00</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function loadData() {
            $.get('/fetch', function(response) {
                let html = '';
                response.products.forEach(function(item) {
                    html += `
                        <tr data-id="${item.id}">
                            <td><input class="product_name form-control" value="${item.product_name}" /></td>
                            <td><input class="quantity form-control" type="number" value="${item.quantity}" min="0" /></td>
                            <td><input class="price form-control" type="number" step="0.01" value="${item.price}" min="0" /></td>
                            <td>${item.submitted_at}</td>
                            <td>${(item.quantity * item.price).toFixed(2)}</td>
                            <td>
                                <button class="update-btn btn btn-sm btn-warning">Update</button>
                            </td>
                        </tr>
                    `;
                });
                $('#product-table').html(html);
                $('#grand-total').text(response.total_value.toFixed(2));
            });
        }
        $(document).ready(function() {
            loadData();
            $('#product-form').submit(function(e) {
                e.preventDefault();
                $.post('/store', $(this).serialize(), function() {
                    $('#product-form')[0].reset();
                    loadData();
                });
            });
            $(document).on('click', '.update-btn', function() {
                const row = $(this).closest('tr');
                const id = row.data('id');
                const data = {
                    id: id,
                    product_name: row.find('.product_name').val(),
                    quantity: row.find('.quantity').val(),
                    price: row.find('.price').val()
                };
                $.post('/update', data, function() {
                    loadData();
                });
            });
        });
    </script>
</body>
</html>