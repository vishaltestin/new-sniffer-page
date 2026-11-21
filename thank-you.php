<?php
    include "include/class.digitalfueled.php";
    $obj_df    = new DigitalFueledClass();
    $chk_class = $obj_df->call_to_class();

    if (isset($_GET['id'])) {
    if (! preg_match('/^[a-zA-Z0-9\s.,#()\/&\'"@:;!\-]+$/', $_GET['id'])) {
        echo "<span style='color:red;'>Please enter correct id</span>";
        exit;
    }
    }

    if (isset($_GET['type'])) {
    if (! preg_match('/^[a-zA-Z0-9\s.,#()\/&\'"@:;!\-]+$/', $_GET['type'])) {
        echo "<span style='color:red;'>Please enter correct your type</span><br/>";
        exit;
    }
    }

    $num = 0;
    if (isset($_GET['type']) && isset($_GET['id'])) {
    if ($_GET['type'] == "doubledonation") {
        $sql12 = "SELECT * FROM `partner_po_users` where md5(id)='" . mysqli_real_escape_string($_SESSION['conn'], $_GET['id']) . "'";
        $rs12  = $obj_df->execute_query($sql12);
        $row1  = mysqli_fetch_array($rs12);
        $num   = mysqli_num_rows($rs12);
    }
 
    }

    if ($num == 0) {
    header('location:https://donate.wwfindia.org/double-your-donation');
    exit;
    }

    if ($row1['trans_id'] == '' && $row1['tracking_id'] == '') {
    header('location:https://donate.wwfindia.org/double-your-donation');
    exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You | WWF-India</title>

    <!-- Retained your fonts for WWF consistency -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;0,800;1,400&display=swap"
        rel="stylesheet" />
<link rel="stylesheet" href="css/index.css" />

 <?php include 'includes/head.php'; ?>

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    body {
        background-color: #f8fafc;
        color: #0f172a;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .thank-you-wrapper {
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
    }

    .container {
        width: 100%;
        max-width: 600px;
        text-align: center;
        background-color: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        animation: fadeIn 0.8s ease-out;
        margin: 0 auto;
    }

    .icon {
        width: 80px;
        height: 80px;
        background-color: #dcfce7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
    }
.header-donate{
    display: none !important;
}
    .success-checkmark {
        width: 40px;
        height: 40px;
        position: relative;
    }

    .check-icon {
        width: 40px;
        height: 40px;
        position: relative;
        border-radius: 50%;
        transform: scale(1);
        animation: fill 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    h1 {
        margin-bottom: 24px;
        font-size: 32px;
        font-weight: 600;
        color: #0f172a;
    }

    .info-box {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 32px;
        text-align: left;
        background: #f8fafc;
        padding: 20px;
        border-radius: 8px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        border-bottom: 1px dashed #cbd5e1;
        padding-bottom: 8px;
    }

    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-row strong {
        color: #475569;
    }

    .info-row span {
        font-weight: 600;
        color: #0f172a;
    }

    .btn {
        display: inline-block;
        padding: 12px 28px;
        background-color: #dd681b;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        font-size: 16px;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(221, 104, 27, 0.2);
    }

    .btn:hover {
        background-color: #00b9ad;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 185, 173, 0.3);
    }

    .confetti {
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: #dd681b;
        opacity: 0;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fill {
        100% {
            transform: scale(1);
            box-shadow: inset 0 0 0 2000px rgba(255, 255, 255, 0);
        }
    }

    @keyframes scale {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 30px 20px;
        }

        h1 {
            font-size: 24px;
        }

        .info-row {
            flex-direction: column;
            gap: 4px;
        }
    }
    </style>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="thank-you-wrapper">
        <div class="container">
            <div class="icon">
                <div class="success-checkmark">
                    <div class="check-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="50" height="50"
                            viewBox="0 0 507.2 507.2" style="enable-background:new 0 0 512 512">
                            <g>
                                <circle cx="253.6" cy="253.6" r="253.6" fill="#32ba7c"></circle>
                                <path d="m188.8 368 130.4 130.4c108-28.8 188-127.2 188-244.8v-7.2L404.8 152l-216 216z"
                                    fill="#0aa06e"></path>
                                <path
                                    d="M260 310.4c11.2 11.2 11.2 30.4 0 41.6l-23.2 23.2c-11.2 11.2-30.4 11.2-41.6 0L93.6 272.8c-11.2-11.2-11.2-30.4 0-41.6l23.2-23.2c11.2-11.2 30.4-11.2 41.6 0L260 310.4z"
                                    fill="#ffffff"></path>
                                <path
                                    d="M348.8 133.6c11.2-11.2 30.4-11.2 41.6 0l23.2 23.2c11.2 11.2 11.2 30.4 0 41.6l-176 175.2c-11.2 11.2-30.4 11.2-41.6 0l-23.2-23.2c-11.2-11.2-11.2-30.4 0-41.6l176-175.2z"
                                    fill="#ffffff"></path>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>

            <h1>Thank you for your contribution!</h1>

            <?php if (isset($_GET['type']) && ($_GET['type'] == "doubledonation")) {?>
            <div class="info-box">
                <div class="info-row">
                    <strong>Name: </strong>
                    <span><?php echo $row1['fname'] ?> <?php echo $row1['lname'] ?></span>
                </div>
                <div class="info-row">
                    <strong>Amount: </strong>
                    <span>₹<?php echo $row1['amount'] ?></span>
                </div>
                <?php if ($row1['trans_id'] != '') {?>
                <div class="info-row">
                    <strong>Transaction ID: </strong>
                    <span><?php echo $row1['trans_id'] ?></span>
                </div>
                <?php }?>
            </div>
            <?php }?>

           

            <a class="btn" href="index.php">Return to Homepage</a>
        </div>
    </div>

    <script>
    // Create confetti animation
    function createConfetti() {
        const colors = ['#0ea5e9', '#34d399', '#f472b6', '#facc15', '#8b5cf6', '#dd681b'];
        const confettiCount = 100;

        for (let i = 0; i < confettiCount; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';

            const size = Math.random() * 8 + 6;
            const color = colors[Math.floor(Math.random() * colors.length)];

            confetti.style.width = `${size}px`;
            confetti.style.height = `${size}px`;
            confetti.style.background = color;
            confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
            confetti.style.left = `${Math.random() * 100}vw`;
            confetti.style.top = `-20px`;
            confetti.style.position = 'fixed';
            confetti.style.zIndex = '9999';

            document.body.appendChild(confetti);

            const duration = Math.random() * 3 + 2;
            const delay = Math.random() * 0.5;

            confetti.style.animation = `
                    fadeIn ${duration}s ease-in ${delay}s forwards,
                    fall ${duration}s ease-in ${delay}s forwards
                `;

            // Clean up confetti
            setTimeout(() => {
                if (document.body.contains(confetti)) {
                    document.body.removeChild(confetti);
                }
            }, (duration + delay) * 1000);
        }

        // Add keyframes dynamically if not present
        if (!document.getElementById('confetti-keyframes')) {
            const style = document.createElement('style');
            style.id = 'confetti-keyframes';
            style.innerHTML = `
                    @keyframes fall {
                        0% { transform: translateY(0) rotate(0deg); opacity: 0; }
                        10% { opacity: 1; }
                        100% { transform: translateY(100vh) rotate(${Math.random() * 720 - 360}deg); opacity: 0; }
                    }
                `;
            document.head.appendChild(style);
        }
    }

    // Trigger confetti on page load
    window.addEventListener('load', createConfetti);
    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/4.0.0/jquery.min.js" integrity="sha512-YuCuk5nNmVIUfKROKeV3fpZZ5Vt9vsnq8nExr5JwEJc2r1YDVmDfujcq373eHIzjqdxwCzoKpxngIaAdRUyg3A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php include 'includes/footer.php'; ?>
    
    <script>
window.dataLayer = window.dataLayer || [];

window.dataLayer.push({
    event: 'thank_you_conversion',
    donation_value: '<?php echo $row1["amount"]; ?>',
    currency: 'INR',
    transaction_id: '<?php echo $row1["trans_id"]; ?>',
    user_email: '<?php echo $row1["email"]; ?>'
});
</script>
    
    
    
</body>

</html>