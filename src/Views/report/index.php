<h1>Submission Report</h1>

<form method="get" action="">
    <input type="hidden" name="route" value="report/index">
    <label>From:
        <input type="date" name="from" value="<?php echo htmlspecialchars($filters['from'] ?? '') ?>">
    </label>
    <label>To:
        <input type="date" name="to" value="<?php echo htmlspecialchars($filters['to'] ?? '') ?>">
    </label>
    <label>User ID:
        <input type="text" name="user_id" value="<?php echo htmlspecialchars((string) ($filters['user_id'] ?? '')) ?>">
    </label>
    <button type="submit">Filter</button>
</form>

<table border="1" cellspacing="0" cellpadding="4">
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
        <th>Entry At</th>
        <th>Entry By</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($submissions as $s): ?>
        <tr>
            <td><?php echo (int) $s['id'] ?></td>
            <td><?php echo (int) $s['amount'] ?></td>
            <td><?php echo htmlspecialchars($s['buyer']) ?></td>
            <td><?php echo htmlspecialchars($s['receipt_id']) ?></td>
            <td><?php echo htmlspecialchars($s['items']) ?></td>
            <td><?php echo htmlspecialchars($s['buyer_email']) ?></td>
            <td><?php echo htmlspecialchars($s['buyer_ip']) ?></td>
            <td><?php echo htmlspecialchars($s['note']) ?></td>
            <td><?php echo htmlspecialchars($s['city']) ?></td>
            <td><?php echo htmlspecialchars($s['phone']) ?></td>
            <td><?php echo htmlspecialchars($s['entry_at']) ?></td>
            <td><?php echo (int) $s['entry_by'] ?></td>
            <td>
                <a href="?route=submission/edit&id=<?= (int) $s['id'] ?>">
                    <button type="button" class="action-btn btn-edit">Edit</button>
                </a>

                <form method="post" action="?route=submission/delete" style="display:inline;"
                        onsubmit="return confirm('Are you sure you want to delete this submission?');">
                    <input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
                    <button type="submit" class="action-btn btn-delete">Delete</button>
                </form>
                </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
