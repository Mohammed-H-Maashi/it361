<?php
require_once 'includes/db.php';
require_once 'includes/helpers.php';
$pageTitle = 'Participants';
$sql = "SELECT p.id, p.student_name, p.university_id, p.email, p.mobile_number, p.registration_date,
               a.title, a.city, a.activity_date
        FROM participants p
        INNER JOIN activities a ON p.activity_id = a.id
        ORDER BY p.registration_date DESC";
$participants = mysqli_query($conn, $sql);
require 'includes/header.php';
?>
<section class="page-intro section-space">
    <div class="container narrow">
        <p class="eyebrow">Stored Records</p>
        <h1>Participant Registrations</h1>
        <p>This report demonstrates how saved MySQL registrations are combined with activity details using an SQL INNER JOIN.</p>
    </div>
</section>
<section class="section-space no-top">
    <div class="container">
        <?php if (mysqli_num_rows($participants) === 0): ?>
            <div class="empty-state">
                <h2>No registrations yet</h2>
                <p>Submitted registrations will appear here.</p>
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Student</th>
                            <th>University ID</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Activity</th>
                            <th>City</th>
                            <th>Activity Date</th>
                            <th>Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($participants)): ?><tr>
                                <td><?= (int) $row['id'] ?></td>
                                <td><?= e($row['student_name']) ?></td>
                                <td><?= e($row['university_id']) ?></td>
                                <td><?= e($row['email']) ?></td>
                                <td><?= e($row['mobile_number']) ?></td>
                                <td><?= e($row['title']) ?></td>
                                <td><?= e($row['city']) ?></td>
                                <td><?= e(formatDate($row['activity_date'])) ?></td>
                                <td><?= e(date('j M Y, g:i A', strtotime($row['registration_date']))) ?></td>
                            </tr><?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php require 'includes/footer.php'; ?>