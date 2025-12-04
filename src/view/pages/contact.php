<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="icon" href="/src/view/images/logos/athletiq_logo.png" type="image/x-icon">
    <link rel="icon" href="/src/view/images/logos/athletiq_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/src/view/css/nav.css">
    <link rel="stylesheet" href="/src/view/css/footer.css">
    <link rel="stylesheet" href="/src/view/css/contact.css">
    <link rel='stylesheet' href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css'>
</head>

<body>
    
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
                <p>Athletiq@aston.ac.uk</p>

                <i class='bx bx-phone'></i> 
                <h3 class="header3">Phone</h3>
                <p>0121 204 4007</p>
            </div>

            <div class="contact_form">
                <h2>Write your inquiry</h2>
                <p>Need to get in touch? Fill out this form to send us a message and we'll lend you a hand</p>

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

</body>
</html>
