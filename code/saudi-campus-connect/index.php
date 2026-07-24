<?php
require_once 'includes/db.php';
require_once 'includes/helpers.php';
$pageTitle = 'Home';
$upcoming = getNextActivities($conn, 4);
$featuredResult = getNextActivities($conn, 1);
$featured = mysqli_fetch_assoc($featuredResult);
require 'includes/header.php';
?>
<section class="hero section-space">
    <div class="container hero-grid">
        <div class="hero-copy">
            <p class="eyebrow">Saudi Student Experiences</p>
            <h1>Discover Opportunities Beyond the Classroom</h1>
            <p>Explore practical, cultural, and community activities created for university students across Saudi Arabia.</p>
            <div class="button-row">
                <a class="button" href="activities.php">Explore Activities</a>
                <a class="button button-secondary" href="join.php">Join an Activity</a>
            </div>
        </div>
        <?php if ($featured): ?>
            <article class="featured-panel">
                <p class="badge"><?= e($featured['category']) ?></p>
                <p class="panel-label">Featured next activity</p>
                <h2><?= e($featured['title']) ?></h2>
                <dl class="compact-details">
                    <div>
                        <dt>Date</dt>
                        <dd><?= e(formatDate($featured['activity_date'])) ?></dd>
                    </div>
                    <div>
                        <dt>City</dt>
                        <dd><?= e($featured['city']) ?></dd>
                    </div>
                    <div>
                        <dt>Places</dt>
                        <dd><?= availablePlaces($conn, $featured) ?> remaining</dd>
                    </div>
                </dl>
                <a class="text-link" href="activity.php?id=<?= (int) $featured['id'] ?>">View activity details →</a>
            </article>
        <?php endif; ?>
    </div>
</section>



<section class="section-space">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Coming Soon</p>
            <h2>Upcoming Activities</h2>
        </div>
        <div class="activity-list">
            <?php while ($activity = mysqli_fetch_assoc($upcoming)): ?>
                <article class="activity-row">
                    <div class="activity-date-box">
                        <span><?= date('d', strtotime($activity['activity_date'])) ?></span>
                        <small><?= date('M', strtotime($activity['activity_date'])) ?></small>
                    </div>
                    <div class="activity-row-copy">
                        <p class="badge"><?= e($activity['category']) ?></p>
                        <h3><?= e($activity['title']) ?></h3>
                        <p><?= e($activity['short_summary']) ?></p>
                        <p class="meta"><?= e($activity['city']) ?> · <?= availablePlaces($conn, $activity) ?> places remaining</p>
                    </div>
                    <a class="button button-small" href="activity.php?id=<?= (int) $activity['id'] ?>">Details</a>
                </article>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<section class="sand-section section-space">
    <div class="container">
        <div class="section-heading">
            <h2>Why Participate?</h2>
        </div>
        <div class="benefit-grid">
            <article><span>01</span>
                <h3>Build practical skills</h3>
                <p>Practice communication, teamwork, planning, creativity, and problem solving outside regular classes.</p>
            </article>
            <article><span>02</span>
                <h3>Connect with students</h3>
                <p>Meet students from different majors and campuses while working toward shared goals.</p>
            </article>
            <article><span>03</span>
                <h3>Contribute to the community</h3>
                <p>Take part in volunteering and awareness activities that support responsibility and social participation.</p>
            </article>
        </div>
    </div>
</section>

<section class="values-section section-space">
    <div class="container values-grid">
        <div>
            <p class="eyebrow">Student Values</p>
            <h2>Learning with purpose</h2>
        </div>
        <div class="value-tags"><span>Responsibility</span><span>Collaboration</span><span>Innovation</span><span>Cultural awareness</span></div>
    </div>
</section>
<?php require 'includes/footer.php'; ?>