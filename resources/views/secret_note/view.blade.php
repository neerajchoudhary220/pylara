<div class="container">
    <div class="card">
        <div class="card-header">
            Generated Link
        </div>
        <div class="card-body">
            <div class="row">
                @if(!empty($notes))
                <div class="col-12">
                    <div class="d-row d-flex justify-contnet-center">
                        {{$notes->first()->link}}
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
