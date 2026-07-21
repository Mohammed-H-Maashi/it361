<?php
require_once 'includes/db.php';
require_once 'includes/helpers.php';
$pageTitle = 'Contact';
$allowedTypes = ['General Question', 'Activity Information', 'Registration Support', 'Accessibility Request', 'Partnership Suggestion'];
$name = $email = $type = $message = '';
$errors = [];
$sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['sender_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $type = trim($_POST['inquiry_type'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if (mb_strlen($name) < 3) $errors[] = 'Full name must contain at least three characters.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (!in_array($type, $allowedTypes, true)) $errors[] = 'Select a valid inquiry type.';
    if (mb_strlen($message) < 15 || mb_strlen($message) > 1000) $errors[] = 'Message must contain between 15 and 1000 characters.';
    if (!$errors) {
        $stmt = mysqli_prepare($conn, "INSERT INTO inquiries (sender_name, email, inquiry_type, message) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $type, $message);
        if (mysqli_stmt_execute($stmt)) {
            $sent = true;
            $name = $email = $type = $message = '';
        } else {
            $errors[] = 'The inquiry could not be saved. Please try again.';
        }
    }
}
require 'includes/header.php';
?>
<section class="section-space">
    <div class="container form-page-grid">
        <section>
            <p class="eyebrow">Contact the Center</p>
            <h1>Send an Inquiry</h1>
            <p>Use this form for questions about activities, registration support, accessibility, or partnership ideas.</p>
            <aside class="info-panel">
                <h2>Contact information</h2>
                <p>Riyadh, Saudi Arabia</p>
                <p>Sunday–Thursday</p>
                <p>8:00 AM–4:00 PM</p>
                <p><a href="mailto:activities@saudicampus.test">activities@saudicampus.test</a></p>
            </aside>
        </section>
        <section class="form-card">
            <?php if ($sent): ?><div class="success-message">
                    <h2>Inquiry received</h2>
                    <p>Thank you. Your message has been stored successfully.</p>
                </div><?php endif; ?>
            <?php if ($errors): ?><div class="error-message">
                    <h2>Please correct the following</h2>
                    <ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul>
                </div><?php endif; ?>
            <form method="post" novalidate>
                <div class="field"><label for="sender_name">Full name</label><input id="sender_name" name="sender_name" type="text" value="<?= e($name) ?>" required></div>
                <div class="field"><label for="email">Email</label><input id="email" name="email" type="email" value="<?= e($email) ?>" required></div>
                <div class="field"><label for="inquiry_type">Inquiry type</label><select id="inquiry_type" name="inquiry_type" required>
                        <option value="">Choose a type</option><?php foreach ($allowedTypes as $item): ?><option value="<?= e($item) ?>" <?= $type === $item ? 'selected' : '' ?>><?= e($item) ?></option><?php endforeach; ?>
                    </select></div>
                <div class="field"><label for="message">Message</label><textarea id="message" name="message" rows="7" maxlength="1000" required><?= e($message) ?></textarea></div>
                <button class="button" type="submit">Submit Inquiry</button>
            </form>
        </section>
    </div>
</section>

<?php require 'includes/footer.php'; ?>