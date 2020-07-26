@extends('library::layout.master')
@section('content')
    <form id="createBookForm" onsubmit="return false">
        <div class="card-header">
            New Book
        </div>
        <div class="card-body py-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" id="name" name="name"/>
                        <small id="name-error" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="author_id">Author</label>
                        <select class="form-control" id="author_id" name="author_id">
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
                                <option value="{{ $label->bit_value }}">{{ $label->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="label">
                        <small id="label-error" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        <small id="description-error" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="offset-md-6 col-md-6 text-right">
                    <button class="btn btn-outline-primary" onclick="saveBook()" id="submitButton">Create</button>
                </div>
            </div>
        </div>
    </form>
@stop
@section('script')
    <script>
        const saveBook = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formData = $("form#createBookForm").serialize();
            let submitButton = $("button#submitButton");

            submitButton.html("Please wait").prop("disabled", true).addClass("disabled");
            $(".text-danger").html('');

            $.ajax({
                type: 'POST',
                url: "{{ route('book.createBook') }}",
                data: formData,
                success: function (data) {
                    submitButton.html("Successfull, create new.").prop("disabled", false).removeClass("disabled");
                    $("input, select, textarea").val('');
                },
                error: function (response) {
                    if (response.status === 422) {
                        submitButton.html("Error, try again.").prop("disabled", false).removeClass("disabled");
                        let data = $.parseJSON(response.responseText);
                        $.each(data.errors, function( key, value ) {
                            console.log("Error on " + key + ": " + value);
                            $("small[id="+key+"-error]").html(value);
                        });
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
    </script>
@stop
