document.addEventListener('DOMContentLoaded', function () {
    // Retrieve success and error messages from Blade
    var successMessage = json(session('success'));
    var errorMessage = json(session('error'));

    // Display success message if it exists
    if (successMessage) {
        toastr.success(successMessage);
    }

    // Display error message if it exists
    if (errorMessage) {
        toastr.error(errorMessage);
    }
    document.getElementById('registrationForm').addEventListener('submit', function (e) {
        e.preventDefault();

        let hasError = false;

        // Clear previous errors
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

        // Get form values
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const passwordConfirmation = document.getElementById('password_confirmation').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const address = document.getElementById('address').value.trim();
        const image = document.getElementById('image').files[0];

        // Validate fields
        if (name === '') {
            document.getElementById('nameError').textContent = 'Name is required';
            hasError = true;
        }
        if (email === '') {
            document.getElementById('emailError').textContent = 'Email is required';
            hasError = true;
        } else if (!validateEmail(email)) {
            document.getElementById('emailError').textContent = 'Invalid email format';
            hasError = true;
        }
        if (password === '') {
            document.getElementById('passwordError').textContent = 'Password is required';
            hasError = true;
        }
        if (password !== passwordConfirmation) {
            document.getElementById('passwordConfirmationError').textContent = 'Passwords do not match';
            hasError = true;
        }
        if (phone === '') {
            document.getElementById('phoneError').textContent = 'Phone is required';
        }
        if (address === '') {
            document.getElementById('addressError').textContent = 'Address is required';
        }
        if (image && !image.type.startsWith('image/')) {
            document.getElementById('imageError').textContent = 'Invalid image file';
            hasError = true;
        }

        if (!hasError) {
            // If no errors, submit the form
            this.submit();
        } else {
            toastr.error('Please fix the errors and try again.');
        }
    });

    function validateEmail(email) {
        // Basic email format validation
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
});
