(function () {
  /* ---------------- Sticky banner on scroll ---------------- */
  var heroEl = document.querySelector(".hero");
  var banner = document.getElementById("stickyBanner");
  function onScroll() {
    var trigger = heroEl.offsetTop + heroEl.offsetHeight - 80;
    if (window.scrollY > trigger) {
      banner.classList.add("is-visible");
    } else {
      banner.classList.remove("is-visible");
    }
  }
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();

  /* ---------------- Tooltip modal ---------------- */
  var tooltipModal = document.getElementById("tooltipModal");
  document.querySelectorAll("[data-open-tooltip]").forEach(function (btn) {
    btn.addEventListener("click", function () {
      tooltipModal.classList.add("is-open");
    });
  });
  document.querySelectorAll("[data-close-tooltip]").forEach(function (btn) {
    btn.addEventListener("click", function () {
      tooltipModal.classList.remove("is-open");
    });
  });
  tooltipModal.addEventListener("click", function (e) {
    if (e.target === tooltipModal) tooltipModal.classList.remove("is-open");
  });

  var DONATE_API_ENDPOINT = "/api/donate";

  var donateModal = document.getElementById("donateModal");
  var donateForm = document.getElementById("donateForm");
  var steps = donateModal.querySelectorAll(".donate-step");
  var selectedAmount = null;
//   var AMOUNT_MIN = 1000;
  var AMOUNT_MIN = 1000;

  function showStep(n) {
    steps.forEach(function (s) {
      s.hidden = s.getAttribute("data-step") != String(n);
    });

    // Update Progress Bar
    var progressFill = document.getElementById("modalProgressFill");
    if (progressFill) {
      // Assuming 3 main steps (Step 4 is success, maxes out at 100%)
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

  // LOGIC COMMENTED OUT FOR PRESERVATION
  /*
  var isValidAadhaar = function (a) {
    return /^\d{12}$/.test(a);
  };
  var isValidPassport = function (pass) {
    return /^[A-Z]{1}[0-9]{7}$/.test(pass);
  };
  var isAdult = function (dobString) {
    var dob = new Date(dobString);
    var today = new Date();
    var age = today.getFullYear() - dob.getFullYear();
    var monthDiff = today.getMonth() - dob.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
      age--;
    }
    return age >= 18;
  };
  */

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

  // Clear errors on input
  [
    "fullName",
    // "dob",
    "email",
    "phone",
    "address",
    "pin",
    "city",
    "state",
    "nationality",
    "pan",
  ].forEach(function (id) {
    var el = document.getElementById(id);
    if (el) {
      el.addEventListener("input", function () {
        clearFieldError(el);
      });
    }
  });

  /* ---------------- DOB / age-18+ (COMMENTED OUT) ---------------- */
  /*
  var dobInput = document.getElementById("dob");
  if(dobInput) {
      dobInput.setAttribute("max", new Date().toISOString().split("T")[0]);
  }
  */

  /* ---------------- Digit-restriction + case formatting ---------------- */
  var restrictToNumbers = function (event) {
    event.target.value = event.target.value.replace(/\D/g, "");
  };
  var forceUppercase = function (event) {
    event.target.value = event.target.value.toUpperCase();
  };

  ["phone", "pin" /* "aadhaar" */].forEach(function (id) {
    var el = document.getElementById(id);
    if (el) el.addEventListener("input", restrictToNumbers);
  });

  ["pan" /* "passport" */].forEach(function (id) {
    var el = document.getElementById(id);
    if (el) el.addEventListener("input", forceUppercase);
  });

  /* ---------------- Identification type toggle (COMMENTED OUT) ---------------- */
  /*
  var identificationType = document.getElementById("identificationType");
  var idWraps = {
    aadhaar: document.getElementById("aadhaarInput"),
    pan: document.getElementById("panInput"),
    passport: document.getElementById("passportInput"),
  };
  var idValidators = {
    aadhaar: isValidAadhaar,
    pan: isValidPAN,
    passport: isValidPassport,
  };
  if(identificationType) {
      identificationType.addEventListener("change", function () {
        Object.keys(idWraps).forEach(function (key) {
          if (idWraps[key]) idWraps[key].hidden = true;
        });
        clearFieldError(identificationType);
        var selected = identificationType.value;
        if (selected && idWraps[selected]) {
          idWraps[selected].hidden = false;
          clearFieldError(document.getElementById(selected));
        }
      });
  }
  */

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
  pinInput.addEventListener("change", function (e) {
    fetchStateAndCity(e.target.value.trim());
  });

  /* Step 1: amount selection */
  var amountGrid = document.getElementById("amountGrid");
  var amountRadios = amountGrid.querySelectorAll('input[name="amount"]');
  var otherWrap = document.getElementById("otherAmountWrap");
  var otherInput = document.getElementById("otherAmount");
  var dynamicNote = document.getElementById("dynamicNote");
  var step1Next = document.getElementById("step1Next");

  function fmtINR(n) {
    return "₹" + Number(n).toLocaleString("en-IN");
  }
  function updateSelection(amount) {
    selectedAmount = amount;
    if (amount && amount >= AMOUNT_MIN) {
      dynamicNote.innerHTML =
        "Your <strong>" +
        fmtINR(amount) +
        "</strong> donation will unlock an additional <strong>" +
        fmtINR(amount) +
        "</strong> for India's tigers.";
      step1Next.disabled = false;
    } else if (amount && amount < AMOUNT_MIN) {
      dynamicNote.innerHTML =
        "Minimum donation amount is <strong>" +
        fmtINR(AMOUNT_MIN) +
        "</strong>.";
      step1Next.disabled = true;
    } else {
      dynamicNote.textContent = "Select an amount to see your matched impact.";
      step1Next.disabled = true;
    }
  }
  function validateOtherAmount() {
    clearFieldError(otherInput);
    var val = parseInt(otherInput.value, 10);
    if (otherInput.value && (isNaN(val) || val < AMOUNT_MIN)) {
      showFieldError(
        otherInput,
        "Amount must be at least " + fmtINR(AMOUNT_MIN),
      );
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

  /* Step 2 nav */
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

    /* --- DOB Validation (COMMENTED OUT) ---
    if (dobInput && dobInput.value && !isAdult(dobInput.value)) {
      showFieldError(dobInput, "You must be at least 18 years old");
      valid = false;
    }
    */

    var address = document.getElementById("address");
    if (!address.value.trim()) {
      showFieldError(address, "Address is required");
      valid = false;
    } else if (!isValidAddress(address.value.trim())) {
      showFieldError(
        address,
        "Enter a valid address without special characters",
      );
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

    /* --- Toggle Validation (COMMENTED OUT) ---
    if (!identificationType.value) {
      showFieldError(identificationType, "Please select an identification type");
      valid = false;
    } else {
      var idInput = document.getElementById(identificationType.value);
      var idLabel = identificationType.options[identificationType.selectedIndex].text;
      var idVal = idInput.value.trim();
      if (!idVal) {
        showFieldError(idInput, idLabel + " number is required");
        valid = false;
      } else if (!idValidators[identificationType.value](idVal)) {
        showFieldError(idInput, "Enter a valid " + idLabel + " number");
        valid = false;
      }
    }
    */

    // Direct PAN Validation
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

    document.getElementById("summaryAmount").textContent = fmtINR(
      selectedAmount || 0,
    );
    document.getElementById("summaryMatch").textContent = fmtINR(match);
    document.getElementById("summaryTotal").textContent = fmtINR(
      (selectedAmount || 0) + match,
    );

    document.getElementById("reviewName").textContent =
      document.getElementById("fullName").value;
    document.getElementById("reviewEmail").textContent =
      document.getElementById("email").value;
    document.getElementById("reviewPhone").textContent =
      document.getElementById("phone").value;
    document.getElementById("reviewAddress").textContent =
      document.getElementById("address").value;
    document.getElementById("reviewCity").textContent =
      document.getElementById("city").value;
    document.getElementById("reviewState").textContent =
      document.getElementById("state").value;
    document.getElementById("reviewPin").textContent =
      document.getElementById("pin").value;
    document.getElementById("reviewNationality").textContent =
      document.getElementById("nationality").value;

    // Explicitly set PAN for review
    document.getElementById("reviewIdType").textContent = "PAN Card";
    document.getElementById("reviewIdValue").textContent = document
      .getElementById("pan")
      .value.toUpperCase();

    /* --- Dynamic Review Values (COMMENTED OUT) ---
    // document.getElementById("reviewDob").textContent = document.getElementById("dob").value || "-";
    // document.getElementById("reviewIdType").textContent = identificationType.options[identificationType.selectedIndex].text;
    // document.getElementById("reviewIdValue").textContent = document.getElementById(identificationType.value).value;
    */

    document.getElementById("reviewAmount").textContent = fmtINR(
      selectedAmount || 0,
    );
    document.getElementById("reviewMatch").textContent = fmtINR(match);
    document.getElementById("reviewTotal").textContent = fmtINR(
      (selectedAmount || 0) + match,
    );

    showStep(3);
  });

  /* Step 3 nav */
  document.getElementById("step3Back").addEventListener("click", function () {
    showStep(2);
  });

  /* ---------------- Single submit: all form data in one API call ---------------- */
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

    payload.amount =
      payload.amount === "other" ? payload.otheramount : payload.amount;
    payload.matched_amount = selectedAmount || 0;
    payload.total_impact = (selectedAmount || 0) * 2;

    setSubmitting(true);

    $.ajax({
      type: "POST",
      url: "./onetime.php",
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

  document
    .getElementById("closeSuccess")
    .addEventListener("click", function () {
      closeDonate();
      setTimeout(function () {
        selectedAmount = null;
        donateForm.reset();
        otherWrap.classList.remove("is-visible");
        updateSelection(0);
        clearAllFieldErrors();
        submitError.hidden = true;
        submitError.textContent = "";

        /* --- Hidden Resets (COMMENTED OUT) ---
      // Object.keys(idWraps).forEach(function (key) {
      //   if(idWraps[key]) idWraps[key].hidden = true;
      // });
      */
        showStep(1);
      }, 300);
    });

  /* ---------------- Slick Sliders Initialization ---------------- */
  $(document).ready(function () {
    $("#whyCarousel").slick({
      prevArrow: "#carouselPrev",
      nextArrow: "#carouselNext",
      appendDots: "#carouselDots",
      dots: true,
      customPaging: function (slider, i) {
        return (
          '<button class="carousel__dot" aria-label="Go to slide ' +
          (i + 1) +
          '"></button>'
        );
      },
      autoplay: true,
      autoplaySpeed: 6000,
      pauseOnHover: true,
      swipe: true,
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
    });

    $("#testimonialSlider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      nextArrow: "#togetherNext",
      prevArrow: false,
      fade: true,
      swipe: true,
    });

    $(".person-thumb").on("click", function () {
      var index = $(this).data("person");
      $("#testimonialSlider").slick("slickGoTo", index);
    });

    $("#testimonialSlider").on(
      "beforeChange",
      function (event, slick, currentSlide, nextSlide) {
        $(".person-thumb").removeClass("is-active");
        $('.person-thumb[data-person="' + nextSlide + '"]').addClass(
          "is-active",
        );
      },
    );
  });

  /* Accordion logic */
  document.querySelectorAll(".accordion-item").forEach(function (item) {
    var trigger = item.querySelector(".accordion-trigger");
    var panel = item.querySelector(".accordion-panel");
    trigger.addEventListener("click", function () {
      var isOpen = item.classList.contains("is-open");
      document.querySelectorAll(".accordion-item").forEach(function (other) {
        other.classList.remove("is-open");
        other.querySelector(".accordion-panel").style.maxHeight = null;
      });
      if (!isOpen) {
        item.classList.add("is-open");
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    });
  });

  window.addEventListener("resize", function () {
    var openItem = document.querySelector(".accordion-item.is-open");
    if (openItem) {
      var panel = openItem.querySelector(".accordion-panel");
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
})();
