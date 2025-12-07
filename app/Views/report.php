<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report - Roxnor</title>
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
        <h1>Submissions Report</h1>
        
        <div class="filters">
            <form id="filter-form">
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date">
                </div>
                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" name="end_date">
                </div>
                <div class="form-group">
                    <label for="entry_by">User ID</label>
                    <input type="number" id="entry_by" name="entry_by" placeholder="User ID">
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <button type="button" class="btn btn-secondary" id="reset-btn">Reset</button>
            </form>
        </div>

        <div class="table-container">
            <table id="submissions-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Buyer</th>
                        <th>Receipt ID</th>
                        <th>Items</th>
                        <th>Buyer Email</th>
                        <th>Buyer IP</th>
                        <th>Note</th>
                        <th>City</th>
                        <th>Phone</th>
                        <th>Hash Key</th>
                        <th>Entry At</th>
                        <th>Entry By</th>
                        <th>User Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($submissions)): ?>
                        <tr>
                            <td colspan="14" class="text-center">No submissions found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($submissions as $submission): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($submission['id']); ?></td>
                                <td><?php echo htmlspecialchars($submission['amount']); ?></td>
                                <td><?php echo htmlspecialchars($submission['buyer']); ?></td>
                                <td><?php echo htmlspecialchars($submission['receipt_id']); ?></td>
                                <td><?php echo htmlspecialchars($submission['items']); ?></td>
                                <td><?php echo htmlspecialchars($submission['buyer_email']); ?></td>
                                <td><?php echo htmlspecialchars($submission['buyer_ip']); ?></td>
                                <td><?php echo htmlspecialchars($submission['note']); ?></td>
                                <td><?php echo htmlspecialchars($submission['city']); ?></td>
                                <td><?php echo htmlspecialchars($submission['phone']); ?></td>
                                <td><?php echo htmlspecialchars(substr($submission['hash_key'], 0, 20)) . '...'; ?></td>
                                <td><?php echo htmlspecialchars($submission['entry_at']); ?></td>
                                <td><?php echo htmlspecialchars($submission['entry_by']); ?></td>
                                <td><?php echo htmlspecialchars($submission['user_name'] ?? 'N/A'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="/js/report.js"></script>
</body>
</html>

