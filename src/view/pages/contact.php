<?php $title = 'Athletiq | Contact'; ?>
<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/nav.php'; ?>

<div class="contact-page">

    <section class="contact-hero">
        <div class="contact-hero-content">
            <p class="contact-eyebrow">ATHLETIQ SUPPORT</p>
            <h1>Contact us</h1>
            <p class="contact-hero-text">
                Got a question about an order, sizing, or a product drop? Send us a message and we’ll get back to you.
            </p>
        </div>
    </section>

    <section class="contact-shell">

        <div class="contact-card contact-info-card">
            <h2>Get in touch</h2>
            <p class="contact-info-intro">
                We’re here to help with orders, account questions, and general enquiries.
            </p>

            <div class="contact-info-list">

                <div class="contact-info-item">
                    <div>
                        <h3>Address</h3>
                        <p>
                            Aston University<br>
                            Birmingham<br>
                            B4 7ET
                        </p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div>
                        <h3>Email</h3>
                        <p>athletiq@aston.ac.uk</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div>
                        <h3>Phone</h3>
                        <p>0121 204 4007</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="contact-card contact-form-card">
            <h2>Send a message</h2>
            <p class="contact-form-intro">
                Fill out the form below and we’ll lend you a hand.
            </p>

            <form method="post" action="/contact" class="contact-form-modern">

                <div class="contact-form-grid">
                    <div class="contact-field">
                        <label for="contact_name">Full name</label>
                        <input
                            id="contact_name"
                            type="text"
                            name="name"
                            placeholder="Full Name"
                            required
                        >
                    </div>

                    <div class="contact-field">
                        <label for="contact_email">Email address</label>
                        <input
                            id="contact_email"
                            type="email"
                            name="email"
                            placeholder="athletiq@example.com"
                            required
                        >
                    </div>
                </div>

                <div class="contact-field">
                    <label for="contact_message">Message</label>
                    <textarea
                        id="contact_message"
                        name="message"
                        placeholder="Tell us how we can help..."
                        required
                    ></textarea>
                </div>

                <div class="contact-submit">
                    <button type="submit" class="contact-submit-btn">Send message</button>
                </div>

            </form>
        </div>

    </section>

</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>