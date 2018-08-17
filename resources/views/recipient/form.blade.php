<div class="modal fade" id="modalRecipientForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{URL::to('recipients/store')}}" method="POST">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">New Recipient</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="inputName">Name</label>
                        <input type="text" class="form-control @if($errors->has('name'))is-invalid @endif" id="inputName" aria-describedby="emailHelp" name="name" placeholder="Enter name">
                        @if ($errors->has('name'))
                            <small class="text-danger">
                              {{ $errors->first('name') }}
                            </small>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">E-mail</label>
                        <input type="email" class="form-control @if($errors->has('email'))is-invalid @endif" id="inputEmail" step="0.10" name="email" placeholder="Enter e-mail">
                        @if ($errors->has('email'))
                            <small class="text-danger">
                              {{ $errors->first('email') }}
                            </small>
                        @endif
                    </div>
                </div>
                <div class="modal-footer d-flex ">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="text-right">
    <a href="" class="btn btn-info btn-rounded mb-4" data-toggle="modal" data-target="#modalRecipientForm">New Recipient</a>
</div>

@if($errors->any())
    @push('scripts')
        <script type="text/javascript">
            $('#modalRecipientForm').modal('show')
        </script>
    @endpush
@endif