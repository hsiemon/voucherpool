<div class="modal fade" id="modalVoucherRedeemForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{URL::to('vouchers/redeem')}}" method="POST">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Redeem Voucher</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="inputCode">Code</label>
                        <input type="text" class="form-control @if($errors->has('code'))is-invalid @endif" id="inputCode"  name="code" placeholder="Enter code">
                        @if ($errors->has('code'))
                            <small class="text-danger">
                              {{ $errors->first('code') }}
                            </small>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="text" class="form-control @if($errors->has('email'))is-invalid @endif" id="inputEmail" name="email" placeholder="Enter email">
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

<div class="modal fade" id="modalVoucherGenerateForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{URL::to('vouchers/generate')}}" method="POST">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Generate Vouchers</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="selectOfferInput">Offer</label>
                        <select name="offer_id" class="custom-select" id="selectOfferInput">
                            <option value="">Select one offer</option>
                            @foreach($offers as $offer)
                                <option value="{{$offer->id}}">{{$offer->id}} - {{$offer->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('offer_id'))
                            <small class="text-danger">
                              {{ $errors->first('offer_id') }}
                            </small>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="expirationDatePicker">Expiration Date</label>
                        <input type="text" class="form-control @if($errors->has('expiration'))is-invalid @endif" id="expirationDatePicker" name="expiration" placeholder="Enter expiration date">
                        @if ($errors->has('expiration'))
                            <small class="text-danger">
                              {{ $errors->first('expiration') }}
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
    <a href="" class="btn btn-info btn-rounded mb-4" data-toggle="modal" data-target="#modalVoucherGenerateForm">Generate Voucher</a>
    <a href="" class="btn btn-info btn-rounded mb-4" data-toggle="modal" data-target="#modalVoucherRedeemForm">Redeem Voucher</a>
</div>

@if($errors->has('offer_id')) OR if($errors->has('expiration'))
    @push('scripts')
        <script type="text/javascript">
            $('#modalVoucherGenerateForm').modal('show');
        </script>
    @endpush
@endif

@if($errors->has('code')) OR if($errors->has('email'))
    @push('scripts')
        <script type="text/javascript">
            $('#modalVoucherRedeemForm').modal('show');
        </script>
    @endpush
@endif

@push('scripts')
    <script type="text/javascript">    
        let currentDate = new Date().toJSON().slice(0,10).replace(/-/g,'/');
        $('#expirationDatePicker').datetimepicker({
            formatDate:'Y-m-d H:i:s',
            minDate: 0,
            startDate:'+'+currentDate,
            mask: true
        });
    </script>
@endpush