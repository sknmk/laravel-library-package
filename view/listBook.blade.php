@extends('library::layout.master')
@section('content')
    <form id="createBookForm" onsubmit="return false">
        <div class="card-header">
            Book List
        </div>
        <div class="card-body py-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="author_id">Author</label>
                        <select class="form-control" id="author_id" name="author_id">
                            <option value="" disabled selected>All</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                        <small id="author-error" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="label">Labels</label>
                        <select class="form-control" id="label" multiple onchange="setLabel()">
                            @foreach ($labels as $label)
                                <option value="{{ $label->bit_value }}" selected>{{ $label->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="label">
                        <small id="label-error" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="offset-md-6 col-md-6 text-right">
                    <button class="btn btn-outline-primary" onclick="find()">Find</button>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Author</th>
                            <th>Label</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="book-list-container">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
@stop
@section('script')
    <script>
        $(function () {
            getList();
        });
        let labels = JSON.parse('{!! $labels !!}');

        const getList = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('book.list') }}",
                data: {},
                success: function (data) {
                    $.each(data, function (key, value) {
                        let bookLabel = '';
                        $.each(labels, function (i, label) {
                            if (label.bit_value & value.label) {
                                bookLabel += label.name + ', ';
                            }
                        });
                        $('#book-list-container').append('<tr>' +
                            '<td>' + value.name + '</td>' +
                            '<td>' + value.author.name + '</td>' +
                            '<td>' + bookLabel + '</td>' +
                            '<td class="text-right"><a href="/book/detail/' + value.id + '">Details</a></td>' +
                            '</tr>');
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

        const setLabel = () => {
            let sum = 0;
            $("select[id='label'] option:checked").each(function(){
                sum += +this.value;
            });
            $('input[name=label]').val(sum);
        }

        const find = () => {
            let author_id = $("select[name=author_id]").val();
            let label = $("input[name=label]").val();

            $('#book-list-container').html('');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{ route('book.list') }}",
                data: {author_id, label},
                success: function (data) {
                    $.each(data, function (key, value) {
                        let bookLabel = '';
                        $.each(labels, function (i, label) {
                            if (label.bit_value & value.label) {
                                bookLabel += label.name + ', ';
                            }
                        });
                        $('#book-list-container').append('<tr>' +
                            '<td>' + value.name + '</td>' +
                            '<td>' + value.author.name + '</td>' +
                            '<td>' + bookLabel + '</td>' +
                            '<td class="text-right"><a href="/book/detail/' + value.id + '">Details</a></td>' +
                            '</tr>');
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
