@extends('layout.master')
@section('main-content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <h4>Welcome Secret Notepad</h4>
        </div>

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
    @push('custom-scripts')
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
    @endpush
@endsection
