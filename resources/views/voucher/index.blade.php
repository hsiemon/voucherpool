<!doctype html>
<html lang="en">

    @include('layout.head')

  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">HSiemon - Voucher Pool</a>
    </nav>

    <div class="container-fluid">
      <div class="row">
        @include('layout.navigation')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          @include('layout.messages')
          
          <h2>Vouchers</h2>

          @include('voucher.form')

          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Available</th>
                  <th>E-mail</th>
                  <th>Expire On</th>
                  <th>Used At</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($vouchers as $voucher)
                <tr>
                  <td>{{ $voucher->code }}</td>
                  <td>
                    @if($voucher->alreadyUsed==1)
                    <span class="badge badge-danger">
                      <i class="fas fa-times"></i>
                    </span>
                    @else
                    <span class="badge badge-info">
                      <i class="fas fa-check"></i>                        
                    </span>
                    @endif
                  </td>
                  <td>{{ $voucher->recipient->email }}</td>
                  <td>{{ $voucher->expiration }}</td>
                  <td>{{ $voucher->usedAt }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="5">
                    Voucher not found
                  </td>
                </tr>
                @endforelse
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="5">
                    {{ $vouchers->links() }}
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </main>
      </div>
    </div>

    @include('layout.scripts')

  </body>
</html>
