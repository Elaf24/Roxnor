<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Roxnor</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <div class="auth-box">
            <h1>Roxnor</h1>
            <div class="tabs">
                <button class="tab-btn active" data-tab="login">Login</button>
                <button class="tab-btn" data-tab="signup">Sign Up</button>
            </div>

            <!-- Login Form -->
            <div id="login-tab" class="tab-content active">
                <form id="login-form">
                    <div class="form-group">
                        <label for="login-email">Email</label>
                        <input type="email" id="login-email" name="email" required>
                        <span class="error" id="login-email-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" id="login-password" name="password" required>
                        <span class="error" id="login-password-error"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <span class="error" id="login-general-error"></span>
                </form>
            </div>

            <!-- Signup Form -->
            <div id="signup-tab" class="tab-content">
                <form id="signup-form">
                    <div class="form-group">
                        <label for="signup-name">Name</label>
                        <input type="text" id="signup-name" name="name" required>
                        <span class="error" id="signup-name-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="signup-email">Email</label>
                        <input type="email" id="signup-email" name="email" required>
                        <span class="error" id="signup-email-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="signup-password">Password</label>
                        <input type="password" id="signup-password" name="password" required>
                        <span class="error" id="signup-password-error"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                    <span class="error" id="signup-general-error"></span>
                </form>
            </div>
        </div>
    </div>
    <script src="/js/auth.js"></script>
</body>
</html>

