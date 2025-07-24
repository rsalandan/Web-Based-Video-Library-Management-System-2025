$(document).ready(function () {
    $('#myForm').validate({
        rules: {
            name: {
                required: true
            },
            category_id: {
                required: true
            },
            sub_category_id: {
                required: true
            },
            brand_id: {
                required: true
            },
            code: {
                required: true
            },
            sku: {
                required: true
            },
            qty: {
                required: true
            },
            receiving_date: {
                required: true
            },
            description: {
                required: true
            },
            photo: {
                required: true
            },
        },
        messages: {
            name: {
                required: 'Please Enter Name'
            },
            category_id: {
                required: 'Please Select Category'
            },
            sub_category_id: {
                required: 'Please Select Sub-Category'
            },
            code: {
                required: 'Please Enter Code'
            },
            brand_id: {
                required: 'Please Select Brand'
            },
            sku: {
                required: 'Please Enter SKU'
            },
            receiving_date: {
                required: 'Please Enter Receiving Date'
            },
            qty: {
                required: 'Please Enter Quantity'
            },
            description: {
                required: 'Please Enter Description'
            },
            photo: {
                required: 'Please Upload Photo'
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

// This function should be accessible globally, so place it outside of $(document).ready().
function removeeventmore(button) {
    // Remove the closest <tr> which is the row containing the button
    $(button).closest('tr').remove();
}

$(document).ready(function () {
    // Add row dynamically when "Add More" is clicked
    $(document).on("click", ".addeventmore", function () {
        var request_date = $('#request_date').val();
        var user_id = $('#user_id').val();
        var user_name = $('#user_id option:selected').text();
        var product_id = $('#product_id').val();
        var product_name = $('#product_id option:selected').text();
        var quantity = $('#quantity').val();
        var reason = $('#reason').val();
        var remark = $('#remark').val();

        // Validate required fields
        if (!request_date) {
            $.notify("Request Date is required", {
                globalPosition: 'top right',
                className: 'error'
            });
            return false;
        }
        if (!user_id) {
            $.notify("Employee is required", {
                globalPosition: 'top right',
                className: 'error'
            });
            return false;
        }
        if (!product_id) {
            $.notify("Product is required", {
                globalPosition: 'top right',
                className: 'error'
            });
            return false;
        }

        // Handle dynamic row creation with Handlebars
        var source = $("#document-template").html();
        var template = Handlebars.compile(source);

        var data = {
            request_date: request_date,
            user_id: user_id,
            user_name: user_name,
            product_id: product_id,
            product_name: product_name,
            quantity: quantity,
            reason: reason,
            remark: remark
        };

        var html = template(data);
        $("#addRow").append(html);

        // Clear input fields
        $('#quantity').val('');
        $('#reason').val('');
        $('#remark').val('');
    });

    // Event listener for form submission
    $(document).on("submit", "#myForm", function (e) {
        e.preventDefault(); // Prevent default form submission

        // Validate dynamic fields (if necessary)

        // If no rows were added, show error
        if ($("#addRow").children().length == 0) {
            $.notify("Please add at least one item to the request", {
                globalPosition: 'top right',
                className: 'error'
            });
            return false;
        }

        // Handle form submission logic
        this.submit(); // If validation is successful, submit the form
    });
});


// $(document).ready(function() {
//     $('#product_id').select2({
//         placeholder: 'Select Product',
//         matcher: function(params, data) {
//             if ($.trim(params.term) === '') return data;

//             const term = params.term.toLowerCase();
//             const text = data.text.toLowerCase();
//             const code = $(data.element).data('code') ? $(data.element).data('code')
//                 .toLowerCase() : '';

//             if (text.includes(term) || code.includes(term)) {
//                 return data;
//             }

//             return null;
//         }
//     });
// });
