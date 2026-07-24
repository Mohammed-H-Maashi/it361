<?php
require_once 'includes/db.php';
require_once 'includes/helpers.php';
$pageTitle = 'Activities';
$activities = getAllFutureActivities($conn);
require 'includes/header.php';
?>
<section class="page-intro section-space">
    <div class="container narrow">
        <p class="eyebrow">Programs and Events</p>
        <h1>Activities for Saudi University Students</h1>
        <p>Browse upcoming learning, cultural, career, volunteering, technology, and sustainability activities.</p>
        <div class="category-strip"><span>Innovation</span><span>Cultural</span><span>Arts</span><span>Career</span><span>Volunteering</span><span>Technology</span><span>Sustainability</span></div>
    </div>
</section>
<section class="section-space no-top">
    <div class="container">
        <?php if (mysqli_num_rows($activities) === 0): ?>
            <div class="empty-state">
                <h2>No upcoming activities</h2>
                <p>Please check again later for newly announced opportunities.</p>
            </div>
        <?php else: ?>
            <div class="activity-card-grid">
                <?php while ($activity = mysqli_fetch_assoc($activities)): ?>
                    <article class="activity-card">
                        <img src="images/<?= e($activity['image_name']) ?>" alt="<?= e($activity['title']) ?>">
                        <div class="activity-card-body">
                            <p class="badge"><?= e($activity['category']) ?></p>
                            <h2><?= e($activity['title']) ?></h2>
                            <p class="meta"><?= e($activity['city']) ?> · <?= e($activity['venue']) ?></p>
                            <p class="meta"><?= e(formatDate($activity['activity_date'])) ?> at <?= e(formatTime($activity['start_time'])) ?></p>
                            <p><?= e($activity['short_summary']) ?></p>
                            <div class="card-footer-line">
                                <strong><?= availablePlaces($conn, $activity) ?> places left</strong>
                                <a class="text-link" href="activity.php?id=<?= (int) $activity['id'] ?>">View Activity →</a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php require 'includes/footer.php'; ?>