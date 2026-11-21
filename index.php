<?php
ob_start();
include("include/class.digitalfueled.php");
$obj_df = new DigitalFueledClass();
$chk_class = $obj_df->call_to_class();

$tamt=$obj_df->DoubleDonationAmount();
// print_r($tamt);

// $amount = (float)$tamt['total_amount'];

// if ($amount < 120000) {
//     $amount = 120000;
// }

// $amountInLakh = number_format($amount / 100000, 1) . ' lakh';
$goal = 2500000; // 25 lakh

$amount = (float)$tamt['total_amount'] + 120000;

$progress = min(($amount / $goal) * 100, 100);

$amountInLakh = number_format($amount / 100000, 1) . ' lakh';
$remaining = max($goal - $amount, 0);
$remainingInLakh = number_format($remaining / 100000, 1) . ' lakh';

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Double Your Donation for India's Tigers | WWF-India</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;0,800;1,400&display=swap"
        rel="stylesheet" />

    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="css/slick.min.css" />
    <link rel="stylesheet" href="css/index.css" />
        <script src="js/jquery.min.js"></script>

     <?php include 'includes/head.php'; ?>
</head>

<body>
    
    
    <?php include 'includes/header.php'; ?>

    <!-- ============ STICKY BANNER (White Progress Design) ============ -->
    <div class="progress-strip sticky-banner" id="stickyBanner">
        <div class="progress-strip__inner">
            <div class="progress-strip__label">
                Double Your Donation for India's Tigers
            </div>
            <div class="progress-strip__bar_wrapper">
                <div class="progress-strip__bar">
                    <div class="progress-labels">
                        <div><strong>INR <?php echo $amountInLakh; ?></strong><span>Raised</span></div>
<div><strong>INR <?php echo $remainingInLakh; ?></strong><span>To go</span></div>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: <?php echo $progress; ?>%;"></div>
                    </div>
                    
                </div>
                <button class="btn btn-dark" data-open-donate>Donate Now</button>
            </div>
        </div>
    </div>

    <!-- ============ HERO ============ -->
    <section class="hero" id="top">
        <div class="hero__inner">
            <div class="hero-inner-v1">
                <div class="hero__copy">
                    <h1>Double Your Donation <br />for India's Tigers</h1>
                    <p>
                        Every donation made during this campaign will be matched until the
                        matching fund is exhausted, doubling your impact for tiger
                        conservation.
                        <span class="info-trigger" data-open-tooltip aria-label="How the match works">?</span>
                    </p>
                </div>
                <div class="progress-card">
                    <div class="progress-track">
                        <div class="progress-fill" style="width: <?php echo $progress; ?>%;"></div>
                    </div>
                    <div class="progress-labels">
                        <div><strong>INR <?php echo $amountInLakh; ?></strong><span>Raised</span></div>
<div><strong>INR <?php echo $remainingInLakh; ?></strong><span>To go</span></div>
                    </div>
                    <div class="progress-btn-wrapper">
                        <button class="btn btn-dark" data-open-donate>Donate Now</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile-Only Hero Text block -->
    <div class="mobile-hero-text">
        <p>
            Every donation made during this campaign will be matched until the
            matching fund is exhausted, doubling your impact for tiger
            conservation.
            <span class="info-trigger" data-open-tooltip aria-label="How the match works">?</span>
        </p>
    </div>

    <!-- ============ STATIC PROGRESS STRIP (Hidden on Desktop, Visible on Mobile) ============ -->
    <section class="progress-strip mobile-only-strip">
        <div class="progress-strip__inner">
            <div class="progress-strip__label">
                Double Your Donation for India's Tigers
            </div>
            <div class="progress-strip__bar_wrapper">
                <div class="progress-strip__bar">
                    <div class="progress-track">
                        <div class="progress-fill" style="width: <?php echo $progress; ?>%;"></div>
                    </div>
                    <div class="progress-labels">
                      <div><strong>INR <?php echo $amountInLakh; ?></strong><span>Raised</span></div>
<div><strong>INR <?php echo $remainingInLakh; ?></strong><span>To go</span></div>
                    </div>
                </div>
                <button class="btn btn-dark" data-open-donate>Donate Now</button>
            </div>
        </div>
    </section>

    <!-- ============ WHY PROTECT / CAROUSEL ============ -->
    <section class="why-section">
        <div class="section-head">
            <h2>Why Protect India's Tigers?</h2>
            <p>
                When you protect a tiger, you're protecting far more than a single
                species. When India's tigers thrive, our forests thrive. When forests
                thrive, people thrive. Your donation helps protect all three.
            </p>
        </div>

        <div class="carousel">
            <div class="carousel__viewport" id="whyCarousel">

                <div class="carousel__slide">
                    <div class="slide-media">
                        <img class="media-photo"
                            src="images/Tiger-in-the-wild.webp"
                            alt="Tiger in the wild" width="480" height="260" />
                    </div>
                    <div class="slide-body">
                        <h3>70% of the world's wild tigers live in India.</h3>
                        <p>India is home to nearly 70% of the world's wild tiger population, making it the most
                            important country for the future of the species.</p>
                    </div>
                </div>

                <div class="carousel__slide">
                    <div class="slide-media">
                        <img class="media-photo"
                            src="images/National-Emblem.webp"
                            loading="eager"
                            alt="Tiger as India's national emblem" width="480" height="260" />
                    </div>
                    <div class="slide-body">
                        <h3>More than a symbol. Part of our identity.</h3>
                        <p>The tiger is India's national animal and has inspired our culture, history and heritage for
                            generations. Protecting it means preserving a part of who we are.</p>
                    </div>
                </div>

                <div class="carousel__slide">
                    <div class="slide-media">
                        <img class="media-photo"
                            src="images/Healthy-Forest.webp"
                            loading="eager"
                            alt="Healthy forest ecosystem" width="480" height="260" />
                    </div>
                    <div class="slide-body">
                        <h3>A healthy tiger population means a healthy forest.</h3>
                        <p>As a keystone species, tigers help maintain balanced ecosystems. Their presence indicates
                            forests that support biodiversity, protect water sources and store carbon.</p>
                    </div>
                </div>

                <div class="carousel__slide">
                    <div class="slide-media">
                        <img class="media-photo"
                            src="images/Community-Protection.webp"
                            loading="eager"
                            alt="Community protecting tiger habitat" width="480" height="260"
                            />
                    </div>
                    <div class="slide-body">
                        <h3>Protecting tigers protects us all.</h3>
                        <p>When you support tiger conservation, you're helping conserve forests that benefit wildlife,
                            communities and future generations.</p>
                        <a href="#donate" class="slide-link" data-open-donate>Your gift can help secure that future.</a>
                    </div>
                </div>

            </div>

            <div class="carousel__controls">
                <button class="carousel__arrow" id="carouselPrev" aria-label="Previous slide">
                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 64 64">
                        <path
                            d="M60 30H8.83l8.58-8.59a2 2 0 0 0-2.82-2.82l-12 12a2.06 2.06 0 0 0-.59 1.8 2.16 2.16 0 0 0 .55 1l12 12a2 2 0 1 0 2.82-2.82L8.83 34H60a2 2 0 0 0 0-4z"
                            fill="#000000"></path>
                    </svg>
                </button>
                <div class="carousel__dots" id="carouselDots"></div>
                <button class="carousel__arrow" id="carouselNext" aria-label="Next slide">
                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                        <path
                            d="m506.134 241.843-.018-.019-104.504-104c-7.829-7.791-20.492-7.762-28.285.068-7.792 7.829-7.762 20.492.067 28.284L443.558 236H20c-11.046 0-20 8.954-20 20s8.954 20 20 20h423.557l-70.162 69.824c-7.829 7.792-7.859 20.455-.067 28.284 7.793 7.831 20.457 7.858 28.285.068l104.504-104 .018-.019c7.833-7.818 7.808-20.522-.001-28.314z"
                            fill="#000000"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- ============ MAKE ROOM / ACCORDION ============ -->
    <section class="room-section">
        <div class="section-head">
            <h2>Let's Make Room For The Tiger</h2>
            <p class="room-sec-p">
                India has helped bring its tigers back. Now we must ensure they have a future.
            </p>
        </div>

        <div class="accordion" id="accordion">
            <div class="accordion-item">
                <button class="accordion-trigger">Keep Tigers Connected <span class="plus"></span></button>
                <div class="accordion-panel">
                    <div class="accordion-panel__inner">
                        <div class="slide-media">
                            <img class="media-photo"
                                src="images/Forest-Corridor.webp"
                                alt="Forest corridor" width="360" height="220" loading="eager" />
                        </div>
                        <div class="panel-text">
                            <p>Fragmented forests leave tiger populations isolated, making it harder for them to move,
                                find mates and thrive.</p>
                            <p><strong>Your support helps WWF-India protect and reconnect the corridors they need to
                                    survive.</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-trigger">Help People and Tigers Co-exist <span class="plus"></span></button>
                <div class="accordion-panel">
                    <div class="accordion-panel__inner">
                        <div class="slide-media">
                            <img class="media-photo"
                                src="images/Village-Co-existence.webp"
                                alt="Village community" width="360" height="220" loading="eager"/>
                        </div>
                        <div class="panel-text">
                            <p>As tigers return to shared landscapes, so do the challenges of living alongside them.</p>
                            <p><strong>Your support helps WWF-India work with communities through 'Bagh Mitras' to
                                    monitor tiger movement, prevent conflict and support families affected by livestock
                                    loss — helping people and tigers co-exist.</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-trigger">Stop Wildlife Crime Before It Happens <span
                        class="plus"></span></button>
                <div class="accordion-panel">
                    <div class="accordion-panel__inner">
                        <div class="slide-media">
                            <img class="media-photo"
                                src="images/Anti-poaching-patrol.webp"
                                alt="Anti-poaching patrol" width="360" height="220" loading="eager" />
                        </div>
                        <div class="panel-text">
                            <p>Every tiger deserves to roam free — not become a victim of wildlife crime. Despite legal
                                protection, poaching and the illegal wildlife trade continue to threaten India's tigers.
                            </p>
                            <p><strong>Your donation helps WWF-India work with enforcement agencies and frontline staff
                                    to combat wildlife crime and keep tigers safe.</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-trigger">Follow The Tiger's Journey <span class="plus"></span></button>
                <div class="accordion-panel">
                    <div class="accordion-panel__inner">
                        <div class="slide-media">
                            <img class="media-photo"
                                src="images/Camera-Trap-Monitoring.webp"
                                alt="Camera trap monitoring" width="360" height="220" loading="eager" />
                        </div>
                        <div class="panel-text">
                            <p>Protecting tigers begins with understanding how they move and behave. Using camera traps
                                and scientific monitoring, WWF-India studies tiger movement to guide conservation where
                                it's needed most.</p>
                            <p><strong>Your donation supports science that protects India's tigers.</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ IMPACT STATEMENT ============ -->
    <section class="impact-section">
        <div class="impact-section__inner">
            <h2>Know that your donation is making a difference</h2>
            <p>Your support strengthens WWF-India's decades of on-the-ground conservation work to protect India's
                wildlife and natural heritage.</p>
            <p>We'll keep you connected through stories from the field, conservation updates and impact reports that
                show how your support is helping secure a future for India's tigers.</p>
            <p>With WWF-India, you're an important part of the solution. Secure a future for India's tigers with a
                tax-deductible donation today.</p>
            <div class="impact-btn-wrapper">
                <button class="btn btn-dark" data-open-donate>Donate Now</button>
            </div>
        </div>
    </section>

    <!-- ============ TOGETHER FOR TIGERS (SLICK DRIVEN) ============ -->
    <section class="together-section">
        <!-- New Wrapper for Heading + Controls -->
        <div class="together-header">
            <h2>Together For Tigers</h2>
            <button class="together-next" id="togetherNext" aria-label="Next story">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <div class="together-wrap">
            <!-- Left Side Grid Buttons -->
            <div class="person-grid" id="personGrid">
                <button class="person-thumb is-active" data-person="0">
                    <div class="slide-media"><img class="media-photo"
                            src="images/Harvinder-Singh-Kalsi-Partner-in-Conservation.webp"
                            alt="Harvinder Singh Kalsi" width="100" height="84" loading="eager" /></div>
                    <span class="person-label">Harvinder Singh Kalsi</span>
                </button>
                <button class="person-thumb" data-person="1">
                    <div class="slide-media"><img class="media-photo"
                            src="images/Velamati-Bagh-Mitra.webp" alt="Bagh Mitra"
                            width="100" height="84" /></div>
                    <span class="person-label">Velamati</span>
                </button>
                <button class="person-thumb" data-person="2">
                    <div class="slide-media"><img class="media-photo"
                            src="images/Ashish-Gaur-Forest-Ranger.webp"
                            alt="Forest Guard" width="100" height="84" loading="eager" /></div>
                    <span class="person-label">Ashish Gaur</span>
                </button>
                <button class="person-thumb" data-person="3">
                    <div class="slide-media"><img class="media-photo"
                            src="images/Rohit-Ravi-Field-Biologist.webp"
                            alt="Field Biologist" width="100" height="84" loading="eager" /></div>
                    <span class="person-label">Rohit Ravi</span>
                </button>
            </div>

            <!-- Right Side Testimonial Slick Slider -->
            <div style="position: relative; min-width: 0;">
                <div id="testimonialSlider">

                    <!-- Slide 0 -->
                    <div class="testimonial-card">
                        <div class="testimonial-copy">
                            <p class="testimonial-name">Harvinder Singh Kalsi</p>
                            <p class="testimonial-role">Partner in Conservation</p>
                            <p class="testimonial-desc">Conservation is only possible because people choose to stand for
                                nature. Every donation helps protect India's wildlife for generations to come.</p>
                            <div class="slide-media mobile-slide-media">
                                <img class="media-photo"
                                    src="images/hsk1.webp"
                                    alt="Sudhir Kothari" width="170" height="180" loading="eager" />
                            </div>
                            <p class="testimonial-quote">"Supporting WWF-India has been one of the most fulfilling
                                decisions I have made. Knowing that my contribution helps protect India's iconic species
                                and habitats gives me immense pride. I appreciate the commitment of the team in keeping
                                us well informed and updated."</p>
                            <p class="testimonial-attrib">— Harvinder Singh Kalsi</p>
                        </div>
                        <div class="slide-media">
                            <img class="media-photo"
                                src="images/hsk1.webp"
                                alt="Sudhir Kothari" width="170" height="180" loading="eager" />
                        </div>
                    </div>

                    <!-- Slide 1 -->
                    <div class="testimonial-card">
                        <div class="testimonial-copy">
                            <p class="testimonial-name">Velamati</p>
                            <p class="testimonial-role">Bagh Mitra</p>
                            <p class="testimonial-desc">Bagh Mitras are trained community volunteers who help monitor
                                tiger movement, alert authorities and reduce conflict between people and wildlife.</p>
                            <div class="slide-media mobile-slide-media">
                                <img class="media-photo"
                                    src="images/v1.webp"
                                    alt="Bagh Mitra volunteer" width="170" height="180" loading="eager" />
                            </div>
                            <p class="testimonial-quote">"When people feel informed and supported, fear gives way to
                                coexistence. Protecting tigers begins with working alongside the communities that share
                                their home."</p>
                            <p class="testimonial-attrib">— Velamati</p>
                        </div>
                        <div class="slide-media">
                            <img class="media-photo"
                                src="images/v1.webp"
                                alt="Bagh Mitra volunteer" width="170" height="180" loading="eager" />
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="testimonial-card">
                        <div class="testimonial-copy">
                            <p class="testimonial-name">Ashish Gaur</p>
                            <p class="testimonial-role">Forest Guard</p>
                            <p class="testimonial-desc">Forest staff work tirelessly to patrol protected areas, monitor
                                wildlife and respond to threats, often under difficult and demanding conditions.</p>
                            <div class="slide-media mobile-slide-media">
                                <img class="media-photo"
                                    src="images/ag1.webp"
                                    alt="Forest Guard" width="170" height="180" loading="eager" />
                            </div>
                            <p class="testimonial-quote">"Protecting tigers isn't just about safeguarding one species.
                                It's about protecting the forests that sustain countless lives — including our own."</p>
                            <p class="testimonial-attrib">— Ashish Gaur</p>
                        </div>
                        <div class="slide-media">
                            <img class="media-photo"
                                 src="images/ag1.webp"
                                alt="Forest Guard" width="170" height="180" loading="eager" />
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="testimonial-card">
                        <div class="testimonial-copy">
                            <p class="testimonial-name">Rohit Ravi</p>
                            <p class="testimonial-role">Field Biologist</p>
                            <p class="testimonial-desc">WWF-India's field biologists study tiger behaviour, monitor
                                populations and generate the scientific evidence needed to protect critical habitats and
                                corridors.</p>
                            <div class="slide-media mobile-slide-media">
                                <img class="media-photo"
                                    src="images/rr1.webp"
                                    alt="Field Biologist" width="170" height="180" loading="eager" />
                            </div>
                            <p class="testimonial-quote">"Every camera trap image tells us something new. The more we
                                understand how tigers move and behave, the better we can protect the landscapes they
                                depend on."</p>
                            <p class="testimonial-attrib">— Rohit Ravi</p>
                        </div>
                        <div class="slide-media">
                            <img class="media-photo"
                                src="images/rr1.webp"
                                alt="Field Biologist" width="170" height="180" loading="eager" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CLOSING CTA ============ -->
    <section class="closing-cta">
        <div class="closing-cta__inner">
            <p>
                The future of India's tigers won't be decided someday. It's being
                decided today. Be part of the generation that ensures they continue to
                roam our forests for years to come.
            </p>
            <button class="btn btn-dark" data-open-donate>Donate Now</button>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <!-- ============ MODALS ============ -->
    <div class="modal-overlay tooltip-modal" id="tooltipModal">
        <div class="modal-box">
            <button class="modal-close" data-close-tooltip aria-label="Close">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>
            <h4>How the matching fund works</h4>
            <p>A dedicated <strong>WWF-India matching fund</strong> has been set aside for this campaign. Every eligible
                donation will be matched, <strong>up to ₹25,00,000</strong>, until the available matching funds are
                fully allocated.</p>
        </div>
    </div>

    <div class="modal-overlay donate-modal" id="donateModal">
        <div class="modal-box">

            <!-- PROGRESS BAR -->
            <div class="modal-progress-track">
                <div class="modal-progress-fill" id="modalProgressFill"></div>
            </div>

            <button class="modal-close" data-close-donate aria-label="Close">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>

            <form action="" method="post" name="tiger_match_form" id="donateForm" autocomplete="off" novalidate>

                <!-- STEP 1 -->
                <div class="donate-step" data-step="1">
                    <div class="donate-modal__head">
                        <span class="step-tag">Step 1 of 3</span>
                        <h3 class="donate-modal__title">Choose an amount</h3>
                        <p class="donate-modal__sub">Every rupee you give will be matched — doubling your impact for
                            India's tigers.</p>
                    </div>
                    <div class="donate-modal__body">
                        <div class="amount-grid" id="amountGrid">
                            <input type="radio" class="amount-radio visually-hidden" id="amount25000" name="amount"
                                value="25000">
                            <label class="amount-btn" for="amount25000">₹ 25,000</label>

                            <input type="radio" class="amount-radio visually-hidden" id="amount10000" name="amount"
                                value="10000">
                            <label class="amount-btn" for="amount10000">₹ 10,000</label>

                            <input type="radio" class="amount-radio visually-hidden" id="amount5000" name="amount"
                                value="5000">
                            <label class="amount-btn" for="amount5000">₹ 5,000</label>

                            <input type="radio" class="amount-radio visually-hidden" id="amount2500" name="amount"
                                value="2500">
                            <label class="amount-btn" for="amount2500">₹ 2,500</label>

                            <input type="radio" class="amount-radio visually-hidden" id="amountOther" name="amount"
                                value="other">
                            <label class="amount-btn amount-other" for="amountOther" style="text-align: center;">₹
                                Other</label>
                        </div>
                        <div class="other-amount-wrap" id="otherAmountWrap">
                            <div class="field">
                                <label for="otherAmount">Enter your amount (₹)</label>
                                <input type="number" id="otherAmount" name="otheramount" min="1000"
                                    placeholder="e.g. 7500" />
                            </div>
                        </div>
                        <p class="dynamic-note" id="dynamicNote">Select an amount to see your matched impact.</p>
                        <button type="button" class="btn btn-dark btn-block" id="step1Next" disabled>Donate Now</button>
                        <p class="fine-note">Only Indian nationals aged 18 years or above can donate on this platform.
                        </p>
                    </div>
                </div>

                <!-- STEP 2 -->
                <div class="donate-step" data-step="2" hidden>
                    <div class="donate-modal__head">
                        <span class="step-tag">Step 2 of 3</span>
                        <h3 class="donate-modal__title">Your details</h3>
                        <p class="donate-modal__sub">Donating to WWF-India</p>
                    </div>
                    <div class="donate-modal__body">
                        <div class="field">
                            <label for="fullName">Full Name*</label><input type="text" id="fullName" name="name"
                                required />
                        </div>
                        <div class="field-row">
                            <div class="field">
                                <label for="email">Email*</label><input type="email" id="email" name="email" required />
                            </div>
                            <div class="field">
                                <label for="phone">Phone Number*</label><input type="tel" id="phone" name="phone"
                                    maxlength="10" required />
                            </div>
                        </div>
                        <!--<div class="field">-->
                        <!--    <label for="dob">Date of Birth*</label><input type="date" id="dob" name="date_of_birth" />-->
                        <!--</div>-->
                        <div class="field">
                            <label for="address">Address*</label><input type="text" id="address" name="address"
                                required />
                        </div>
                        <div class="field-row">
                            <div class="field">
                                <label for="pin">Pin Code*</label><input type="text" id="pin" name="pin_code"
                                    maxlength="6" required />
                            </div>
                            <div class="field">
                                <label for="city">City*</label><input type="text" id="city" name="city" required />
                            </div>
                        </div>
                        <div class="field-row">
                            <div class="field">
                                <label for="state">State / UT</label>
                                <select id="state" name="state" required>
                                    <option value="">Select State / UT</option>
                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                    <option value="Assam">Assam</option>
                                    <option value="Bihar">Bihar</option>
                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                    <option value="Goa">Goa</option>
                                    <option value="Gujarat">Gujarat</option>
                                    <option value="Haryana">Haryana</option>
                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                    <option value="Jharkhand">Jharkhand</option>
                                    <option value="Karnataka">Karnataka</option>
                                    <option value="Kerala">Kerala</option>
                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Manipur">Manipur</option>
                                    <option value="Meghalaya">Meghalaya</option>
                                    <option value="Mizoram">Mizoram</option>
                                    <option value="Nagaland">Nagaland</option>
                                    <option value="Odisha">Odisha</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Rajasthan">Rajasthan</option>
                                    <option value="Sikkim">Sikkim</option>
                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                    <option value="Telangana">Telangana</option>
                                    <option value="Tripura">Tripura</option>
                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                    <option value="Uttarakhand">Uttarakhand</option>
                                    <option value="West Bengal">West Bengal</option>
                                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                    <option value="Chandigarh">Chandigarh</option>
                                    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and
                                        Daman and Diu</option>
                                    <option value="Delhi">Delhi</option>
                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                    <option value="Ladakh">Ladakh</option>
                                    <option value="Lakshadweep">Lakshadweep</option>
                                    <option value="Puducherry">Puducherry</option>
                                </select>
                            </div>
                            <div class="field">
                                <label for="nationality">Nationality*</label>
                                <select id="nationality" name="nationality" required>
                                    <option value="">Select Nationality</option>
                                    <option>Indian</option>
                                </select>
                            </div>
                        </div>

                        <div class="field">
                            <!--<label for="identificationType">Identification Type*</label>-->
                            <!--<select id="identificationType" name="identification_type" required>-->
                            <!--    <option value="">Select ID Type</option>-->
                            <!--    <option value="aadhaar">Aadhaar</option>-->
                            <!--    <option value="pan">PAN</option>-->
                            <!--    <option value="passport">Passport</option>-->
                            <!--</select>-->
                            <input type="hidden" name="identification_type" value="pan">
                        </div>

                        <!--<div class="field id-field" id="aadhaarInput" hidden>-->
                        <!--    <label for="aadhaar">Aadhaar Number*</label>-->
                        <!--    <input type="text" id="aadhaar" name="aadhaar" maxlength="12"-->
                        <!--        placeholder="12-digit Aadhaar number" autocomplete="off" />-->
                        <!--</div>-->

                        <!-- UNHIDDEN PAN INPUT -->
                        <div class="field id-field" id="panInput">
                            <label for="pan">PAN Card Number*</label>
                            <input type="text" id="pan" name="pan" maxlength="10" placeholder="ABCDE1234F"
                                autocomplete="off" />
                        </div>

                        <!--<div class="field id-field" id="passportInput" hidden>-->
                        <!--    <label for="passport">Passport Number*</label>-->
                        <!--    <input type="text" id="passport" name="passport" maxlength="8" placeholder="A1234567"-->
                        <!--        autocomplete="off" />-->
                        <!--</div>-->

                        <p class="helper-note">PAN is required to claim 80G tax exemption. Donations of ₹5,000 and above
                            require PAN to proceed.</p>

                        <div style="display: none;">
                            <div class="d-flex" style="gap: 10px;">
                                <input type="checkbox" name="terms" class="form-check-input"
                                    style="border: 1px solid rgb(0, 0, 0); width: 20px; height: 20px;" value="Yes"
                                    checked>
                                <label class="form-check-label" style="font-size: 0.8rem;">I agree to send my
                                    information to WWF-India. As per the Indian Income Tax Department’s rules, a donor
                                    is required to add their full name, address and PAN Card number in case they wish to
                                    claim tax exemption</label>
                            </div>
                            <div class="d-flex" style="gap: 10px;">
                                <input type="checkbox" name="willing_to_contact" class="form-check-input"
                                    style="border: 1px solid rgb(0, 0, 0); width: 20px; height: 20px;" value="Yes"
                                    checked>
                                <label class="form-check-label" style="font-size: 0.8rem;">I am willing to be contacted
                                    via phone, email, and messages for programme updates and repeat contributions by
                                    WWF-India.</label>
                            </div>
                        </div>

                        <div class="modal-nav">
                            <button type="button" class="back-circle" id="step2Back" aria-label="Back">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round">
                                    <path d="M15 5l-7 7 7 7" />
                                </svg>
                            </button>
                            <button type="button" class="btn btn-dark btn-block" id="step2Next">Proceed</button>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: PAYMENT -->
                <div class="donate-step" data-step="3" hidden>
                    <div class="donate-modal__head">
                        <span class="step-tag">Step 3 of 3</span>
                        <h3 class="donate-modal__title">Payment</h3>
                        <p class="donate-modal__sub">Review your gift before you pay</p>
                    </div>
                    <div class="donate-modal__body">
                        <div class="summary-box">
                            <div class="summary-row"><span>Your donation</span><span id="summaryAmount">₹0</span></div>
                            <div class="summary-row" style="display: none;"><span>Matched by WWF-India</span><span
                                    id="summaryMatch">₹0</span></div>
                            <div class="summary-row total" style="display: none;"><span>Total impact</span><span
                                    id="summaryTotal">₹0</span></div>
                        </div>

                        <div class="review-box">
                            <div class="summary-row"><span>Name</span><span id="reviewName"></span></div>
                            <div class="summary-row"><span>Email</span><span id="reviewEmail"></span></div>
                            <div class="summary-row"><span>Phone</span><span id="reviewPhone"></span></div>
                            <!--<div class="summary-row"><span>Date of Birth</span><span id="reviewDob"></span></div>-->
                            <div class="summary-row"><span>Address</span><span id="reviewAddress"></span></div>
                            <div class="summary-row"><span>City</span><span id="reviewCity"></span></div>
                            <div class="summary-row"><span>State</span><span id="reviewState"></span></div>
                            <div class="summary-row"><span>PIN</span><span id="reviewPin"></span></div>
                            <div class="summary-row"><span>Nationality</span><span id="reviewNationality"></span></div>
                            <div class="summary-row"><span>ID Type</span><span id="reviewIdType"></span></div>
                            <div class="summary-row"><span>ID Number</span><span id="reviewIdValue"></span></div>
                            <div class="summary-row total"><span>Donation</span><span id="reviewAmount"></span></div>
                            <div class="summary-row" style="display: none;"><span>Matched Amount</span><span
                                    id="reviewMatch"></span></div>
                            <div class="summary-row total" style="display: none;"><span>Total Impact</span><span
                                    id="reviewTotal"></span></div>
                        </div>

                        <input type="hidden" name="purpose" value="Double Your Donation for India Tigers">
                        <input type="hidden" id="campaign" name="campaign" value="WWF-DYD">
                        <input type="hidden" id="sourcename" name="sourcename"
                            value="<?php if (isset($_GET['source'])) { echo htmlspecialchars($_GET['source']); } else { echo 'WWF-DYD'; } ?>">

                        <p class="submit-error" id="submitError" hidden></p>

                        <div class="modal-nav">
                            <button type="button" class="back-circle" id="step3Back" aria-label="Back">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round">
                                    <path d="M15 5l-7 7 7 7" />
                                </svg>
                            </button>
                            <button type="submit" class="btn btn-dark btn-block" id="step3Pay">Complete
                                Donation</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- STEP 4: SUCCESS -->
            <div class="donate-step" data-step="4" hidden>
                <div class="donate-modal__body success-state" style="padding-top: 30px">
                    <div class="tick">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#1B1B16" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h4>Thank you for doubling your impact</h4>
                    <p>Your gift, together with the WWF-India match, is helping protect India's tigers and the forests
                        they call home.</p>
                    <button type="button" class="btn btn-outline btn-block" id="closeSuccess">Done</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/slick.min.js"></script>
    <script src="js/index.js"></script>
</body>

</html>