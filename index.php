<?php
ob_start();

/* ------------------------------------------------------------------
   Campaign progress (stub)
   Replace with the real DigitalFueled / backend integration when ready
   (the original repo used include/class.digitalfueled.php).
------------------------------------------------------------------ */
$goal   = 2500000;   // ₹25,00,000 matching fund
$amount = 1720000;   // ₹17,20,000 raised

$progress   = min(($amount / $goal) * 100, 100);
$remaining  = max($goal - $amount, 0);

/* Indian digit grouping: 1720000 => 17,20,000 */
function inr_format($n) {
    $n = (string)(int)$n;
    if (strlen($n) > 3) {
        $last3 = substr($n, -3);
        $rest  = substr($n, 0, -3);
        $rest  = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
        return $rest . ',' . $last3;
    }
    return $n;
}
$raisedText   = '₹' . inr_format($amount);
$remainingText = '₹' . inr_format($remaining);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Double Your Donation for India's Super Sniffers | WWF-India</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;0,800;1,400&display=swap"
        rel="stylesheet" />

    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="css/slick.min.css" />
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="css/sniffers.css" />
    <script src="js/jquery.min.js"></script>

    <?php include 'includes/head.php'; ?>
</head>

<body id="top">

    <?php include 'includes/header.php'; ?>

    <!-- ============ HERO ============ -->
    <section class="sniffer-hero">
        <div class="sniffer-hero__inner">
            <div class="sniffer-hero__copy">
                <h1>Not all superheroes wear capes</h1>
                <p class="sniffer-hero__sub">
                    Some have four paws<br />
                    and a nose for justice
                </p>
            </div>

            <!-- Inline donation card -->
            <div class="donate-card" id="heroDonateCard">
                <h3>Choose an amount</h3>
                <p class="donate-card__sub">
                    Every rupee you give will be matched — doubling your impact for
                    India's Super Sniffers.
                </p>

                <div class="amount-grid" id="heroAmountGrid">
                    <input type="radio" class="amount-radio visually-hidden" id="heroAmount25000"
                        name="heroamount" value="25000" checked>
                    <label class="amount-btn" for="heroAmount25000">₹ 25,000</label>

                    <input type="radio" class="amount-radio visually-hidden" id="heroAmount10000"
                        name="heroamount" value="10000">
                    <label class="amount-btn" for="heroAmount10000">₹ 10,000</label>

                    <input type="radio" class="amount-radio visually-hidden" id="heroAmount5000"
                        name="heroamount" value="5000">
                    <label class="amount-btn" for="heroAmount5000">₹ 5,000</label>

                    <input type="radio" class="amount-radio visually-hidden" id="heroAmount2500"
                        name="heroamount" value="2500">
                    <label class="amount-btn" for="heroAmount2500">₹ 2,500</label>

                    <input type="radio" class="amount-radio visually-hidden" id="heroAmountOther"
                        name="heroamount" value="other">
                    <label class="amount-btn amount-other" for="heroAmountOther"
                        style="text-align: center;">₹ Other</label>
                </div>

                <div class="other-amount-wrap" id="heroOtherWrap">
                    <div class="field">
                        <label for="heroOtherAmount">Enter your amount (₹)</label>
                        <input type="number" id="heroOtherAmount" min="1000" placeholder="e.g. 7500" />
                    </div>
                </div>

                <p class="donate-card__note" id="heroDynamicNote">
                    Your <strong>₹25,000</strong> donation will unlock an additional
                    <strong>₹25,000</strong> for India's Super Sniffers.
                </p>

                <button class="btn btn-dark btn-block" id="heroDonateBtn" data-open-donate>
                    Donate Now
                </button>

                <p class="donate-card__fine">
                    Only Indian nationals aged 18 years or above can donate on this
                    platform.
                </p>
            </div>
        </div>
    </section>

    <!-- ============ MATCHING STRIP + PROGRESS ============ -->
    <div class="match-strip">
        <span class="match-strip__text">
            Every donation made during this campaign will be matched until the matching fund is
            exhausted, doubling your impact for India's Super Sniffers.
        </span>
    </div>

    <section class="progress-strip" id="campaignStrip">
        <div class="progress-strip__inner">
            <div class="progress-strip__label">
                Double Your Donation for Super Sniffers
            </div>
            <div class="progress-strip__bar_wrapper">
                <div class="progress-strip__bar">
                    <div class="progress-labels">
                        <div><strong><?php echo $raisedText; ?></strong><span>Raised</span></div>
                        <div><strong><?php echo $remainingText; ?></strong><span>To go</span></div>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: <?php echo round($progress, 1); ?>%;"></div>
                    </div>
                </div>
                <button class="btn btn-dark" data-open-donate>Donate Now</button>
            </div>
        </div>
    </section>

    <!-- ============ STICKY BOTTOM STRIP (appears once the hero scrolls past) ============ -->
    <div class="sticky-strip" id="stickyStrip" aria-hidden="true">
        <div class="match-strip sticky-strip__match">
            <span class="match-strip__text">
                Every donation made during this campaign will be matched until the matching fund is
                exhausted, doubling your impact for India's Super Sniffers.
            </span>
        </div>
        <div class="progress-strip sticky-strip__progress">
            <div class="progress-strip__inner">
                <div class="progress-strip__label">
                    Double Your Donation for Super Sniffers
                </div>
                <div class="progress-strip__bar_wrapper">
                    <div class="progress-strip__bar">
                        <div class="progress-labels">
                            <div><strong><?php echo $raisedText; ?></strong><span>Raised</span></div>
                            <div><strong><?php echo $remainingText; ?></strong><span>To go</span></div>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill" style="width: <?php echo round($progress, 1); ?>%;"></div>
                        </div>
                    </div>
                    <button class="btn btn-dark" data-open-donate>Donate Now</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ POWERED BY PAWS (DARK) ============ -->
    <section class="paws-section">
        <div class="paws-section__inner">
            <h2>Powered by paws, driven by instinct</h2>
            <p>
                If you're a dog lover, you already know that dogs are capable of
                extraordinary things. But did you know that some of them are also working
                on the frontlines of wildlife protection?
            </p>
            <p>
                Meet India's Super Sniffers. With their extraordinary sense of smell, these
                specially trained dogs help detect hidden wildlife products and support
                efforts to protect vulnerable species.
            </p>
            <p>
                Working closely with their dedicated handlers, they bring together instinct,
                intelligence and training to do something truly remarkable.
            </p>
            <div class="paws-section__btn">
                <button class="btn btn-light" data-open-donate>Support a Canine Hero Today</button>
            </div>
        </div>
    </section>

    <!-- ============ WHAT MAKES A SUPER SNIFFER ============ -->
    <section class="why-section makes-section">
        <div class="section-head">
            <h2>What Makes a Super Sniffer</h2>
        </div>

        <div class="carousel">
            <div class="carousel__viewport" id="makesCarousel">

                <div class="carousel__slide">
                    <div class="slide-media">
                        <img class="media-photo" src="images/smell-nose.jpg" loading="eager"
                            alt="Close-up of a detection dog's nose" width="480" height="260" />
                    </div>
                    <div class="slide-body">
                        <h3>An extraordinary sense of smell</h3>
                        <p>
                            A dog's sense of smell is remarkably more sensitive than ours,
                            with around 300 million scent receptors compared to just 6
                            million in humans. Some estimates suggest their olfactory sense
                            is up to 10,000 times more precise than ours — detecting scents
                            that our human noses would never detect.
                        </p>
                    </div>
                </div>

                <div class="carousel__slide">
                    <div class="slide-media">
                        <img class="media-photo" src="images/field-run.jpg" loading="eager"
                            alt="Detection dog running in a forest clearing" width="480" height="260" />
                    </div>
                    <div class="slide-body">
                        <h3>Born for the field</h3>
                        <p>
                            Agile, alert and always ready for a challenge, detection dogs are
                            trained to work through different environments, from dense
                            forests to busy transit hubs.
                        </p>
                    </div>
                </div>

                <div class="carousel__slide">
                    <div class="slide-media">
                        <img class="media-photo" src="images/bond-handler.jpg" loading="eager"
                            alt="Handler bonding with his detection dog" width="480" height="260" />
                    </div>
                    <div class="slide-body">
                        <h3>An unbreakable bond</h3>
                        <p>
                            Behind every Super Sniffer is a dedicated handler, whose trust
                            and training help turn an extraordinary bond into a team that
                            takes action.
                        </p>
                    </div>
                </div>

            </div>

            <div class="carousel__controls">
                <button class="carousel__arrow" id="makesPrev" aria-label="Previous slide">
                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 64 64">
                        <path d="M60 30H8.83l8.58-8.59a2 2 0 0 0-2.82-2.82l-12 12a2.06 2.06 0 0 0-.59 1.8 2.16 2.16 0 0 0 .55 1l12 12a2 2 0 1 0 2.82-2.82L8.83 34H60a2 2 0 0 0 0-4z"
                            fill="#000000"></path>
                    </svg>
                </button>
                <div class="carousel__dots" id="makesDots"></div>
                <button class="carousel__arrow" id="makesNext" aria-label="Next slide">
                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                        <path d="m506.134 241.843-.018-.019-104.504-104c-7.829-7.791-20.492-7.762-28.285.068-7.792 7.829-7.762 20.492.067 28.284L443.558 236H20c-11.046 0-20 8.954-20 20s8.954 20 20 20h423.557l-70.162 69.824c-7.829 7.792-7.859 20.455-.067 28.284 7.793 7.831 20.457 7.858 28.285.068l104.504-104 .018-.019c7.833-7.818 7.808-20.522-.001-28.314z"
                            fill="#000000"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- ============ SUPER SNIFFERS AND BEYOND ============ -->
    <section class="beyond-section">
        <div class="section-head">
            <h2>Super Sniffers and Beyond</h2>
            <p class="beyond-sub">A team effort towards a greater mission.</p>
            <p class="beyond-intro">
                These extraordinary dogs may be at the heart of the mission, but they don't
                work alone. It takes dedicated people, the right resources and continuous
                support to help them make a difference.
            </p>
        </div>

        <!-- Accordion -->
        <div class="accordion" id="beyondAccordion">
            <div class="accordion-item">
                <button class="accordion-trigger">Put extraordinary noses to work <span class="plus"></span></button>
                <div class="accordion-panel">
                    <div class="accordion-panel__inner accordion-panel__inner--text">
                        <div class="panel-text">
                            <p>From airports and transit hubs to vulnerable wildlife corridors,
                                Super Sniffers use their remarkable sense of smell to detect
                                hidden wildlife crime that might otherwise go undetected.</p>
                            <p><strong>Your support helps WWF-India train, deploy and care for
                                    specialised canine-handler squads working to protect
                                    wildlife.</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-trigger">Strengthen the teams behind the sniffers <span class="plus"></span></button>
                <div class="accordion-panel">
                    <div class="accordion-panel__inner accordion-panel__inner--text">
                        <div class="panel-text">
                            <p>Every Super Sniffer works alongside a dedicated handler,
                                supported by people on the frontline. Their work depends on
                                the training, equipment and coordination.</p>
                            <p><strong>Your support helps WWF-India strengthen canine-handler
                                    teams and equip frontline personnel with the skills and
                                    resources they need.</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-trigger">Extend protection across species and habitats <span class="plus"></span></button>
                <div class="accordion-panel">
                    <div class="accordion-panel__inner accordion-panel__inner--text">
                        <div class="panel-text">
                            <p>The work of protecting wildlife goes beyond individual species
                                and forest boundaries. Super Sniffer teams contribute to our
                                wider efforts to safeguard vulnerable wildlife and nature
                                across terrestrial and marine habitats.</p>
                            <p><strong>Your donation supports efforts to protect vulnerable
                                    species and the ecosystems they depend on.</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-trigger">Make every detection count <span class="plus"></span></button>
                <div class="accordion-panel">
                    <div class="accordion-panel__inner accordion-panel__inner--text">
                        <div class="panel-text">
                            <p>Identifying potential threats is only the beginning.
                                Scientific research, field assessments and information-sharing
                                help teams understand emerging risks and guide effective
                                conservation action.</p>
                            <p><strong>Your donation supports the knowledge, research and
                                    coordination that help strengthen wildlife
                                    protection.</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slides carousel -->
        <div class="carousel beyond-carousel">
            <div class="carousel__viewport" id="beyondCarousel">

                <div class="carousel__slide">
                    <div class="slide-media">
                        <img class="media-photo" src="images/transit-dog.jpg" loading="eager"
                            alt="Sniffer dog inspecting parcels at a transit hub" width="480" height="260" />
                    </div>
                    <div class="beyond-card">
                        <p>
                            From airports and transit hubs to vulnerable wildlife corridors,
                            Super Sniffers use their remarkable sense of smell to detect
                            hidden wildlife crime that might otherwise go undetected.
                        </p>
                        <p><strong>
                            Your support helps WWF-India train, deploy and care for
                            specialised canine-handler squads working to protect wildlife.
                        </strong></p>
                    </div>
                </div>

                <div class="carousel__slide">
                    <div class="slide-media">
                        <img class="media-photo" src="images/training-dog.jpg" loading="eager"
                            alt="Handler training a detection dog" width="480" height="260" />
                    </div>
                    <div class="beyond-card">
                        <p>
                            Every Super Sniffer works alongside a dedicated handler,
                            supported by people on the frontline. Their work depends on the
                            training, equipment and coordination.
                        </p>
                        <p><strong>
                            Your support helps WWF-India strengthen canine-handler teams and
                            equip frontline personnel with the skills and resources they
                            need.
                        </strong></p>
                    </div>
                </div>

                <div class="carousel__slide">
                    <div class="slide-media">
                        <img class="media-photo" src="images/forest-team.jpg" loading="eager"
                            alt="Forest team on patrol with a detection dog" width="480" height="260" />
                    </div>
                    <div class="beyond-card">
                        <p>
                            The work of protecting wildlife goes beyond individual species
                            and forest boundaries. Super Sniffer teams contribute to our
                            wider efforts to safeguard vulnerable wildlife and nature across
                            terrestrial and marine habitats.
                        </p>
                        <p><strong>
                            Your donation supports efforts to protect vulnerable species and
                            the ecosystems they depend on.
                        </strong></p>
                    </div>
                </div>

                <div class="carousel__slide">
                    <div class="slide-media">
                        <img class="media-photo" src="images/equipment-dog.jpg" loading="eager"
                            alt="Handler and detection dog checking a crate" width="480" height="260" />
                    </div>
                    <div class="beyond-card">
                        <p>
                            Identifying potential threats is only the beginning. Scientific
                            research, field assessments and information-sharing help teams
                            understand emerging risks and guide effective conservation
                            action.
                        </p>
                        <p><strong>
                            Your donation supports the knowledge, research and coordination
                            that help strengthen wildlife protection.
                        </strong></p>
                    </div>
                </div>

            </div>

            <div class="carousel__controls">
                <button class="carousel__arrow" id="beyondPrev" aria-label="Previous slide">
                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 64 64">
                        <path d="M60 30H8.83l8.58-8.59a2 2 0 0 0-2.82-2.82l-12 12a2.06 2.06 0 0 0-.59 1.8 2.16 2.16 0 0 0 .55 1l12 12a2 2 0 1 0 2.82-2.82L8.83 34H60a2 2 0 0 0 0-4z"
                            fill="#000000"></path>
                    </svg>
                </button>
                <div class="carousel__dots" id="beyondDots"></div>
                <button class="carousel__arrow" id="beyondNext" aria-label="Next slide">
                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                        <path d="m506.134 241.843-.018-.019-104.504-104c-7.829-7.791-20.492-7.762-28.285.068-7.792 7.829-7.762 20.492.067 28.284L443.558 236H20c-11.046 0-20 8.954-20 20s8.954 20 20 20h423.557l-70.162 69.824c-7.829 7.792-7.859 20.455-.067 28.284 7.793 7.831 20.457 7.858 28.285.068l104.504-104 .018-.019c7.833-7.818 7.808-20.522-.001-28.314z"
                            fill="#000000"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- ============ MEET OUR SUPER SNIFFERS ============ -->
    <section class="breeds-section">
        <div class="section-head">
            <h2>Meet Our Super Sniffers</h2>
            <p>
                Over the years, different breeds have brought their own strengths and
                personalities to wildlife detection work. From the intelligence of German
                shepherds and the keen noses of labradors to the agility and drive of
                Belgian malinois, each has contributed something special to the Super
                Sniffer story.
            </p>
        </div>

        <div class="breed-slider-wrap">
            <div class="breed-slider" id="breedSlider">

                <!-- Belgian Malinois -->
                <div class="breed-card">
                    <div class="breed-card__top">
                        <div class="breed-card__media">
                            <img src="images/breed-malinois.jpg" alt="Belgian Malinois" width="280" height="210" />
                        </div>
                        <div class="breed-card__head">
                            <h3>Belgian Malinois - High Octane Athletes</h3>
                            <p><strong>The View:</strong> Imagine a dog with the energy of a
                                sports car and the focus of a laser beam. Always alert, always
                                ready for a challenge, the Belgian malinois is built for
                                action!</p>
                        </div>
                    </div>
                    <div class="breed-card__body">
                        <p class="breed-card__label">Canine Superpowers:</p>
                        <ul>
                            <li><strong>Born to Move:</strong> Lean, athletic and incredibly
                                agile, they can navigate challenging terrain with impressive
                                speed and ease.</li>
                            <li><strong>All About the Mission:</strong> Intelligent, energetic
                                and eager to work, they thrive on training, challenges and
                                putting their remarkable nose to good use.</li>
                        </ul>
                        <p class="breed-card__quirk"><strong>The Quirky Reality:</strong>
                            Belgian Malinois form incredibly close bonds with their handlers.
                            They're the kind of loyal companion who want to be wherever their
                            favourite human is — through forest trails, muddy riverbeds and
                            every adventure in between!</p>
                    </div>
                </div>

                <!-- German Shepherd -->
                <div class="breed-card">
                    <div class="breed-card__top">
                        <div class="breed-card__media">
                            <img src="images/breed-shepherd.jpg" alt="German Shepherd" width="280" height="210" />
                        </div>
                        <div class="breed-card__head">
                            <h3>German Shepherd - The Noble Guardian</h3>
                            <p><strong>The View:</strong> Larger and heavier-footed than the
                                malinois, German shepherds bring calm confidence, noble
                                strength and powerful awareness to every patrol.</p>
                        </div>
                    </div>
                    <div class="breed-card__body">
                        <p class="breed-card__label">Canine Superpowers:</p>
                        <ul>
                            <li><strong>Methodical genius:</strong> Quick to learn and
                                excellent at following complex commands, they bring focus and
                                discipline to every operation.</li>
                            <li><strong>Steady nerves:</strong> Their sturdy build and
                                endurance make them calm and reliable even in high-pressure
                                situations.</li>
                        </ul>
                        <p class="breed-card__quirk"><strong>The Quirky Reality:</strong>
                            Don't let their serious, dignified exterior fool you! German
                            shepherds can be affectionately soft with their favourite people,
                            always ready for a little praise or a playful moment.</p>
                    </div>
                </div>

                <!-- Labrador -->
                <div class="breed-card">
                    <div class="breed-card__top">
                        <div class="breed-card__media">
                            <img src="images/breed-labrador.jpg" alt="Labrador" width="280" height="210" />
                        </div>
                        <div class="breed-card__head">
                            <h3>Labrador - The Friendly Detective</h3>
                            <p><strong>The View:</strong> The cheerful, big-hearted optimist!
                                With their wagging tails, curious noses and famously friendly
                                expressions, labradors have a way of winning hearts wherever
                                they go.</p>
                        </div>
                    </div>
                    <div class="breed-card__body">
                        <p class="breed-card__label">Canine Superpowers:</p>
                        <ul>
                            <li><strong>A Nose for Discovery:</strong> Their remarkable sense
                                of smell and enthusiasm for scent-based games make them
                                excellent detection partners.</li>
                            <li><strong>Friendly Nature:</strong> Their approachable
                                temperament can make them particularly suited to working in
                                busy public spaces.</li>
                        </ul>
                        <p class="breed-card__quirk"><strong>The Quirky Reality:</strong>
                            Labradors are famously enthusiastic about treats, toys and belly
                            rubs. A little positive reinforcement goes a long way with these
                            happy, hardworking detectives!</p>
                    </div>
                </div>

            </div>

            <div class="carousel__controls">
                <button class="carousel__arrow" id="breedPrev" aria-label="Previous breed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 64 64">
                        <path d="M60 30H8.83l8.58-8.59a2 2 0 0 0-2.82-2.82l-12 12a2.06 2.06 0 0 0-.59 1.8 2.16 2.16 0 0 0 .55 1l12 12a2 2 0 1 0 2.82-2.82L8.83 34H60a2 2 0 0 0 0-4z"
                            fill="#000000"></path>
                    </svg>
                </button>
                <div class="carousel__dots" id="breedDots"></div>
                <button class="carousel__arrow" id="breedNext" aria-label="Next breed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                        <path d="m506.134 241.843-.018-.019-104.504-104c-7.829-7.791-20.492-7.762-28.285.068-7.792 7.829-7.762 20.492.067 28.284L443.558 236H20c-11.046 0-20 8.954-20 20s8.954 20 20 20h423.557l-70.162 69.824c-7.829 7.792-7.859 20.455-.067 28.284 7.793 7.831 20.457 7.858 28.285.068l104.504-104 .018-.019c7.833-7.818 7.808-20.522-.001-28.314z"
                            fill="#000000"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- ============ OUR COLLECTIVE IMPACT ============ -->
    <section class="collective-section">
        <div class="section-head">
            <h2>Our Collective Impact</h2>
        </div>

        <div class="collective-card">
            <div class="collective-stats">
                <div class="stat-pill stat-pill--cream">
                    <strong>120+</strong>
                    <span>Canine Squads Trained</span>
                </div>
                <div class="stat-pill stat-pill--cyan">
                    <strong>22</strong>
                    <span>State and UTs Covered</span>
                </div>
                <div class="stat-pill stat-pill--pink">
                    <strong>500+</strong>
                    <span>Wildlife Cases Handled</span>
                </div>
            </div>

            <div class="collective-media" id="collectiveMedia">
                <img id="collectiveImg" src="images/impact-squad.jpg" alt="Canine squad in the field" width="900" height="340" />
                <div class="collective-caption" id="collectiveCaption">
                    From just 2 dogs in 2008 to a nationwide network of 120+ active working
                    units.
                </div>
            </div>
        </div>
    </section>

    <!-- ============ KNOW YOUR DONATION (DARK) ============ -->
    <section class="impact-section">
        <div class="impact-section__inner">
            <h2>Know that your donation is making a difference</h2>
            <p>
                Your support strengthens WWF-India's efforts to protect India's wildlife,
                including the work of our remarkable Super Sniffer teams at the foundation
                of this campaign.
            </p>
            <p>
                We'll keep you connected through stories from the field, updates on the
                Super Sniffer programme and impact reports that show how your support is
                helping protect India's wildlife.
            </p>
            <p>
                With WWF-India, you're an important part of the solution. Help our Super
                Sniffers continue their extraordinary work with a tax-deductible donation
                today.
            </p>
            <div class="impact-btn-wrapper">
                <button class="btn btn-dark" data-open-donate>Donate Today</button>
            </div>
        </div>
    </section>

    <!-- ============ FAQ ============ -->
    <section class="faq-section">
        <div class="faq-wrap">
            <h2>Frequently Asked Questions</h2>

            <div class="faq-list" id="faqList">
                <div class="faq-item is-open">
                    <button class="faq-trigger">
                        Who trains the super sniffers and their handlers?
                        <span class="faq-chevron" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-panel">
                        <div class="faq-panel__inner">
                            Our programme works closely with government agencies and
                            recognised dog-training centres. Since forest departments
                            generally do not have specialised facilities for wildlife
                            detection dog training, WWF-India facilitates the training of
                            forest personnel as dog handlers and provides dogs to the
                            deploying agencies. The dogs and their handlers train together at
                            recognised government facilities, including centres run by the
                            Indo-Tibetan Border Police (ITBP), Border Security Force (BSF)
                            and Madhya Pradesh Police.
                        </div>
                    </div>
                </div>

                <div class="faq-item is-open">
                    <button class="faq-trigger">
                        Where do super sniffers come from?
                        <span class="faq-chevron" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-panel">
                        <div class="faq-panel__inner">
                            Our dogs come from certified breeders recommended by the
                            recognised training centres. Each dog is selected with its
                            suitability for specialised detection work in mind.
                        </div>
                    </div>
                </div>

                <div class="faq-item is-open">
                    <button class="faq-trigger">
                        Why are the dogs trained when they are so young?
                        <span class="faq-chevron" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-panel">
                        <div class="faq-panel__inner">
                            Starting training at a young age helps dogs develop their
                            scent-detection abilities, confidence and working skills over
                            time. It also gives them an opportunity to build a strong bond
                            with their handlers as they learn and grow together.
                        </div>
                    </div>
                </div>

                <div class="faq-item is-open">
                    <button class="faq-trigger">
                        Who looks after the dogs when they retire?
                        <span class="faq-chevron" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-panel">
                        <div class="faq-panel__inner">
                            A Super Sniffer may retire from duty, but the bond with their
                            handler lasts a lifetime. The deploying agency remains
                            responsible for their care, but in many cases, these loyal
                            companions spend their golden years with the very humans who
                            stood by their side through every mission.
                        </div>
                    </div>
                </div>

                <div class="faq-item is-open">
                    <button class="faq-trigger">
                        Are the dogs safe when working in forests?
                        <span class="faq-chevron" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-panel">
                        <div class="faq-panel__inner">
                            Absolutely! Super Sniffers are trained to adapt to forest
                            environments and know how to navigate these settings. Their
                            handlers are also specially trained to guide them and look after
                            their well-being in the field.
                        </div>
                    </div>
                </div>

                <div class="faq-item is-open">
                    <button class="faq-trigger">
                        Why don't you work with stray dogs?
                        <span class="faq-chevron" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-panel">
                        <div class="faq-panel__inner">
                            We recognise that dogs come in all shapes, sizes and abilities.
                            However, specialised detection work requires certain physical and
                            behavioural traits, along with a strong aptitude for scent-based
                            training. Our programme follows the selection and training
                            protocols recommended by recognised dog training centres to
                            identify dogs best suited to this work. The focus is always on
                            finding the right dog for the job.
                        </div>
                    </div>
                </div>

                <div class="faq-item is-open">
                    <button class="faq-trigger">
                        Is this India's only wildlife sniffer dog training programme?
                        <span class="faq-chevron" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-panel">
                        <div class="faq-panel__inner">
                            WWF-India, in partnership with TRAFFIC, pioneered India's
                            wildlife sniffer dog training programmes in 2008, starting with
                            just two canine squads. Since then, the programme has grown
                            significantly, training over 120 canine squads and extending
                            wildlife detection capabilities across multiple states and union
                            territories. Today, it is recognised as India's largest wildlife
                            sniffer dog training programme.
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
                Behind every extraordinary nose is a dedicated handler, years of training
                and a team working to protect India's wildlife. Your support can help these
                remarkable canine guardians continue doing what they do best.
            </p>
            <button class="btn btn-dark" data-open-donate>Donate Today</button>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <!-- ============ DONATE MODAL ============ -->
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
                        <p class="donate-modal__sub">Every rupee you give will be matched —
                            doubling your impact for India's Super Sniffers.</p>
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
                            <label class="amount-btn amount-other" for="amountOther"
                                style="text-align: center;">₹ Other</label>
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
                        <p class="fine-note">Only Indian nationals aged 18 years or above can donate on this
                            platform.</p>
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
                            <input type="hidden" name="identification_type" value="pan">
                        </div>

                        <div class="field id-field" id="panInput">
                            <label for="pan">PAN Card Number*</label>
                            <input type="text" id="pan" name="pan" maxlength="10" placeholder="ABCDE1234F"
                                autocomplete="off" />
                        </div>

                        <p class="helper-note">PAN is required to claim 80G tax exemption. Donations of ₹5,000 and
                            above require PAN to proceed.</p>

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

                        <input type="hidden" name="purpose" value="Double Your Donation for Super Sniffers">
                        <input type="hidden" id="campaign" name="campaign" value="WWF-SS">
                        <input type="hidden" id="sourcename" name="sourcename"
                            value="<?php if (isset($_GET['source'])) { echo htmlspecialchars($_GET['source']); } else { echo 'WWF-SS'; } ?>">

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
                    <p>Your gift, together with the WWF-India match, is helping protect India's
                        Super Sniffers and the wildlife they safeguard.</p>
                    <button type="button" class="btn btn-outline btn-block" id="closeSuccess">Done</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/slick.min.js"></script>
    <script src="js/sniffers.js"></script>
</body>

</html>
