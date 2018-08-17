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
          
          <h2>Recipient</h2>

          @include('recipient.form')

          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>E-mail</th>
                  <th>Name</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($recipients as $recipient)
                    <tr>
                      <td>{{ $recipient->id }}</td>
                      <td>{{ $recipient->email }}</td>
                      <td>{{ $recipient->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            Recipient not found
                        </td>
                    </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>

    @include('layout.scripts')

  </body>
</html>
