<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Form - Roxnor</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <h2>Roxnor</h2>
            <div class="nav-links">
                <a href="/index.php">Submit</a>
                <a href="/report.php">Report</a>
                <a href="/logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Data Submission Form</h1>
        <form id="submission-form">
            <div class="form-group">
                <label for="amount">Amount *</label>
                <input type="number" id="amount" name="amount" required>
                <span class="error" id="amount-error"></span>
            </div>

            <div class="form-group">
                <label for="buyer">Buyer *</label>
                <input type="text" id="buyer" name="buyer" maxlength="20" required>
                <span class="error" id="buyer-error"></span>
            </div>

            <div class="form-group">
                <label for="receipt_id">Receipt ID *</label>
                <input type="text" id="receipt_id" name="receipt_id" maxlength="20" required>
                <span class="error" id="receipt_id-error"></span>
            </div>

            <div class="form-group">
                <label for="items">Items *</label>
                <div id="items-container">
                    <input type="text" class="item-input" placeholder="Enter item">
                    <button type="button" class="btn btn-secondary" id="add-item-btn">Add Item</button>
                </div>
                <input type="hidden" id="items" name="items" required>
                <span class="error" id="items-error"></span>
            </div>

            <div class="form-group">
                <label for="buyer_email">Buyer Email *</label>
                <input type="email" id="buyer_email" name="buyer_email" maxlength="50" required>
                <span class="error" id="buyer_email-error"></span>
            </div>

            <div class="form-group">
                <label for="note">Note * (max 30 words)</label>
                <textarea id="note" name="note" rows="4" required></textarea>
                <span class="word-count">Words: <span id="word-count">0</span>/30</span>
                <span class="error" id="note-error"></span>
            </div>

            <div class="form-group">
                <label for="city">City *</label>
                <input type="text" id="city" name="city" maxlength="20" required>
                <span class="error" id="city-error"></span>
            </div>

            <div class="form-group">
                <label for="phone">Phone *</label>
                <input type="text" id="phone" name="phone" required>
                <span class="error" id="phone-error"></span>
            </div>

            <div class="form-group">
                <label for="entry_by">Entry By *</label>
                <input type="number" id="entry_by" name="entry_by" required>
                <span class="error" id="entry_by-error"></span>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <span class="error" id="general-error"></span>
            <span class="success" id="success-message"></span>
        </form>
    </div>
    <script src="/js/submission.js"></script>
</body>
</html>

