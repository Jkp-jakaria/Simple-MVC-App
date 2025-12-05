document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('submission-form');
    const itemsWrapper = document.getElementById('items-wrapper');
    const addItemBtn = document.getElementById('add-item-btn');
    const phoneInput = document.getElementById('phone-input');
    const messagesDiv = document.getElementById('submission-messages');

    function showMessages(msgs, isError) {
        messagesDiv.innerHTML = '';
        const ul = document.createElement('ul');
        msgs.forEach(m => {
            const li = document.createElement('li');
            li.textContent = m;
            ul.appendChild(li);
        });
        messagesDiv.appendChild(ul);
        messagesDiv.style.color = isError ? 'red' : 'green';
    }

    function validateForm() {
        const amount = form.amount.value.trim();
        const buyer = form.buyer.value.trim();
        const receiptId = form.receipt_id.value.trim();
        const buyerEmail = form.buyer_email.value.trim();
        const note = form.note.value.trim();
        const city = form.city.value.trim();
        const phone = form.phone.value.trim();
        const entryBy = form.entry_by.value.trim();
        const itemsInputs = form.querySelectorAll('input[name="items[]"]');

        let errors = [];

        if (!/^\d+$/.test(amount)) {
            errors.push('Amount must be numbers only.');
        }

        if (!/^[\p{L}\p{N} ]+$/u.test(buyer) || buyer.length > 20) {
            errors.push('Buyer: only letters, numbers, spaces, max 20 chars.');
        }

        if (receiptId.length === 0) {
            errors.push('Receipt ID is required.');
        }

        let hasItem = false;
        itemsInputs.forEach(input => {
            if (input.value.trim().length > 0) {
                hasItem = true;
            }
        });
        if (!hasItem) {
            errors.push('At least one item is required.');
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(buyerEmail)) {
            errors.push('Valid buyer email is required.');
        }

        if (note.length > 0) {
            const words = note.trim().split(/\s+/);
            if (words.length > 30) {
                errors.push('Note must not exceed 30 words.');
            }
        }

        if (!/^[\p{L} ]+$/u.test(city)) {
            errors.push('City: only letters and spaces.');
        }

        if (!/^\d+$/.test(phone)) {
            errors.push('Phone must be numeric.');
        }

        if (!/^\d+$/.test(entryBy)) {
            errors.push('Entry_by must be numeric.');
        }

        return errors;
    }

    if (phoneInput) {
        phoneInput.addEventListener('blur', function () {
            let v = phoneInput.value.trim();
            v = v.replace(/\D/g, '');
            if (v && !v.startsWith('880')) {
                v = '880' + v;
            }
            phoneInput.value = v;
        });
    }

    addItemBtn.addEventListener('click', function () {
        const label = document.createElement('label');
        label.textContent = 'Items: ';
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'items[]';
        label.appendChild(input);
        itemsWrapper.appendChild(document.createElement('br'));
        itemsWrapper.appendChild(label);
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const errors = validateForm();
        if (errors.length > 0) {
            showMessages(errors, true);
            return;
        }

        const formData = new FormData(form);

        fetch('?route=submission/store', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showMessages([data.message], false);
                    form.reset();
                } else {
                    showMessages(data.errors || ['Unknown error'], true);
                }
            })
            .catch(() => {
                showMessages(['AJAX error occurred.'], true);
            });
    });
});
