<h1>Data Submission</h1>

<form id="submission-form" novalidate>
    <label>Amount:
        <input type="text" name="amount" required>
    </label><br>

    <label>Buyer:
        <input type="text" name="buyer" maxlength="20" required>
    </label><br>

    <label>Receipt ID:
        <input type="text" name="receipt_id" required>
    </label><br>

    <div id="items-wrapper">
        <label>Items:
            <input type="text" name="items[]" required>
        </label>
    </div>
    <button type="button" id="add-item-btn">Add Item</button><br>

    <label>Buyer Email:
        <input type="email" name="buyer_email" required>
    </label><br>

    <label>Note:
        <textarea name="note" rows="3"></textarea>
    </label><br>

    <label>City:
        <input type="text" name="city" required>
    </label><br>

    <label>Phone:
        <input type="text" name="phone" id="phone-input" required>
    </label><br>

    <label>Entry By (User ID):
        <input type="text" name="entry_by" value="<?= (int) ($_SESSION['user_id'] ?? 0) ?>" required>
    </label><br>

    <button type="submit">Submit</button>
</form>

<div id="submission-messages"></div>

<script src="js/submission.js"></script>
