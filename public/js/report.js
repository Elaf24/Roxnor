document.getElementById('filter-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const params = new URLSearchParams();
    
    if (formData.get('start_date')) params.append('start_date', formData.get('start_date'));
    if (formData.get('end_date')) params.append('end_date', formData.get('end_date'));
    if (formData.get('entry_by')) params.append('entry_by', formData.get('entry_by'));

    try {
        const response = await fetch(`/report.php?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();
        
        if (data.success) {
            updateTable(data.data);
        }
    } catch (error) {
        console.error('Error fetching report:', error);
        location.reload();
    }
});

document.getElementById('reset-btn').addEventListener('click', () => {
    document.getElementById('filter-form').reset();
    window.location.href = '/report.php';
});

function updateTable(submissions) {
    const tbody = document.querySelector('#submissions-table tbody');
    tbody.innerHTML = '';

    if (submissions.length === 0) {
        tbody.innerHTML = '<tr><td colspan="14" class="text-center">No submissions found</td></tr>';
        return;
    }

    submissions.forEach(submission => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${escapeHtml(submission.id)}</td>
            <td>${escapeHtml(submission.amount)}</td>
            <td>${escapeHtml(submission.buyer)}</td>
            <td>${escapeHtml(submission.receipt_id)}</td>
            <td>${escapeHtml(submission.items)}</td>
            <td>${escapeHtml(submission.buyer_email)}</td>
            <td>${escapeHtml(submission.buyer_ip)}</td>
            <td>${escapeHtml(submission.note)}</td>
            <td>${escapeHtml(submission.city)}</td>
            <td>${escapeHtml(submission.phone)}</td>
            <td>${escapeHtml(submission.hash_key ? submission.hash_key.substring(0, 20) + '...' : '')}</td>
            <td>${escapeHtml(submission.entry_at)}</td>
            <td>${escapeHtml(submission.entry_by)}</td>
            <td>${escapeHtml(submission.user_name || 'N/A')}</td>
        `;
        tbody.appendChild(row);
    });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

