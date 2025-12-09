@include('partials.header')

<main class="login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="display-4">Login</h1>

                <!-- Display error message -->
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="personalEmail" class="form-label">Personal Email</label>
                        <input type="email" class="form-control" id="personalEmail" name="personalEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</main>

@include('partials.footer')
