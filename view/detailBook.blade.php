@extends('library::layout.master')
@section('content')
    <form id="createUserForm" onsubmit="return false">
        <div class="card-header">
            Book Details
        </div>
        <div class="card-body py-5">
            <div class="row">
                <div class="col-12">
                    <h6 id="author_name"></h6>
                    <h4 id="name"></h4>
                    <p id="labels"></p>
                    <p id="description"></p>
                </div>
                <div class="col-12 mt-5" id="last-borrows-container">
                    <h5>Last Borrows</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Borrow Date</th>
                                <th>Expected Return Date</th>
                                <th>Return Date</th>
                            </tr>
                            </thead>
                            <tbody id="book-reader-container"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
@section('script')
    <script>
        $(function() {
            getBook();
        });

        let labels = JSON.parse('{!! $labels !!}');
        const getBook = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{  url()->current() }}",
                data: {},
                success: function (data) {
                    $('#author_name').html(data.author.name);
                    let bookLabel = '';
                    $.each(labels, function (i, label) {
                        if (label.bit_value & data.label) {
                            bookLabel += label.name + ', ';
                        }
                    });
                    $('#labels').html(bookLabel);

                    $.each(data, function( key, value ) {
                        $('#'+key).html(value);
                    });

                    if (data.book_reader.length < 1) {
                        $('#last-borrows-container').remove();
                    }

                    $.each(data.book_reader, function( key, value ) {
                        $('#book-reader-container').append('<tr>' +
                            '<td>' + value.reader.name + '</td>' +
                            '<td>' + value.borrow_date + '</td>' +
                            '<td>' + value.expected_return_date + '</td>' +
                            '<td>' + (value.return_date !== null ? value.return_date : 'Not returned.') + '</td>' +
                            '</tr>');
                    });
                },
                error: function (response) {
                    if (response.status === 422) {
                        let data = $.parseJSON(response.responseText);
                    }
                }
            });
        }
    </script>
@stop
