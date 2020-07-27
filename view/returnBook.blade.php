@extends('library::layout.master')
@section('content')
    <form id="returnBookForm" onsubmit="return false">
        <div class="card-header">
            Return Book
        </div>
        <div class="card-body py-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="reader_id">Reader (User)</label>
                        <select class="form-control" id="reader_id" name="reader_id" onchange="setBooks(this)"></select>
                        <small id="reader_id-error" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id">Book</label>
                        <select class="form-control" id="id" name="id"></select>
                        <small id="id-error" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="return_date">Return Date</label>
                        <input type="date" class="form-control" id="return_date"
                               name="return_date" value="{{ date("Y-m-d") }}"/>
                        <small id="return_date-error"
                               class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="col-md-6 align-self-center text-right">
                    <button class="btn btn-outline-primary" onclick="returnBook()"
                            id="submitButton">
                        Return
                    </button>
                </div>
            </div>
        </div>
    </form>
@stop
@section('script')
    <script>
        $(function () {
            getReaders();
        });

        const returnBook = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let submitButton = $("button#submitButton");

            submitButton.html("Please wait").prop("disabled", true).addClass("disabled");
            $(".text-danger").html('');

            let return_date = $('input[name=return_date]').val();
            let id = $('select[name=id]').val();

            $.ajax({
                type: 'POST',
                url: "{{ route('book.return') }}",
                data: {id, return_date},
                success: function (data) {
                    submitButton.html("Successfull.").prop("disabled", false).removeClass("disabled");
                    location.reload();
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

        let books = [];
        const getReaders = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('reader.listWithReader') }}",
                data: {},
                success: function (data) {
                    $.each(data, function (key, value) {
                        if (value.book_reader.length > 0) {
                            books[value.id] = [];
                            $.each(value.book_reader, function (subkey, subvalue) {
                                console.log(subvalue);
                                if (subvalue.return_date === null) {
                                    subvalue.book.book_reader_id = subvalue.id
                                    books[value.id].push(subvalue.book);
                                }
                            });
                            $('select[name=reader_id]')
                                .append('<option value="' + value.id + '">'
                                    + value.name + '</option>').change();

                        }
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

        const setBooks = (el) => {
            let reader = el.value;
            $.each(books[reader], function (key, value) {
                $('select[name=id]')
                    .append('<option value="' + value.book_reader_id + '">'
                        + value.name + '</option>');
            });


        }
    </script>
@stop
