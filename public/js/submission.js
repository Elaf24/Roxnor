let items = [];

// Add item functionality
document.getElementById('add-item-btn').addEventListener('click', () => {
    const input = document.querySelector('.item-input');
    const value = input.value.trim();
    
    if (value && /^[a-zA-Z\s]+$/.test(value)) {
        items.push(value);
        input.value = '';
        updateItemsDisplay();
        updateItemsInput();
    } else {
        alert('Item can only contain letters and spaces');
    }
});

// Remove item
function removeItem(index) {
    items.splice(index, 1);
    updateItemsDisplay();
    updateItemsInput();
}

function updateItemsDisplay() {
    const container = document.getElementById('items-container');
    const existingItems = container.querySelectorAll('.item-tag');
    existingItems.forEach(el => el.remove());

    items.forEach((item, index) => {
        const tag = document.createElement('span');
        tag.className = 'item-tag';
        tag.innerHTML = `${item} <button type="button" onclick="removeItem(${index})">×</button>`;
        container.insertBefore(tag, container.firstChild);
    });
}

function updateItemsInput() {
    document.getElementById('items').value = items.join(', ');
}

// Phone number formatting (prepend 880)
document.getElementById('phone').addEventListener('blur', function() {
    let phone = this.value.replace(/\D/g, '');
    if (phone && !phone.startsWith('880')) {
        if (phone.startsWith('0')) {
            phone = '880' + phone.substring(1);
        } else {
            phone = '880' + phone;
        }
        this.value = phone;
    }
});

// Word count for note
document.getElementById('note').addEventListener('input', function() {
    const text = this.value;
    const wordCount = text.trim() ? text.trim().split(/\s+/).length : 0;
    document.getElementById('word-count').textContent = wordCount;
    
    if (wordCount > 30) {
        document.getElementById('word-count').style.color = 'red';
    } else {
        document.getElementById('word-count').style.color = 'inherit';
    }
});

// Form submission
document.getElementById('submission-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    clearErrors();

    const errors = validateForm();
    if (Object.keys(errors).length > 0) {
        displayErrors(errors);
        return;
    }

    const formData = new FormData(document.getElementById('submission-form'));

    try {
        const response = await fetch('/submit.php', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            document.getElementById('success-message').textContent = data.message;
            document.getElementById('submission-form').reset();
            items = [];
            updateItemsDisplay();
            updateItemsInput();
            document.getElementById('word-count').textContent = '0';
            setTimeout(() => {
                document.getElementById('success-message').textContent = '';
            }, 3000);
        } else {
            if (data.error) {
                showError('general-error', data.error);
            } else if (data.errors) {
                displayErrors(data.errors);
            }
        }
    } catch (error) {
        showError('general-error', 'An error occurred. Please try again.');
    }
});

function validateForm() {
    const errors = {};
    
    // Amount: only numbers
    const amount = document.getElementById('amount').value;
    if (!amount) {
        errors.amount = 'Amount is required';
    } else if (!/^\d+$/.test(amount) || parseInt(amount) <= 0) {
        errors.amount = 'Amount must be a positive number';
    }

    // Buyer: only text, spaces and numbers, not more than 20 characters
    const buyer = document.getElementById('buyer').value.trim();
    if (!buyer) {
        errors.buyer = 'Buyer is required';
    } else if (buyer.length > 20) {
        errors.buyer = 'Buyer name must not exceed 20 characters';
    } else if (!/^[a-zA-Z0-9\s]+$/.test(buyer)) {
        errors.buyer = 'Buyer name can only contain letters, numbers, and spaces';
    }

    // Receipt_id: only text
    const receiptId = document.getElementById('receipt_id').value.trim();
    if (!receiptId) {
        errors.receipt_id = 'Receipt ID is required';
    } else if (receiptId.length > 20) {
        errors.receipt_id = 'Receipt ID must not exceed 20 characters';
    } else if (!/^[a-zA-Z]+$/.test(receiptId)) {
        errors.receipt_id = 'Receipt ID can only contain letters';
    }

    // Items: only text
    if (items.length === 0) {
        errors.items = 'At least one item is required';
    }

    // Buyer_email: only emails
    const buyerEmail = document.getElementById('buyer_email').value.trim();
    if (!buyerEmail) {
        errors.buyer_email = 'Buyer email is required';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(buyerEmail)) {
        errors.buyer_email = 'Invalid email format';
    } else if (buyerEmail.length > 50) {
        errors.buyer_email = 'Email must not exceed 50 characters';
    }

    // Note: not more than 30 words
    const note = document.getElementById('note').value.trim();
    if (!note) {
        errors.note = 'Note is required';
    } else {
        const wordCount = note.split(/\s+/).filter(w => w.length > 0).length;
        if (wordCount > 30) {
            errors.note = 'Note must not exceed 30 words';
        }
    }

    // City: only text and spaces
    const city = document.getElementById('city').value.trim();
    if (!city) {
        errors.city = 'City is required';
    } else if (city.length > 20) {
        errors.city = 'City must not exceed 20 characters';
    } else if (!/^[a-zA-Z\s]+$/.test(city)) {
        errors.city = 'City can only contain letters and spaces';
    }

    // Phone: only numbers
    const phone = document.getElementById('phone').value.replace(/\D/g, '');
    if (!phone) {
        errors.phone = 'Phone is required';
    } else if (!/^\d+$/.test(phone)) {
        errors.phone = 'Phone can only contain numbers';
    } else if (phone.length > 20) {
        errors.phone = 'Phone number is too long';
    }

    // Entry_by: only numbers
    const entryBy = document.getElementById('entry_by').value;
    if (!entryBy) {
        errors.entry_by = 'Entry by is required';
    } else if (!/^\d+$/.test(entryBy) || parseInt(entryBy) <= 0) {
        errors.entry_by = 'Entry by must be a positive number';
    }

    return errors;
}

function displayErrors(errors) {
    for (const [key, value] of Object.entries(errors)) {
        if (key === 'general') {
            showError('general-error', value);
        } else {
            showError(`${key}-error`, value);
        }
    }
}

function clearErrors() {
    document.querySelectorAll('.error').forEach(el => {
        el.textContent = '';
    });
    document.getElementById('success-message').textContent = '';
}

function showError(id, message) {
    const errorEl = document.getElementById(id);
    if (errorEl) {
        errorEl.textContent = message;
    }
}

