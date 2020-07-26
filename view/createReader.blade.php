@extends('library::layout.master')
@section('content')
    <form id="createUserForm" onsubmit="return false">
        <div class="card-header">
            New Reader
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
                        <label for="email">Email</label>
                        <input class="form-control" type="email" id="email" name="email"/>
                        <small id="email-error" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="offset-md-6 col-md-6 text-right">
                    <button class="btn btn-outline-primary" onclick="saveReader()" id="submitButton">Create</button>
                </div>
            </div>
        </div>
    </form>
@stop
@section('script')
    <script>
        const saveReader = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formData = $("form#createUserForm").serialize();
            let submitButton = $("button#submitButton");

            submitButton.html("Please wait").prop("disabled", true).addClass("disabled");
            $(".text-danger").html('');

            $.ajax({
                type: 'POST',
                url: "{{ route('reader.createReader') }}",
                data: formData,
                success: function (data) {
                    submitButton.html("Successfull, create new.").prop("disabled", false).removeClass("disabled");
                },
                error: function (response) {
                    if (response.status === 422) {
                        submitButton.html("Error, try again.").prop("disabled", false).removeClass("disabled");
                        let data = $.parseJSON(response.responseText);
                        $.each(data.errors, function( key, value ) {
                            console.log("Error on " + key + ": " + value);
                            $("small[id="+key+"-error]").html(value);
                        });
                    }
                }
            });
        }
    </script>
@stop
