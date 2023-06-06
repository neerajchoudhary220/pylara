<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<link rel="stylesheet" href="{{ asset('assests/fontawesome-free/css/all.min.css') }}">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{ asset('assests/dist/css/all.min.css') }}">
<!-- IonIcons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

<link rel="stylesheet" href="{{ asset('assests/dist/css/adminlte.min.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <title>Secret Note</title>
</head>
<body>
    <div class="container">

        <div class="card m-3">
            <div class="card-header bg-secondary">
                Write Your Note
            </div>
            <div class="card-body">
                <form action="{{ route('secret.notepad.create') }}" method="post" id="notes">
                    @csrf
                    <div class="form">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea name="notes" class="form-control" placeholder="Write here..." style="height:350px; resize:none;"></textarea>

                                    <span class="mt-2 text-danger" id="notes-error"></span>

                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-row d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </div>



                        </div>

                    </div>
                </form>
                <div class="row d-none" id="link-group">
                    <div class="col-12">
                        <div class="d-row d-flex justify-content-center">
                            <div class="border border-primary rounded p-2 dashed d-flex justify-content-start">
                                <button class="btn btn-secondary mr-3" rel="tooltip" title="Copy link"
                                    onclick="copyLink(this)"> <i class="fa fa-copy"></i></button>

                                <button class="btn btn-primary mr-3 d-none" id="check-mark"> <i class="fa fa-check"></i></button>

                                <a href="#" id="link">link</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('assests/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    function copyLink(e) {
        var link = $("#link").text();
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(link).select();
        document.execCommand("copy");
        $temp.remove();
        $("#check-mark").removeClass('d-none');
        $(e).addClass('d-none');
        // $("[rel=tooltip]").tooltip({
        //     title:'Copied Text'
        // });
        // $('[res=tooltip]').tooltip({
        //     title: 'Copied Text'
        // });

    }
    $(document).ready(function() {


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            }
        });
        $("#notes").submit(function(e) {
            e.preventDefault();
            var dta = $('#notes').serialize();
            $.ajax({
                url: "{{ route('secret.notepad.create') }}",
                type: 'POST',
                data: dta,
                success: function(res) {
                    console.log(res.errors.notes);

                    if (res.errors.notes == undefined) {
                        $("textarea").prop('disabled', true);
                        $("button[type=submit]").prop('disabled', true);
                        $("#link-group").removeClass('d-none');
                        $("#link").text(res.link);
                        $("#link").attr('href', res.link);
                    } else {
                        $("#notes-error").text(res.errors.notes[0]);
                        document.getElementById('notes-error').scrollTo();

                    }

                }
            })

        });
        $("[rel=tooltip]").tooltip();
    });
</script>
</html>
