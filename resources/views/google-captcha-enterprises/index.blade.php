<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form with Google reCAPTCHA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://www.google.com/recaptcha/api.js?render={{config('services.recaptcha.site_key')}}"></script>

</head>
<body>

<form method="POST" id="contact-us-form" action="{{ route('google-captcha.store') }}">
    @csrf
    <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" required>
    </div>

    <div>
        <label for="message">Message</label>
        <textarea name="message" id="message" required></textarea>
    </div>

    <div class="col-12 form-floating mb-3">
        <input type="hidden" name="g-recaptcha-token" id="g-recaptcha-token">
        @error('g-recaptcha-token')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <button type="submit">Submit</button>
    </div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://www.google.com/recaptcha/api.js?render={{config('services.recaptcha.site_key')}}"></script>
<script>
    $(document).ready(function () {
        $('#contact-us-form').on('submit', function (event) {
            event.preventDefault();
            grecaptcha.ready(function () {
                grecaptcha.execute('{{config('services.recaptcha.site_key')}}', { action: 'submit' })
                    .then(function (token) {
                        $("#g-recaptcha-token").val(token);
                        $('#contact-us-form')[0].submit();
                    });
            });
        });
    });
</script>
</body>
</html>
