@extends('auth')

@section('content_login')
    <div class="container-xxl ">
        <div class="authentication-wrapper authentication-basic  ">
            <div class="authentication-inner py-4">
                <!-- Login -->
                <div class="card pt-10">
                    <br>
                   
                    <div class="card-body">
                        <!-- /Logo -->
                        <h4 class="mb-1 text-center">Login</h4>

                        <form action="{{ route('auth') }}" id="formAuthentications" class="mb-2" action="" method="POST">
                            @csrf
                            <div class="fv-row">
                                <div class="mb-2">
                                    <label for="email" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="email" name="username"
                                        placeholder="Enter your username" />
                                </div>
                                <div class="mb-2 form-password-toggle">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password">Password</label>

                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" />
                                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                    </div>
                                </div>
                               
                            </div>



                        </form>
                        <div class="mb-3">
                            <button type='button' id='btnlogin' class="btn btn-success d-grid w-100">Login</button>
                        </div>

                        <p class="text-center">
                            <span class='text-muted'>Belum punya akun ?</span>
                            <a href="">
                                <span class='text-success'>Daftar disini</span>
                            </a>
                        </p>

                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Your account has been registered</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-warning" role="alert">
                            Your account has not been verified yet. Please check your e-mail's inbox or spam folder to
                            verify your account. Or please enter your email address to re-send the verification e-mail
                        </div>
                        <input type="email" placeholder="Enter Your Email" class='form-control' name='email'
                            id='email' required>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Resend Token</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(".refresh-cpatcha").click(function() {
            $.ajax({
                type: 'GET',
                url: "{{ url('refresh-captcha') }}",
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
    <script>
        const form = document.querySelector('#formAuthentications');
        var validatorPersonalData = FormValidation.formValidation(
            form, {
                fields: {
                    username: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter username / Masukan username anda'
                            },
                            stringLength: {
                                min: 6,
                                message: 'Username must be more than 6 characters'
                            }
                        }
                    },
                    'password': {
                        'validators': {
                            'notEmpty': {
                                'message': 'Password not empty / Password tidak boleh kosong'
                            }
                        }
                    },

                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: '',
                        rowSelector: '.mb-2'
                    }),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                },


            });

        const buttonSubmit = document.getElementById('btnlogin');
        buttonSubmit.addEventListener('click', function(e) {
            e.preventDefault();
            if (validatorPersonalData) {
                validatorPersonalData.validate().then(function(status) {
                    if (status == 'Valid') {
                        buttonSubmit.disabled = true;

                        // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        setTimeout(function() {
                            form.submit(); // Submit form
                        }, 1000);
                    }
                });
            }
        });
    </script>
@endpush
