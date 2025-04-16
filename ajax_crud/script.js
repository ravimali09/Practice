
//-----Insert Data---------//
function insertEmployee() {
    var form = $('#form')[0];
    var formData = new FormData(form); // This handles everything, including file

    formData.append('action', 'insert'); // action field bhi manually add karna hoga

    $.ajax({
        url: "action.php",
        type: "POST",
        data: formData,
        contentType: false,    // file ke liye false
        processData: false,    // file ke liye false
        success: function (data) {
            console.log(data);
            searchFilter();
            $('#form')[0].reset();
        }
    });
}

//----------Fetch Data For Edit------//
function editUser(id, page) {
    $.ajax({
        url: "action.php",
        type: "POST",
        data: { "id": id, action: "edit" },
        success: function (data) {
            var allData = JSON.parse(data);
            $("#userid").val(allData.id);
            $("#page").val(page);
            $("#page").val(page);
            $("#edit-name").val(allData.name);
            $("#edit-email").val(allData.email);
            $('input[name="gender"][value=' + allData.gender + '].gender').prop('checked', true);
            var language = allData.language.toString();
            if (language.includes("Hindi")) {
                $('input[name="language[]"][value=' + 'Hindi' + '].language').prop('checked', true);
            } else {
                $('input[name="language[]"][value=' + 'Hindi' + '].language').prop('checked', false);
            }
            if (language.includes("English")) {
                $('input[name="language[]"][value=' + 'English' + '].language').prop('checked', true);
            } else {
                $('input[name="language[]"][value=' + 'English' + '].language').prop('checked', false);
            }
            if (language.includes("Gujrati")) {
                $('input[name="language[]"][value=' + 'Gujrati' + '].language').prop('checked', true);
            } else {
                $('input[name="language[]"][value=' + 'Gujrati' + '].language').prop('checked', false);
            }
            $("#edit-city").val(allData.city);
        }
    });
    $("#editEmployee").modal("show");
}

//---------------Delete Data---------------//
function deleteUser(id, page, limit) {

    var conf = confirm("Are You Sure..?");
    if (conf == true) {
        $.ajax({
            url: "action.php",
            type: "POST",
            data: { "id": id, "action": "delete" },
            success: function () {
                searchFilter(page, limit);
            }
        });
    }
}
//-------------------Update Data--------------------//
function editEmployee() {
    var id = $("#userid").val();
    var page = $("#page").val();
    var name = $("#edit-name").val();
    var email = $("#edit-email").val();
    var gender = $("input[name='gender']:checked").val();
    var language = [];
    $(':checkbox:checked').each(function (i) {
        language[i] = $(this).val();
    });
    var city = $("#edit-city").val();
    $.ajax({
        url: "action.php",
        type: "POST",
        data: {
            "id": id, "name": name, "email": email, "gender": gender, "language": language, "city": city, "action": "update"
        },
        success: function (data) {
            searchFilter(page);
            $('#edit-form')[0].reset();
        }
    });
}

setTimeout(function () {
    $('.msg').fadeOut('slow');
}, 5000);


//-------------Show Data with Filter And without filter------------//
function searchFilter(page = 1, limit, column = 'id', order = 'asc') {
    var keywords = $('#keywords').val();
    var gender = $('#genderfilter').val();
    var language = $('#languagefilter').val();
    var city = $('#cityfilter').val();
    var limit = $('#limit').val();
    if (order == 'desc') {
        arrow = '&nbsp;<i class="fa-solid fa-arrow-down"></i>';
    }
    else {
        arrow = '&nbsp;<i class="fa-solid fa-arrow-up"></i>';
    }
    $.ajax({
        type: 'POST',
        url: 'action.php',
        data: {
            "keywords": keywords, "gender": gender, "language": language, "city": city, "filter": "filter",
            "limit": limit, "page": page, "column": column, "order": order
        },
        success: function (data) {
            $("#show_records").html(data);
            $('.column').append(arrow);
        }
    });
}

$(document).ready(function () {
    searchFilter();
    $("#cancel").click(function () {
        $('#edit-form')[0].reset();
    });
    $(".remove-btn").click(function () {
        $('.remove').text("");
        $('#form')[0].reset();
    });


    $(document).on("click", ".column", function () {
        var column = $(this).attr("id");
        var order = $(this).data("order");
        var limit = $("#limit").val();
        if (order == 'desc') {
            arrow = '&nbsp;<i class="fa-solid fa-arrow-down"></i>';
        }
        else {
            arrow = '&nbsp;<i class="fa-solid fa-arrow-up"></i>';
        }
        $.ajax({
            url: "action.php",
            type: "post",
            data: { "column": column, "order": order, "limit": limit, "filter": "filter" },
            success: function (data) {
                $("#show_records").html(data);
                $('.column').append(arrow);
            }
        });
    })


    //------------------->> Validation <<----------------------//


    $("input").blur(function (e) {
        var isValid = true;
        var inp_id = $(this).attr('id');
        if ($(this).val() == "") {
            $("#err" + inp_id).text(inp_id + " field is required...!");
        }
        if (!isValid) {
            e.preventDefault();
        }
    });
    $("input").focus(function () {
        var inp_id = $(this).attr('id');
        if ($(this).val() == "") {
            $("#err" + inp_id).text("");
        }
    });


    $("input[name='gender']").blur(function (e) {
        var valid = true;
        if (!$("input[name='gender']:checked").val()) {
            $("#errgender").text("Gender field is required...!");
            valid = false;
        }
        if (!valid) {
            e.preventDefault();
        }
    });
    $("input[name='gender']").change(function (e) {
        $("#errgender").text("");
    });

    $("input[name='language[]']").blur(function () {
        if (!$("input[name='language[]']:checked").val()) {
            $("#errlanguage").text("Language field is required...!");
            valid = false;
        }
    });
    $("input[name='language[]']").change(function () {
        if ($(this).val() == "") {
            $("#errlanguage").text("Language field is required...!");
        } else {
            $("#errlanguage").text("");
        }
        if (!$("input[name='language[]']:checked").val()) {
            $("#errlanguage").text("Language field is required...!");
            valid = false;
        }
    });

    $("#city").blur(function () {
        if ($(this).val() == "") {
            $("#errcity").text("City field is required...!");
        }
    });

    $("#city").change(function () {
        if ($(this).val() == "") {
            $("#errcity").text("City field is required...!");
        } else {
            $("#errcity").text("");
        }
        if (!$("#city").val()) {
            $("#errcity").text("City field is required...!");
            valid = false;
        }
    });

});

