<?php $title = 'Athletiq | Contact'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="contactUsPage">

    <div class="header">
        <h1>Contact Us</h1>
    </div>

    <div class="container">

        <div class="contact_details">
            <h2>Our contact details</h2>

            <i class='bx bx-location'></i>
            <h3 class="header3">Address</h3>
            <p>
                Aston University<br>
                Birmingham<br>
                B4 7ET
            </p>

            <i class='bx bx-envelope'></i>
            <h3 class="header3">Email</h3>
            <p>athletiq@aston.ac.uk</p>

            <i class='bx bx-phone'></i>
            <h3 class="header3">Phone</h3>
            <p>0121 204 4007</p>
        </div>

        <div class="contact_form">
            <h2>Write your inquiry</h2>
            <p>Need to get in touch? Fill out this form to send us a message and we'll lend you a hand.</p>

            <form method="post" action="/contact">

                <div class="input-box">
                    <input type="text" name="name" placeholder="Enter your full name" required>
                </div>

                <div class="input-box">
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="message-box">
                    <textarea name="message" placeholder="Enter your message" required></textarea>
                </div>

                <div class="submit">
                    <button type="submit" class="send_message">Submit</button>
                </div>

            </form>

        </div>

    </div>

</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>