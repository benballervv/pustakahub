<div class="col-md-3">
    <div class="right-panel">
        <div class="profile-box">
            <div class="avatar">
                <?= strtoupper(substr(session()->get('nama') ?? 'U', 0, 1)) ?>
            </div>
            <div>
                <h6 class="mb-0 fw-bold"><?= session()->get('nama') ?? 'User' ?></h6>
                <small class="text-muted"><?= session()->get('role') ?? 'Member' ?></small>
            </div>
        </div>

        <div class="calendar-container">
            </div>
        <div class="activity-section">
            </div>
    </div>
</div>