# Saudi Campus Connect

## Required images
Place JPG files in the `images` folder using these exact names:

- `innovation-majlis.jpg` — Saudi students discussing ideas in a modern innovation space.
- `diriyah-visit.jpg` — At-Turaif or traditional Najdi architecture in Diriyah.
- `arabic-calligraphy.jpg` — Arabic calligraphy pens, ink, and practice sheets.
- `career-forum.jpg` — Saudi university students attending a career presentation.
- `volunteer-day.jpg` — Students participating in organized community service.
- `cybersecurity-session.jpg` — A university computer lab or cybersecurity awareness presentation.
- `sustainability-workshop.jpg` — Students discussing recycling, water conservation, or green-campus ideas.

Avoid official university logos and copyrighted branding.

## XAMPP installation

1. Install or open XAMPP.
2. Start **Apache** and **MySQL** from the XAMPP Control Panel.
3. Copy the complete `saudi-campus-connect` folder into:
   - Windows: `C:\xampp\htdocs\`
   - macOS XAMPP: `/Applications/XAMPP/htdocs/`
4. Open `http://localhost/phpmyadmin/`.
5. Select **Import**.
6. Choose `database/saudi_campus_connect.sql`.
7. Run the import and confirm that the `saudi_campus_connect` database contains `activities`, `participants`, and `inquiries`.
8. Open `http://localhost/saudi-campus-connect/`.

If the local MySQL username or password is different, edit `includes/db.php`.

## Page testing

- Open the Home page and confirm the featured and next four activities appear.
- Open Activities and confirm all future records are shown.
- Open `activity.php?id=1` and confirm the correct details load.
- Test `activity.php?id=9999` and a non-numeric ID to confirm friendly errors.
- Open an activity and confirm its ID preselects the Join form.
- Submit the Join form empty and confirm validation messages appear.
- Test an invalid email, mobile number, and university ID.
- Submit a valid registration and confirm the success panel and database row.
- Submit the same university ID for the same activity and confirm duplicate prevention.
- Reduce an activity capacity in phpMyAdmin to match its registration count and confirm full-capacity prevention.
- Open Participants and confirm the INNER JOIN table shows activity details.
- Submit the Contact form with invalid and valid data.
- Confirm a successful inquiry appears in the `inquiries` table.
- Test the layout at mobile width using browser developer tools.
- Check all navigation links, footer links, and image paths.
- Temporarily stop MySQL and confirm the friendly database connection message.

## Functional requirements checklist

- [x] Home page with featured and upcoming activities
- [x] Dynamic activities page
- [x] GET-based activity details page
- [x] Registration form
- [x] Server-side validation
- [x] MySQL participant storage
- [x] Participants list
- [x] About page
- [x] Contact form
- [x] Inquiry storage

## Technical requirements checklist

- [x] Semantic HTML5
- [x] One external stylesheet
- [x] Shared header and footer
- [x] PHP includes
- [x] MySQL database
- [x] MySQLi prepared statements
- [x] SQL INNER JOIN
- [x] PHP loops
- [x] Two forms
- [x] Data table
- [x] Responsive design
- [x] Input validation
- [x] Escaped output
- [x] Duplicate prevention
- [x] Capacity checking
- [x] Friendly error handling

The combined database unique constraint and the final capacity recheck reduce invalid records when multiple students try to register at nearly the same time.
