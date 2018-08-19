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
          
          <h2>{{$recipient->name}} - Vouchers</h2>

          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Offer</th>
                  <th>Expire On</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($vouchers as $voucher)
                <tr>
                  <td>{{ $voucher->code }}</td>
                  <td>{{ $voucher->offer->name }}</td>
                  <td>{{ $voucher->expiration }}</td>
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
