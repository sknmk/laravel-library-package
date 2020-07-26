@extends('library::layout.master')
@section('content')
    <form id="assignBookForm" onsubmit="return false">
        <div class="card-header">
            Assign Book
        </div>
        <div class="card-body py-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="reader_id">Reader (User)</label>
                        <select class="form-control" id="reader_id" name="reader_id"></select>
                        <small id="reader_id-error" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="book_id">Book</label>
                        <select class="form-control" id="book_id" name="book_id"></select>
                        <small id="book_id-error" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="expected_return_date">Expected Return Date</label>
                        <input type="date" class="form-control" id="expected_return_date"
                               name="expected_return_date"/>
                        <small id="expected_return_date-error"
                               class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="col-md-6 align-self-center text-right">
                    <button class="btn btn-outline-primary" onclick="assignBook()"
                            id="submitButton">
                        Assign
                    </button>
                </div>
            </div>
        </div>
    </form>
@stop
@section('script')
    <script>
        $(function () {
            getBooks();
            getReaders();
        });

        const assignBook = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formData = $("form#assignBookForm").serialize();
            let submitButton = $("button#submitButton");

            submitButton.html("Please wait").prop("disabled", true).addClass("disabled");
            $(".text-danger").html('');

            $.ajax({
                type: 'POST',
                url: "{{ route('book.assign') }}",
                data: formData,
                success: function (data) {
                    submitButton.html("Successfull.").prop("disabled", false).removeClass("disabled");
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                    $("input, select, textarea").val('');
                },
                error: function (response) {
                    if (response.status === 422) {
                        submitButton.html("Error, try again.").prop("disabled", false).removeClass("disabled");
                        let data = $.parseJSON(response.responseText);
                        $.each(data.errors, function (key, value) {
                            console.log("Error on " + key + ": " + value);
                            $("small[id=" + key + "-error]").html(value);
                        });
                    } else {
                        console.log(response);
                    }
                }
            });
        }

        const getReaders = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('reader.list') }}",
                data: {},
                success: function (data) {
                    $.each(data, function (key, value) {
                        $('select[name=reader_id]')
                            .append('<option value="' + value.id + '">'
                                + value.name + '</option>');
                    });
                },
                error: function (response) {
                    if (response.status === 422) {
                        alert("Error, unable to get data.")
                    } else {
                        console.log(response);
                    }
                }
            });
        }

        const getBooks = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('book.listWithReader') }}",
                data: {},
                success: function (data) {
                    $.each(data, function (key, value) {
                        let status = 0;
                        $.each(value.book_reader, function (subkey, subvalue) {
                            if (subvalue.return_date.length < 1) {
                                status = 1;
                            }
                        });
                        let borrowed = status === 1 ? 'disabled' : '';
                        $('select[name=book_id]')
                            .append('<option value="' + value.id + '" ' + borrowed + '>'
                                + (borrowed.length ? '[Not Available] ' : '') + value.name + '</option>');
                    });
                },
                error: function (response) {
                    if (response.status === 422) {
                        alert("Error, unable to get data.")
                    } else {
                        console.log(response);
                    }
                }
            });
        }
    </script>
@stop
