// Tab switching
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const tab = btn.dataset.tab;
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById(`${tab}-tab`).classList.add('active');
    });
});

// Login form
document.getElementById('login-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    clearErrors('login');

    const formData = new FormData();
    formData.append('action', 'login');
    formData.append('email', document.getElementById('login-email').value);
    formData.append('password', document.getElementById('login-password').value);

    try {
        const response = await fetch('/login.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            window.location.href = '/index.php';
        } else {
            displayErrors(data.errors, 'login');
        }
    } catch (error) {
        showError('login-general-error', 'An error occurred. Please try again.');
    }
});

// Signup form
document.getElementById('signup-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    clearErrors('signup');

    const errors = validateSignup();
    if (Object.keys(errors).length > 0) {
        displayErrors(errors, 'signup');
        return;
    }

    const formData = new FormData();
    formData.append('action', 'signup');
    formData.append('name', document.getElementById('signup-name').value.trim());
    formData.append('email', document.getElementById('signup-email').value.trim());
    formData.append('password', document.getElementById('signup-password').value);

    try {
        const response = await fetch('/login.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            alert('Registration successful! Please login.');
            document.querySelector('[data-tab="login"]').click();
            document.getElementById('signup-form').reset();
        } else {
            displayErrors(data.errors, 'signup');
        }
    } catch (error) {
        showError('signup-general-error', 'An error occurred. Please try again.');
    }
});

function validateSignup() {
    const errors = {};
    const name = document.getElementById('signup-name').value.trim();
    const email = document.getElementById('signup-email').value.trim();
    const password = document.getElementById('signup-password').value;

    if (!name) {
        errors.name = 'Name is required';
    }

    if (!email) {
        errors.email = 'Email is required';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        errors.email = 'Invalid email format';
    }

    if (!password) {
        errors.password = 'Password is required';
    } else if (password.length < 6) {
        errors.password = 'Password must be at least 6 characters';
    }

    return errors;
}

function displayErrors(errors, prefix) {
    for (const [key, value] of Object.entries(errors)) {
        if (key === 'general') {
            showError(`${prefix}-general-error`, value);
        } else {
            showError(`${prefix}-${key}-error`, value);
        }
    }
}

function clearErrors(prefix) {
    document.querySelectorAll(`#${prefix}-tab .error`).forEach(el => {
        el.textContent = '';
    });
}

function showError(id, message) {
    const errorEl = document.getElementById(id);
    if (errorEl) {
        errorEl.textContent = message;
    }
}

