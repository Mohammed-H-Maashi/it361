CREATE DATABASE IF NOT EXISTS saudi_campus_connect
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE saudi_campus_connect;

CREATE TABLE activities (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    category VARCHAR(60) NOT NULL,
    activity_date DATE NOT NULL,
    start_time TIME NOT NULL,
    venue VARCHAR(150) NOT NULL,
    city VARCHAR(80) NOT NULL,
    short_summary VARCHAR(255) NOT NULL,
    full_details TEXT NOT NULL,
    image_name VARCHAR(120) NOT NULL,
    capacity INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE participants (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(120) NOT NULL,
    university_id VARCHAR(12) NOT NULL,
    email VARCHAR(150) NOT NULL,
    mobile_number VARCHAR(16) NOT NULL,
    activity_id INT UNSIGNED NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_participant_activity
        FOREIGN KEY (activity_id) REFERENCES activities(id)
        ON DELETE CASCADE,
    CONSTRAINT unique_student_activity
        UNIQUE (university_id, activity_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE inquiries (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sender_name VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL,
    inquiry_type VARCHAR(60) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO activities
(title, category, activity_date, start_time, venue, city, short_summary, full_details, image_name, capacity)
VALUES
('Innovation Majlis: Student Ideas for Vision 2030', 'Innovation', '2027-02-18', '10:00:00', 'University Innovation Hall', 'Riyadh',
 'A student discussion and pitching session focused on practical ideas that support Saudi Vision 2030.',
 'Students will work in small teams to shape ideas connected to entrepreneurship, digital transformation, quality of life, and community development. Each team will prepare a short concept and present it to mentors from the university. The session is designed for beginners and focuses on clear problem definition, practical solutions, and confident presentation. Participants will also receive simple feedback that can help them improve their ideas after the event.',
 'innovation-majlis.jpg', 60),

('Historical Diriyah Learning Visit', 'Cultural', '2027-03-04', '08:00:00', 'At-Turaif District', 'Diriyah',
 'An educational visit that connects students with Saudi history, architecture, and heritage preservation.',
 'This guided visit introduces students to the historical importance of Diriyah and the At-Turaif District. Participants will observe traditional Najdi architecture, learn about the First Saudi State, and discuss how heritage sites are protected and presented to visitors. The activity encourages cultural awareness and respectful engagement with national history. Transportation will depart from the university, and students should arrive at the meeting point at least fifteen minutes before departure.',
 'diriyah-visit.jpg', 45),

('Arabic Calligraphy Creative Workshop', 'Arts', '2027-03-16', '16:00:00', 'Student Cultural Studio', 'Jeddah',
 'A practical introduction to Arabic calligraphy using simple tools, guided practice, and creative exercises.',
 'Participants will learn about basic Arabic calligraphy styles, letter balance, spacing, and the use of traditional writing tools. The instructor will demonstrate simple techniques before students create a short personal design. The workshop is suitable for complete beginners and aims to connect artistic practice with Arabic cultural identity. Materials will be provided, and students may keep their final practice sheet as a record of the activity.',
 'arabic-calligraphy.jpg', 30),

('Saudi Graduate Career Readiness Forum', 'Career', '2027-04-06', '11:30:00', 'Main University Auditorium', 'Riyadh',
 'A practical forum covering CV writing, interviews, networking, and expectations in the Saudi labor market.',
 'Career advisers and invited professionals will discuss how students can prepare for internships and graduate employment in Saudi Arabia. The forum covers clear CV writing, professional communication, interview preparation, LinkedIn use, and workplace expectations. Students will review short examples and take part in a question session. The event also introduces growing sectors linked to national development and encourages participants to plan realistic next steps for their careers.',
 'career-forum.jpg', 120),

('Community Volunteer Day', 'Volunteering', '2027-04-19', '08:30:00', 'Eastern Province Community Center', 'Dammam',
 'A supervised day of community service that develops teamwork, responsibility, and practical volunteering experience.',
 'Students will join small volunteer teams to support community-center activities, organize donated materials, and prepare useful spaces for visitors. Before starting, coordinators will explain safety, respectful communication, and task responsibilities. The activity helps students understand the value of organized volunteering and social contribution. Participants should wear comfortable clothing and follow the instructions of the center staff throughout the day.',
 'volunteer-day.jpg', 70),

('Cybersecurity Awareness for University Students', 'Technology', '2027-05-03', '13:00:00', 'College of Computing Lab', 'Riyadh',
 'A focused awareness session on phishing, passwords, privacy, and safer use of university and personal accounts.',
 'The session explains common cyber risks faced by university students, including fake login pages, suspicious messages, weak passwords, unsafe public networks, and oversharing personal information. Students will review realistic examples and learn simple steps such as using multi-factor authentication, checking links carefully, updating devices, and reporting incidents. The content is practical and suitable for students from all academic majors.',
 'cybersecurity-session.jpg', 55),

('Green Campus Sustainability Workshop', 'Sustainability', '2027-05-17', '10:30:00', 'Environmental Activities Center', 'Abha',
 'A hands-on workshop about reducing waste, conserving water, and improving sustainable habits on campus.',
 'Students will examine everyday sustainability challenges found in university life, such as unnecessary printing, food waste, water use, and poor recycling habits. Working in groups, they will suggest low-cost improvements that could be applied on campus. The workshop also connects environmental responsibility with local conditions in Saudi Arabia. Each group will finish by presenting one realistic action that students can begin using immediately.',
 'sustainability-workshop.jpg', 40);
