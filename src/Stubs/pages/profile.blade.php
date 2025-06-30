<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile Information') }}</div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                        </div>

                        <div class="alert alert-info">
                            <strong>Note:</strong> This is a basic profile view. You can extend it with profile editing functionality as needed.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
