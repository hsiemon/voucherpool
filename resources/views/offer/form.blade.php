<div class="modal fade" id="modalOfferForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{URL::to('offers/store')}}" method="POST">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">New Offer</h4>
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
                        <label for="inputDiscount">Discount</label>
                        <input type="number" class="form-control @if($errors->has('discount'))is-invalid @endif" id="inputDiscount" step="0.10" name="discount" max="80" min="1" placeholder="Min: 1, max: 80">
                        @if ($errors->has('discount'))
                            <small class="text-danger">
                              {{ $errors->first('discount') }}
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
    <a href="" class="btn btn-info btn-rounded mb-4" data-toggle="modal" data-target="#modalOfferForm">New Offer</a>
</div>

@if($errors->any())
    @push('scripts')
        <script type="text/javascript">
            $('#modalOfferForm').modal('show')
        </script>
    @endpush
@endif