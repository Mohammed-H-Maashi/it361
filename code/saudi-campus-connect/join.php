<?php
require_once 'includes/db.php';
require_once 'includes/helpers.php';
$pageTitle = 'Join an Activity';
$errors = [];
$success = null;
$name = '';
$universityId = '';
$email = '';
$mobile = '';
$activityId = filter_input(INPUT_GET, 'activity_id', FILTER_VALIDATE_INT) ?: '';
$agreed = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['student_name'] ?? '');
    $universityId = trim($_POST['university_id'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobile = trim($_POST['mobile_number'] ?? '');
    $activityId = filter_var($_POST['activity_id'] ?? '', FILTER_VALIDATE_INT);
    $agreed = isset($_POST['agreement']);

    if (mb_strlen($name) < 3 || !preg_match("/^[\p{Arabic}A-Za-z\s'\-]+$/u", $name)) {
        $errors[] = 'Enter a valid student name using letters, spaces, apostrophes, or hyphens.';
    }
    if (!validUniversityId($universityId)) {
        $errors[] = 'University ID must contain 8 to 12 letters or numbers.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid university email address.';
    }
    if (!validSaudiMobile($mobile)) {
        $errors[] = 'Enter a Saudi mobile number such as 05XXXXXXXX or +9665XXXXXXXX.';
    }
    if (!$agreed) {
        $errors[] = 'You must confirm that the submitted information is accurate.';
    }

    $activity = $activityId ? getActivityById($conn, $activityId) : null;
    if (!$activity) {
        $errors[] = 'Select a valid activity.';
    } elseif (availablePlaces($conn, $activity) < 1) {
        $errors[] = 'This activity is already full.';
    }

    if ($activity && duplicateRegistration($conn, $universityId, $activityId)) {
        $errors[] = 'This university ID is already registered for the selected activity.';
    }

    if (!$errors) {
        $stmt = mysqli_prepare($conn, "INSERT INTO participants (student_name, university_id, email, mobile_number, activity_id) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssssi', $name, $universityId, $email, $mobile, $activityId);
        if (mysqli_stmt_execute($stmt)) {
            $success = [
                'id' => mysqli_insert_id($conn),
                'name' => $name,
                'title' => $activity['title'],
                'date' => $activity['activity_date'],
                'registered' => date('j F Y, g:i A')
            ];
            $name = $universityId = $email = $mobile = '';
            $activityId = '';
            $agreed = false;
        } else {
            $errors[] = 'The registration could not be saved. Please review the details and try again.';
        }
    }
}

$activities = getAllFutureActivities($conn);
require 'includes/header.php';
?>
<section class="section-space">
    <div class="container form-page-grid">
        <section>
            <p class="eyebrow">Student Registration</p>
            <h1>Join an Upcoming Activity</h1>
            <p>Complete the form below. All registration checks are completed on the server before the record is saved.</p>
            <aside class="info-panel">
                <h2>Before registering</h2>
                <ul>
                    <li>Use your correct university ID.</li>
                    <li>Choose one available activity.</li>
                    <li>Provide a Saudi mobile number.</li>
                </ul>
            </aside>
        </section>
        <section class="form-card">
            <?php if ($success): ?>
                <div class="success-message">
                    <h2>Registration confirmed</h2>
                    <p><strong>Registration number:</strong> <?= (int) $success['id'] ?></p>
                    <p><strong>Student:</strong> <?= e($success['name']) ?></p>
                    <p><strong>Activity:</strong> <?= e($success['title']) ?></p>
                    <p><strong>Activity date:</strong> <?= e(formatDate($success['date'])) ?></p>
                    <p><strong>Registered:</strong> <?= e($success['registered']) ?></p>
                    <div class="button-row"><a class="button" href="activities.php">View Activities</a><a class="button button-secondary" href="participants.php">View Participants</a></div>
                </div>
            <?php endif; ?>
            <?php if ($errors): ?>
                <div class="error-message">
                    <h2>Please correct the following</h2>
                    <ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul>
                </div>
            <?php endif; ?>
            <form method="post" novalidate>
                <fieldset>
                    <legend>Student details</legend>
                    <div class="field"><label for="student_name">Student name</label><input id="student_name" name="student_name" type="text" value="<?= e($name) ?>" required></div>
                    <div class="field"><label for="university_id">University ID</label><input id="university_id" name="university_id" type="text" value="<?= e($universityId) ?>" maxlength="12" required></div>
                    <div class="field"><label for="email">University email</label><input id="email" name="email" type="email" value="<?= e($email) ?>" required></div>
                    <div class="field"><label for="mobile_number">Saudi mobile number</label><input id="mobile_number" name="mobile_number" type="tel" value="<?= e($mobile) ?>" placeholder="05XXXXXXXX" required></div>
                </fieldset>
                <fieldset>
                    <legend>Activity selection</legend>
                    <div class="field"><label for="activity_id">Selected activity</label><select id="activity_id" name="activity_id" required>
                            <option value="">Choose an activity</option><?php while ($item = mysqli_fetch_assoc($activities)): ?><option value="<?= (int) $item['id'] ?>" <?= (string) $activityId === (string) $item['id'] ? 'selected' : '' ?>><?= e($item['title']) ?> — <?= e($item['city']) ?></option><?php endwhile; ?>
                        </select></div>
                    <label class="checkbox-row"><input type="checkbox" name="agreement" value="1" <?= $agreed ? 'checked' : '' ?>> I confirm that the information entered is accurate.</label>
                </fieldset>
                <button class="button" type="submit">Submit Registration</button>
            </form>
        </section>
    </div>
</section>
<?php require 'includes/footer.php'; ?>