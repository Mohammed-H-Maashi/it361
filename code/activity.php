<?php
require_once 'includes/db.php';
require_once 'includes/helpers.php';
$pageTitle = 'Activity Details';
$activity = null;
$error = '';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    $error = 'The requested activity link is not valid.';
} else {
    $activity = getActivityById($conn, $id);
    if (!$activity) {
        $error = 'The requested activity could not be found.';
    }
}
require 'includes/header.php';
?>
<section class="section-space">
    <div class="container">
        <?php if ($error): ?>
            <div class="empty-state">
                <h1>Activity unavailable</h1>
                <p><?= e($error) ?></p><a class="button" href="activities.php">Return to Activities</a>
            </div>
        <?php else: ?>
            <?php $registered = countRegistrations($conn, $activity['id']);
            $remaining = max(0, $activity['capacity'] - $registered); ?>
            <article class="detail-layout">
                <img class="detail-image" src="images/<?= e($activity['image_name']) ?>" alt="<?= e($activity['title']) ?>">
                <div class="detail-content">
                    <p class="badge"><?= e($activity['category']) ?></p>

                    <h1><?= e($activity['title']) ?></h1>
                    <p class="lead"><?= e($activity['full_details']) ?></p>
                    <dl class="detail-list">
                        <div>
                            <dt>Date</dt>
                            <dd><?= e(formatDate($activity['activity_date'])) ?></dd>
                        </div>
                        <div>
                            <dt>Time</dt>
                            <dd><?= e(formatTime($activity['start_time'])) ?></dd>
                        </div>
                        <div>
                            <dt>Venue</dt>
                            <dd><?= e($activity['venue']) ?></dd>
                        </div>
                        <div>
                            <dt>City</dt>
                            <dd><?= e($activity['city']) ?></dd>
                        </div>
                        <div>
                            <dt>Capacity</dt>
                            <dd><?= (int) $activity['capacity'] ?></dd>
                        </div>
                        <div>
                            <dt>Registered</dt>
                            <dd><?= $registered ?></dd>
                        </div>
                        <div>
                            <dt>Remaining</dt>
                            <dd><?= $remaining ?></dd>
                        </div>
                    </dl>
                    <div class="button-row">
                        <?php if ($remaining > 0): ?>
                            <a class="button" href="join.php?activity_id=<?= (int) $activity['id'] ?>">Join This Activity</a>
                        <?php else: ?>
                            <span class="button disabled">Registration Closed — Activity Full</span>
                        <?php endif; ?>
                        <a class="button button-secondary" href="activities.php">Return to Activities</a>
                    </div>
                </div>
            </article>
        <?php endif; ?>
    </div>
</section>
<?php require 'includes/footer.php'; ?>