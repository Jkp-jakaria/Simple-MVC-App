<h1>Edit Submission</h1>

<?php if (!empty($errors)): ?>
    <ul class="error-list">
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="?route=submission/update&id=<?= (int) $submission['id'] ?>" novalidate>
    <label>Amount:
        <input type="text" name="amount" value="<?= htmlspecialchars((string) $submission['amount']) ?>" required>
    </label>

    <label>Buyer:
        <input type="text" name="buyer" maxlength="20" value="<?= htmlspecialchars($submission['buyer']) ?>" required>
    </label>

    <label>Receipt ID:
        <input type="text" name="receipt_id" value="<?= htmlspecialchars($submission['receipt_id']) ?>" required>
    </label>

    <div id="items-wrapper">
        <label>Items:
            <input type="text" name="items[]" value="<?= htmlspecialchars($submission['items']) ?>" required>
        </label>
    </div>

    <label>Buyer Email:
        <input type="email" name="buyer_email" value="<?= htmlspecialchars($submission['buyer_email']) ?>" required>
    </label>

    <label>Note:
        <textarea name="note" rows="3"><?= htmlspecialchars($submission['note']) ?></textarea>
    </label>

    <label>City:
        <input type="text" name="city" value="<?= htmlspecialchars($submission['city']) ?>" required>
    </label>

    <label>Phone:
        <input type="text" name="phone" value="<?= htmlspecialchars($submission['phone']) ?>" required>
    </label>

    <label>Entry By (User ID):
        <input type="text" name="entry_by" value="<?= htmlspecialchars((string) $submission['entry_by']) ?>" required>
    </label>

    <button type="submit">Update</button>
</form>
