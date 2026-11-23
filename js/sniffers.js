(function () {
  /* ==================================================================
     CONFIG
     ------------------------------------------------------------------
     Submit flow matches the original campaign page exactly:
     POST ./onetime.php → "Yes" → redirect to the WWF-India
     double-your-donation process page.
  ================================================================== */
  var DONATE_API_ENDPOINT = "./onetime.php";

  var donateModal = document.getElementById("donateModal");
  var donateForm = document.getElementById("donateForm");
  var steps = donateModal.querySelectorAll(".donate-step");
  var selectedAmount = null;
  var AMOUNT_MIN = 1000;

  function showStep(n) {
    steps.forEach(function (s) {
      s.hidden = s.getAttribute("data-step") != String(n);
    });
    var progressFill = document.getElementById("modalProgressFill");
    if (progressFill) {
      var percentage = n >= 3 ? 100 : (n / 3) * 100;
      progressFill.style.width = percentage + "%";
    }
  }

  function openDonate() {
    donateModal.classList.add("is-open");
    document.body.style.overflow = "hidden";
    showStep(1);
  }

  function closeDonate() {
    donateModal.classList.remove("is-open");
    document.body.style.overflow = "";
  }

  document.querySelectorAll("[data-open-donate]").forEach(function (btn) {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      openDonate();
    });
  });

  document.querySelectorAll("[data-close-donate]").forEach(function (btn) {
    btn.addEventListener("click", closeDonate);
  });

  donateModal.addEventListener("click", function (e) {
    if (e.target === donateModal) closeDonate();
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && donateModal.classList.contains("is-open")) {
      closeDonate();
    }
  });

  /* ---------------- Validators ---------------- */
  var isValidEmail = function (email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  };
  var isValidPhone = function (phone) {
    return /^[6-9]\d{9}$/.test(phone);
  };
  var isValidPIN = function (pin) {
    return /^\d{6}$/.test(pin);
  };
  var isValidPAN = function (pan) {
    return /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(pan);
  };
  var isValidName = function (name) {
    return /^[a-zA-Z\u00C0-\u024F\u1E00-\u1EFF\s.'-]{2,}$/.test(name);
  };
  var isValidAddress = function (address) {
    var addressRegex = /^[a-zA-Z0-9\s.,#\-()/&'":;]+$/;
    var codePatterns = [
      /<script>/i,
      /javascript:/i,
      /onload=/i,
      /onerror=/i,
      /onclick=/i,
      /eval\(/i,
      /alert\(/i,
      /document\./i,
      /window\./i,
    ];
    if (!addressRegex.test(address)) return false;
    for (var i = 0; i < codePatterns.length; i++) {
      if (codePatterns[i].test(address)) return false;
    }
    return true;
  };

  /* ---------------- Inline field-error helpers ---------------- */
  function showFieldError(input, message) {
    clearFieldError(input);
    input.classList.add("is-invalid");
    var err = document.createElement("div");
    err.className = "field-error";
    err.textContent = message;
    input.insertAdjacentElement("afterend", err);
  }
  function clearFieldError(input) {
    input.classList.remove("is-invalid");
    var next = input.nextElementSibling;
    if (next && next.classList.contains("field-error")) next.remove();
  }
  function clearAllFieldErrors() {
    donateModal.querySelectorAll(".is-invalid").forEach(function (el) {
      el.classList.remove("is-invalid");
    });
    donateModal.querySelectorAll(".field-error").forEach(function (el) {
      el.remove();
    });
  }

  ["fullName", "email", "phone", "address", "pin", "city", "state", "nationality", "pan"].forEach(
    function (id) {
      var el = document.getElementById(id);
      if (el) {
        el.addEventListener("input", function () {
          clearFieldError(el);
        });
      }
    },
  );

  /* ---------------- Digit-restriction + case formatting ---------------- */
  var restrictToNumbers = function (event) {
    event.target.value = event.target.value.replace(/\D/g, "");
  };
  var forceUppercase = function (event) {
    event.target.value = event.target.value.toUpperCase();
  };

  ["phone", "pin"].forEach(function (id) {
    var el = document.getElementById(id);
    if (el) el.addEventListener("input", restrictToNumbers);
  });

  ["pan"].forEach(function (id) {
    var el = document.getElementById(id);
    if (el) el.addEventListener("input", forceUppercase);
  });

  /* ---------------- PIN code -> city/state autofill ---------------- */
  var pinInput = document.getElementById("pin");
  var cityInput = document.getElementById("city");
  var stateInput = document.getElementById("state");

  async function fetchStateAndCity(pin) {
    if (!isValidPIN(pin)) return;
    try {
      var response = await fetch("https://api.postalpincode.in/pincode/" + pin);
      var data = await response.json();
      if (data && data[0] && data[0].Status === "Success") {
        var postOffice = data[0].PostOffice[0];
        cityInput.value = postOffice.District || "";
        stateInput.value = postOffice.State || "";
        clearFieldError(cityInput);
        clearFieldError(stateInput);
      }
    } catch (error) {
      console.error("Error fetching PIN code details:", error);
    }
  }
  if (pinInput) {
    pinInput.addEventListener("change", function (e) {
      fetchStateAndCity(e.target.value.trim());
    });
  }

  /* ---------------- Formatting ---------------- */
  function fmtINR(n) {
    return "₹" + Number(n).toLocaleString("en-IN");
  }

  /* ---------------- Modal step 1: amount selection ---------------- */
  var amountGrid = document.getElementById("amountGrid");
  var amountRadios = amountGrid.querySelectorAll('input[name="amount"]');
  var otherWrap = document.getElementById("otherAmountWrap");
  var otherInput = document.getElementById("otherAmount");
  var dynamicNote = document.getElementById("dynamicNote");
  var step1Next = document.getElementById("step1Next");

  function updateSelection(amount) {
    selectedAmount = amount;
    if (amount && amount >= AMOUNT_MIN) {
      dynamicNote.innerHTML =
        "Your <strong>" +
        fmtINR(amount) +
        "</strong> donation will unlock an additional <strong>" +
        fmtINR(amount) +
        "</strong> for India's Super Sniffers.";
      step1Next.disabled = false;
    } else if (amount && amount < AMOUNT_MIN) {
      dynamicNote.innerHTML =
        "Minimum donation amount is <strong>" + fmtINR(AMOUNT_MIN) + "</strong>.";
      step1Next.disabled = true;
    } else {
      dynamicNote.textContent = "Select an amount to see your matched impact.";
      step1Next.disabled = true;
    }
  }

  function selectModalAmount(value) {
    amountRadios.forEach(function (radio) {
      radio.checked = radio.value === String(value);
      if (radio.checked) {
        if (radio.value === "other") {
          otherWrap.classList.add("is-visible");
        } else {
          otherWrap.classList.remove("is-visible");
          otherInput.value = "";
        }
      }
    });
    if (value === "other") {
      updateSelection(parseInt(otherInput.value, 10) || 0);
    } else {
      updateSelection(parseInt(value, 10) || 0);
    }
  }

  function validateOtherAmount() {
    clearFieldError(otherInput);
    var val = parseInt(otherInput.value, 10);
    if (otherInput.value && (isNaN(val) || val < AMOUNT_MIN)) {
      showFieldError(otherInput, "Amount must be at least " + fmtINR(AMOUNT_MIN));
      return false;
    }
    return true;
  }

  amountRadios.forEach(function (radio) {
    radio.addEventListener("change", function () {
      if (radio.value === "other") {
        otherWrap.classList.add("is-visible");
        otherInput.focus();
        clearFieldError(otherInput);
        updateSelection(parseInt(otherInput.value) || 0);
      } else {
        otherWrap.classList.remove("is-visible");
        clearFieldError(otherInput);
        otherInput.value = "";
        updateSelection(parseInt(radio.value));
      }
    });
  });
  otherInput.addEventListener("input", function () {
    updateSelection(parseInt(otherInput.value) || 0);
    validateOtherAmount();
  });

  step1Next.addEventListener("click", function () {
    if (!validateOtherAmount()) return;
    showStep(2);
  });

  /* ---------------- Hero inline amount picker ---------------- */
  var heroGrid = document.getElementById("heroAmountGrid");
  var heroRadios = heroGrid.querySelectorAll('input[name="heroamount"]');
  var heroOtherWrap = document.getElementById("heroOtherWrap");
  var heroOtherInput = document.getElementById("heroOtherAmount");
  var heroNote = document.getElementById("heroDynamicNote");
  var heroAmount = 25000;

  function updateHeroNote() {
    if (heroAmount && heroAmount >= AMOUNT_MIN) {
      heroNote.innerHTML =
        "Your <strong>" +
        fmtINR(heroAmount) +
        "</strong> donation will unlock an additional <strong>" +
        fmtINR(heroAmount) +
        "</strong> for India's Super Sniffers.";
    } else if (heroAmount) {
      heroNote.innerHTML =
        "Minimum donation amount is <strong>" + fmtINR(AMOUNT_MIN) + "</strong>.";
    } else {
      heroNote.textContent = "Select an amount to see your matched impact.";
    }
  }

  heroRadios.forEach(function (radio) {
    radio.addEventListener("change", function () {
      if (radio.value === "other") {
        heroOtherWrap.classList.add("is-visible");
        heroOtherInput.focus();
        heroAmount = parseInt(heroOtherInput.value, 10) || 0;
      } else {
        heroOtherWrap.classList.remove("is-visible");
        heroOtherInput.value = "";
        heroAmount = parseInt(radio.value, 10);
      }
      updateHeroNote();
    });
  });
  if (heroOtherInput) {
    heroOtherInput.addEventListener("input", function () {
      heroAmount = parseInt(heroOtherInput.value, 10) || 0;
      updateHeroNote();
    });
  }

  /* When the donate modal opens, carry the hero selection across */
  document.querySelectorAll("[data-open-donate]").forEach(function (btn) {
    btn.addEventListener("click", function () {
      if (heroAmount && heroAmount >= AMOUNT_MIN) {
        selectModalAmount(heroAmount);
      } else {
        updateSelection(0);
      }
    });
  });

  /* ---------------- Step 2 nav + validation ---------------- */
  document.getElementById("step2Back").addEventListener("click", function () {
    showStep(1);
  });

  function validateStep2() {
    clearAllFieldErrors();
    var valid = true;

    var name = document.getElementById("fullName");
    if (!name.value.trim()) {
      showFieldError(name, "Full name is required");
      valid = false;
    } else if (!isValidName(name.value.trim())) {
      showFieldError(name, "Enter a valid name without special characters");
      valid = false;
    }

    var email = document.getElementById("email");
    if (!email.value.trim()) {
      showFieldError(email, "Email is required");
      valid = false;
    } else if (!isValidEmail(email.value.trim())) {
      showFieldError(email, "Enter a valid email address");
      valid = false;
    }

    var phone = document.getElementById("phone");
    if (!phone.value.trim()) {
      showFieldError(phone, "Phone number is required");
      valid = false;
    } else if (!isValidPhone(phone.value.trim())) {
      showFieldError(phone, "Enter a valid 10-digit phone number");
      valid = false;
    }

    var address = document.getElementById("address");
    if (!address.value.trim()) {
      showFieldError(address, "Address is required");
      valid = false;
    } else if (!isValidAddress(address.value.trim())) {
      showFieldError(address, "Enter a valid address without special characters");
      valid = false;
    }

    if (!pinInput.value.trim()) {
      showFieldError(pinInput, "Pin code is required");
      valid = false;
    } else if (!isValidPIN(pinInput.value.trim())) {
      showFieldError(pinInput, "Enter a valid 6-digit PIN code");
      valid = false;
    }

    if (!cityInput.value.trim()) {
      showFieldError(cityInput, "City is required");
      valid = false;
    }

    if (!stateInput.value.trim()) {
      showFieldError(stateInput, "State/UT is required");
      valid = false;
    }

    var nationality = document.getElementById("nationality");
    if (!nationality.value) {
      showFieldError(nationality, "Please select a nationality");
      valid = false;
    }

    var panInput = document.getElementById("pan");
    if (!panInput.value.trim()) {
      showFieldError(panInput, "PAN Card number is required");
      valid = false;
    } else if (!isValidPAN(panInput.value.trim())) {
      showFieldError(panInput, "Enter a valid PAN Card number");
      valid = false;
    }

    return valid;
  }

  document.getElementById("step2Next").addEventListener("click", function () {
    if (!validateStep2()) return;

    var match = selectedAmount || 0;

    document.getElementById("summaryAmount").textContent = fmtINR(selectedAmount || 0);
    document.getElementById("summaryMatch").textContent = fmtINR(match);
    document.getElementById("summaryTotal").textContent = fmtINR((selectedAmount || 0) + match);

    document.getElementById("reviewName").textContent = document.getElementById("fullName").value;
    document.getElementById("reviewEmail").textContent = document.getElementById("email").value;
    document.getElementById("reviewPhone").textContent = document.getElementById("phone").value;
    document.getElementById("reviewAddress").textContent = document.getElementById("address").value;
    document.getElementById("reviewCity").textContent = document.getElementById("city").value;
    document.getElementById("reviewState").textContent = document.getElementById("state").value;
    document.getElementById("reviewPin").textContent = document.getElementById("pin").value;
    document.getElementById("reviewNationality").textContent =
      document.getElementById("nationality").value;
    document.getElementById("reviewIdType").textContent = "PAN Card";
    document.getElementById("reviewIdValue").textContent = document
      .getElementById("pan")
      .value.toUpperCase();

    document.getElementById("reviewAmount").textContent = fmtINR(selectedAmount || 0);
    document.getElementById("reviewMatch").textContent = fmtINR(match);
    document.getElementById("reviewTotal").textContent = fmtINR((selectedAmount || 0) + match);

    showStep(3);
  });

  document.getElementById("step3Back").addEventListener("click", function () {
    showStep(2);
  });

  /* ---------------- Submit ---------------- */
  var step3Pay = document.getElementById("step3Pay");
  var submitError = document.getElementById("submitError");

  function setSubmitting(isSubmitting) {
    step3Pay.disabled = isSubmitting;
    step3Pay.textContent = isSubmitting ? "Processing..." : "Complete Donation";
  }

  donateForm.addEventListener("submit", function (e) {
    e.preventDefault();

    var step3 = donateModal.querySelector('.donate-step[data-step="3"]');
    if (step3.hidden) return;

    submitError.hidden = true;
    submitError.textContent = "";

    var formData = new FormData(donateForm);
    var payload = {};
    formData.forEach(function (value, key) {
      payload[key] = value;
    });

    payload.amount = payload.amount === "other" ? payload.otheramount : payload.amount;
    payload.matched_amount = selectedAmount || 0;
    payload.total_impact = (selectedAmount || 0) * 2;

    setSubmitting(true);

    $.ajax({
      type: "POST",
      url: DONATE_API_ENDPOINT,
      data: payload,
      cache: false,
      success: function (result) {
        console.log(result);
        setSubmitting(false);

        if (String(result).trim() === "Yes") {
          window.location.href =
            "https://donate.wwfindia.org/double-your-donation/process.php?title=doubledonation";
        } else {
          submitError.hidden = false;
          submitError.textContent =
            result || "Something went wrong while processing your donation.";
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText || error);
        setSubmitting(false);

        submitError.hidden = false;
        submitError.textContent =
          "Something went wrong while processing your donation. Please try again.";
      },
    });
  });

  document.getElementById("closeSuccess").addEventListener("click", function () {
    closeDonate();
    setTimeout(function () {
      selectedAmount = null;
      donateForm.reset();
      otherWrap.classList.remove("is-visible");
      updateSelection(0);
      clearAllFieldErrors();
      submitError.hidden = true;
      submitError.textContent = "";
      showStep(1);
    }, 300);
  });

  /* ==================================================================
     Accordions — "Super Sniffers and Beyond" (single open, like repo)
  ================================================================== */
  document.querySelectorAll("#beyondAccordion .accordion-item").forEach(function (item) {
    var trigger = item.querySelector(".accordion-trigger");
    var panel = item.querySelector(".accordion-panel");
    trigger.addEventListener("click", function () {
      var isOpen = item.classList.contains("is-open");
      document.querySelectorAll("#beyondAccordion .accordion-item").forEach(function (other) {
        other.classList.remove("is-open");
        other.querySelector(".accordion-panel").style.maxHeight = null;
      });
      if (!isOpen) {
        item.classList.add("is-open");
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    });
  });

  /* ==================================================================
     FAQ accordion — all open by default (as per design)
  ================================================================== */
  var faqItems = document.querySelectorAll(".faq-item");

  function setFaqPanel(item, open) {
    var panel = item.querySelector(".faq-panel");
    if (open) {
      item.classList.add("is-open");
      panel.style.maxHeight = panel.scrollHeight + "px";
    } else {
      item.classList.remove("is-open");
      panel.style.maxHeight = null;
    }
  }

  faqItems.forEach(function (item) {
    var trigger = item.querySelector(".faq-trigger");
    trigger.addEventListener("click", function () {
      setFaqPanel(item, !item.classList.contains("is-open"));
    });
    /* open by default */
    setFaqPanel(item, true);
  });

  window.addEventListener("resize", function () {
    var openBeyond = document.querySelector("#beyondAccordion .accordion-item.is-open");
    if (openBeyond) {
      var bp = openBeyond.querySelector(".accordion-panel");
      bp.style.maxHeight = bp.scrollHeight + "px";
    }
    document.querySelectorAll(".faq-item.is-open").forEach(function (item) {
      var panel = item.querySelector(".faq-panel");
      panel.style.maxHeight = panel.scrollHeight + "px";
    });
  });

  /* Re-measure open panels after web fonts finish loading so
     max-height never leaves clipped text or trailing white space. */
  if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(function () {
      document
        .querySelectorAll(".faq-item.is-open .faq-panel, #beyondAccordion .accordion-item.is-open .accordion-panel")
        .forEach(function (panel) {
          panel.style.maxHeight = panel.scrollHeight + "px";
        });
      onScroll();
    });
  }

  /* ==================================================================
     Sticky bottom strip — appears once the hero (+ in-flow strip)
     has scrolled past, same behaviour as the old repo banner.
  ================================================================== */
  var heroEl = document.querySelector(".sniffer-hero");
  var inFlowStrip = document.getElementById("campaignStrip");
  var stickyStrip = document.getElementById("stickyStrip");

  function onScroll() {
    if (!heroEl || !stickyStrip) return;
    var trigger;
    if (inFlowStrip) {
      /* show once the in-flow strip has fully passed the top —
         avoids the fixed copy overlapping the original */
      trigger = inFlowStrip.offsetTop + inFlowStrip.offsetHeight;
    } else {
      trigger = heroEl.offsetTop + heroEl.offsetHeight - 80;
    }
    if (window.scrollY > trigger) {
      stickyStrip.classList.add("is-visible");
      stickyStrip.setAttribute("aria-hidden", "false");
    } else {
      stickyStrip.classList.remove("is-visible");
      stickyStrip.setAttribute("aria-hidden", "true");
    }
  }
  window.addEventListener("scroll", onScroll, { passive: true });
  window.addEventListener("resize", onScroll);
  onScroll();

  /* ==================================================================
     Collective impact — rotating image + caption pairs
     (reuses images already in the project — no new assets)
  ================================================================== */
  var collectiveMedia = document.getElementById("collectiveMedia");
  var captionEl = document.getElementById("collectiveCaption");
  var collectiveImg = document.getElementById("collectiveImg");
  var impactSlides = [
    {
      img: "images/impact-squad.jpg",
      caption:
        "From just 2 dogs in 2008 to a nationwide network of 120+ active working units.",
    },
    {
      img: "images/transit-dog.jpg",
      caption:
        "Deployed across critical tiger reserves, national parks, railway lines and transit hubs.",
    },
    {
      img: "images/equipment-dog.jpg",
      caption:
        "Assisting forest departments and law enforcement in detecting hidden contraband, securing evidence and clearing hidden hazards from forest trails.",
    },
  ];
  /* preload so the crossfade never shows a blank frame */
  impactSlides.forEach(function (slide) {
    var pre = new Image();
    pre.src = slide.img;
  });

  var captionIndex = 0;
  if (collectiveMedia && captionEl && collectiveImg) {
    setInterval(function () {
      collectiveMedia.classList.add("is-fading");
      setTimeout(function () {
        captionIndex = (captionIndex + 1) % impactSlides.length;
        collectiveImg.src = impactSlides[captionIndex].img;
        captionEl.textContent = impactSlides[captionIndex].caption;
        collectiveMedia.classList.remove("is-fading");
      }, 400);
    }, 5000);
  }

  /* ==================================================================
     Slick sliders
  ================================================================== */
  $(document).ready(function () {
    function makeSlider(el, prev, next, dots, autoplay) {
      if (!$(el).length) return;
      $(el).slick({
        prevArrow: prev,
        nextArrow: next,
        appendDots: dots,
        dots: true,
        customPaging: function (slider, i) {
          return (
            '<button class="carousel__dot" aria-label="Go to slide ' + (i + 1) + '"></button>'
          );
        },
        autoplay: !!autoplay,
        autoplaySpeed: 6000,
        pauseOnHover: true,
        swipe: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
      });
    }

    makeSlider("#makesCarousel", "#makesPrev", "#makesNext", "#makesDots", true);
    makeSlider("#beyondCarousel", "#beyondPrev", "#beyondNext", "#beyondDots", false);

    if ($("#breedSlider").length) {
      $("#breedSlider").slick({
        prevArrow: "#breedPrev",
        nextArrow: "#breedNext",
        appendDots: "#breedDots",
        dots: true,
        customPaging: function (slider, i) {
          return (
            '<button class="carousel__dot" aria-label="Go to breed ' + (i + 1) + '"></button>'
          );
        },
        fade: true,
        swipe: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 400,
      });
    }
  });
})();
