@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 card_laravel">
            <div class="card">
                <div class="card-header">{{ __('messages.Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('messages.mail_enviado') }}
                        </div>
                    @endif

                    {{ __('messages.antes_de_proceder') }}
                    {{ __('messages.sino') }}, <a href="{{ route('verification.resend') }}">{{ __('messages.click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
