$(document).ready(function () {
    $('#category_id').on('change', function () {
        var categoryId = $(this).val();

        if (categoryId) {
            $.ajax({
                url: getSubcategoriesUrl, // use variable from Blade
                type: "GET",
                data: {
                    id: categoryId
                },
                success: function (data) {
                    console.log("Subcategories fetched:", data);

                    $('#sub_category_id').html('<option value="">Select Subcategory</option>');

                    $.each(data, function (index, item) {
                        $('#sub_category_id').append(
                            `<option value="${item.id}">${item.name}</option>`
                        );
                    });
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                }
            });
        } else {
            $('#sub_category_id').html('<option value="">Select Subcategory</option>');
        }
    });
});

$(document).ready(function () {
    $('#myForm').validate({
        rules: {
            name: {
                required: true,
            },
            category_id: {
                required: true,
            },
            sub_category_id: {
                required: true,
            },
            brand_id: {
                required: true,
            },
            code: {
                required: true,
            },
            sku: {
                required: true,
            },
            qty: {
                required: true,
            },
            receiving_date: {
                required: true,
            },
            description: {
                required: true,
            },
            photo: {
                required: true,
            },
        },
        messages: {
            name: {
                required: 'Please Enter Name',
            },
            category_id: {
                required: 'Please Category',
            },
            sub_category_id: {
                required: 'Please Select Sub-Category',
            },
            code: {
                required: 'Please Enter Code',
            },
            brand_id: {
                required: 'Please Enter Brand',
            },
            sku: {
                required: 'Please Enter SKU',
            },
            receiving_date: {
                required: 'Please Receiving Date',
            },
            qty: {
                required: 'Please Enter Quantity',
            },
            description: {
                required: 'Please Enter Description',
            },
            description: {
                required: 'Please Upload Photo',
            },

        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
    });
});