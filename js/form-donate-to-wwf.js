const dobInputReg = document.getElementById("dobReg");
const dobInputOT = document.getElementById("dob");
const today = new Date().toISOString().split("T")[0];

dobInputReg.setAttribute("max", today);
dobInputOT.setAttribute("max", today);

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("one-time-form");
  const identificationType = form.querySelector("#identificationType");
  const aadhaarInput = form.querySelector("#aadhaarInput");
  const panInput = form.querySelector("#panInput");
  const passportInput = form.querySelector("#passportInput");
  const amountRadios = form.querySelectorAll('input[name="amount"]');
  const otherAmount = form.querySelector("#otherAmount");

  identificationType.addEventListener("change", () => {
    aadhaarInput.style.display = "none";
    panInput.style.display = "none";
    passportInput.style.display = "none";

    const selected = identificationType.value;
    if (selected === "aadhaar") aadhaarInput.style.display = "block";
    if (selected === "pan") panInput.style.display = "block";
    if (selected === "passport") passportInput.style.display = "block";
  });

  amountRadios.forEach((radio) => {
    radio.addEventListener("change", () => {
      if (radio.checked) {
        otherAmount.value = "";
        clearAmountError();
      }
    });
  });

  otherAmount.addEventListener("input", () => {
    if (otherAmount.value !== "") {
      amountRadios.forEach((radio) => (radio.checked = false));
    }
    validateAmount();
  });

  otherAmount.addEventListener("focus", () => {
    otherAmount.disabled = false;
    amountRadios.forEach((radio) => (radio.checked = false));
    clearAmountError(); // Clear any existing error when field gets focus
  });

  function clearAmountError() {
    const existingError = document.querySelector(
      "#one-time-form #otherAmount + .error-message",
    );
    if (existingError) existingError.remove();
    otherAmount.classList.remove("is-invalid");
  }

  function validateAmount() {
    clearAmountError();

    const amount = parseFloat(otherAmount.value);
    if (otherAmount.value && (isNaN(amount) || amount < 2000)) {
      const errorDiv = document.createElement("div");
      errorDiv.className = "error-message text-danger";
      errorDiv.id = "otherAmountError";
      errorDiv.textContent = "Amount must be at least ₹2000";

      // Insert the error message after the input
      otherAmount.parentNode.insertBefore(errorDiv, otherAmount.nextSibling);
      otherAmount.classList.add("is-invalid");
      return false;
    }
    return true;
  }

  form.addEventListener("submit", (event) => {
    event.preventDefault();
    clearErrors();

    let valid = true;

    const nameInput = getField("name");
    const nameValue = nameInput.value.trim();

    const addressInput = getField("address");
    const addressValue = addressInput.value.trim();

    if (!addressValue) {
      showError(addressInput, "Address is required");
      valid = false;
    } else if (!isValidAddress(addressValue)) {
      showError(
        addressInput,
        "Please enter a valid address without special code characters",
      );
      valid = false;
    }

    if (!nameValue) {
      showError(nameInput, "Name is required");
      valid = false;
    } else if (!isValidName(nameValue)) {
      showNameError(
        nameInput,
        "Please enter a valid name without special characters or code",
      );
      valid = false;
    }
    // Amount validation - unified approach
    const selectedAmount =
      [...amountRadios].find((r) => r.checked)?.value || otherAmount.value;
    const amountValue = parseFloat(selectedAmount);

    if (!selectedAmount || isNaN(amountValue)) {
      showError(otherAmount, "Please select or enter a valid donation amount");
      valid = false;
    } else if (amountValue < 2000) {
      // If the error comes from otherAmount field, use its specific validation
      if (otherAmount.value) {
        validateAmount(); // This will show the specific error
      } else {
        showError(otherAmount, "Minimum donation amount is ₹2000");
      }
      valid = false;
    }

    // Rest of your validation code remains the same...
    const requiredFields = [
      "email",
      "phone",
      "pin",
      "city",
      "state",
      "nationality",
    ];
    requiredFields.forEach((id) => {
      const input = getField(id);
      const value = input.value.trim();

      if (!value) {
        showError(
          input,
          `${input.previousElementSibling.textContent.replace("*", "")} is required`,
        );
        valid = false;
      } else {
        if (id === "email" && !isValidEmail(value)) {
          showError(input, "Please enter a valid email address");
          valid = false;
        } else if (id === "phone" && !isValidPhone(value)) {
          showError(input, "Please enter a valid 10-digit phone number");
          valid = false;
        } else if (id === "pin" && !isValidPIN(value)) {
          showError(input, "Please enter a valid 6-digit PIN code");
          valid = false;
        }
      }
    });

    if (!identificationType.value) {
      showError(identificationType, "Please select an identification type");
      valid = false;
    } else {
      const type = identificationType.value;
      const field = getField(type);
      if (!field.value.trim()) {
        showError(
          field,
          `${type.charAt(0).toUpperCase() + type.slice(1)} number is required`,
        );
        valid = false;
      } else {
        const validators = {
          aadhaar: isValidAadhaar,
          pan: isValidPAN,
          passport: isValidPassport,
        };
        if (!validators[type](field.value.trim())) {
          showError(field, `Please enter a valid ${type} number`);
          valid = false;
        }
      }
    }

    const terms = form.querySelector('input[name="terms"]');
    if (!terms.checked) {
      showError(terms, "You must agree to the terms");
      valid = false;
    }

    const dobValue = dobInputOT.value.trim();
    if (dobValue && !isAdult(dobValue)) {
      showError(dobInputOT, "You must be at least 18 years old");
      valid = false;
    }

    if (valid) {
      const formData = new FormData(form);
      const data = {};
      formData.forEach((value, key) => {
        data[key] = value;
      });

      data.amount = selectedAmount;

      // console.log('Form submitted with data:', data);
      document.getElementById("SubmitOT").disabled = true;
      $.ajax({
        type: "POST",
        url: "../onetime.php",
        data: data,
        cache: false,
        success: function (result) {
          $("#Msg").html(result);
          document.getElementById("SubmitOT").disabled = false;
          if (result == "Yes") {
            window.location.href =
              "https://donate.wwfindia.org/process.php?title=give-onetime";
          }
        },
      });
    }
  });

  function clearErrors() {
    form.querySelectorAll(".error-message").forEach((e) => e.remove());
    form.querySelectorAll("input, select").forEach((el) => {
      el.style.borderColor = "";
      el.classList.remove("is-invalid");
    });
  }

  // Helper function to get field by ID
  function getField(id) {
    return form.querySelector(`#${id}`);
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("regular-form");
  const identificationType = form.querySelector("#identificationTypeReg");
  const aadhaarInput = form.querySelector("#aadhaarInputReg");
  const panInput = form.querySelector("#panInputReg");
  const passportInput = form.querySelector("#passportInputReg");
  const amountRadios = form.querySelectorAll('input[name="amountReq"]');
  const otherAmount = form.querySelector("#otherAmountReq");

  identificationType.addEventListener("change", () => {
    aadhaarInput.style.display = "none";
    panInput.style.display = "none";
    passportInput.style.display = "none";

    const selected = identificationType.value;
    if (selected === "aadhaar") aadhaarInput.style.display = "block";
    if (selected === "pan") panInput.style.display = "block";
    if (selected === "passport") passportInput.style.display = "block";
  });

  amountRadios.forEach((radio) => {
    radio.addEventListener("change", () => {
      if (radio.checked) {
        otherAmount.value = "";
        clearAmountError();
      }
    });
  });

  otherAmount.addEventListener("input", () => {
    if (otherAmount.value !== "") {
      amountRadios.forEach((radio) => (radio.checked = false));
      validateAmount();
    }
  });

  otherAmount.addEventListener("focus", () => {
    amountRadios.forEach((radio) => (radio.checked = false));
    clearAmountError();
  });

  function clearAmountError() {
    const existingError = document.querySelector(
      "#regular-form #otherAmountReq + .error-message",
    );
    if (existingError) existingError.remove();
    otherAmount.classList.remove("is-invalid");
  }

  function validateAmount() {
    clearAmountError();

    const amount = parseFloat(otherAmount.value);
    if (otherAmount.value && (isNaN(amount) || amount < 1)) {
      const errorDiv = document.createElement("div");
      errorDiv.className = "error-message text-danger";
      errorDiv.id = "otherAmountError";
      errorDiv.textContent = "Amount must be at least ₹1";

      // Insert the error message after the input
      otherAmount.parentNode.insertBefore(errorDiv, otherAmount.nextSibling);
      otherAmount.classList.add("is-invalid");
      return false;
    }
    return true;
  }

  form.addEventListener("submit", (event) => {
    event.preventDefault();
    clearErrors();

    let valid = true;
    const getField = (id) => form.querySelector(`#${id}`);
    const selectedAmount =
      [...amountRadios].find((r) => r.checked)?.value || otherAmount.value;
    const amountValue = parseFloat(selectedAmount);

    const nameInput = getField("nameReg");
    const nameValue = nameInput.value.trim();

    if (!nameValue) {
      showError(nameInput, "Name is required");
      valid = false;
    } else if (!isValidName(nameValue)) {
      showNameError(
        nameInput,
        "Please enter a valid name without special characters or code",
      );
      valid = false;
    }

    if (!selectedAmount || isNaN(amountValue)) {
      showError(otherAmount, "Please select or enter a valid donation amount");
      valid = false;
    } else if (amountValue < 1) {
      if (otherAmount.value) {
        validateAmount();
      } else {
        showError(otherAmount, "Minimum donation amount is ₹1");
      }
      valid = false;
    }

    const requiredFields = [
      // { id: 'nameReg', label: 'Full Name' },
      {
        id: "emailReg",
        label: "Email Address",
        validator: isValidEmail,
        error: "Please enter a valid email address",
      },
      {
        id: "phoneReg",
        label: "Phone Number",
        validator: isValidPhone,
        error: "Please enter a valid 10-digit phone number",
      },
      {
        id: "addressReg",
        label: "Address",
        validator: isValidAddress,
        error: "Please enter a valid address without special code characters",
      },
      {
        id: "pinReg",
        label: "PIN Code",
        validator: isValidPIN,
        error: "Please enter a valid 6-digit PIN code",
      },
      { id: "cityReg", label: "City" },
      { id: "stateReg", label: "State" },
      { id: "nationalityReg", label: "Nationality" },
    ];

    requiredFields.forEach(({ id, label, validator, error }) => {
      const input = getField(id);
      const value = input.value.trim();
      if (!value) {
        showError(input, `${label} is required`);
        valid = false;
      } else if (validator && !validator(value)) {
        showError(input, error);
        valid = false;
      }
    });

    if (!identificationType.value) {
      showError(identificationType, "Please select an identification type");
      valid = false;
    } else {
      const type = identificationType.value;
      const inputMap = {
        aadhaar: "aadhaarReg",
        pan: "panReg",
        passport: "passportReg",
      };
      const field = getField(inputMap[type]);
      const value = field.value.trim();
      if (!value) {
        showError(
          field,
          `${type.charAt(0).toUpperCase() + type.slice(1)} number is required`,
        );
        valid = false;
      } else {
        const validators = {
          aadhaar: isValidAadhaar,
          pan: isValidPAN,
          passport: isValidPassport,
        };
        if (!validators[type](value)) {
          showError(field, `Please enter a valid ${type} number`);
          valid = false;
        }
      }
    }

    const terms = form.querySelector("#termsReg");
    if (!terms.checked) {
      showError(terms, "You must agree to the terms");
      valid = false;
    }

    const dobValue = dobInputReg.value.trim();
    if (dobValue && !isAdult(dobValue)) {
      showError(dobInputReg, "You must be at least 18 years old");
      valid = false;
    }

    if (valid) {
      const formData = new FormData(form);
      const data = {};
      formData.forEach((value, key) => {
        data[key] = value;
      });

      data.amount = selectedAmount;
      console.log("Regular form submitted with data:", data);
      //alert('Regular donation form submitted successfully!');
      //form.submit(); // Uncomment this in production
      document.getElementById("SubmitRG").disabled = true;
      $.ajax({
        type: "POST",
        url: "../regular.php",
        data: data,
        cache: false,
        success: function (result) {
          //var result=trim(result);
          $("#RMsg").html(result);
          document.getElementById("SubmitRG").disabled = false;
          if (result == "Yes") {
            window.location.href =
              "https://donate.wwfindia.org/process.php?title=give-monthly";
          }
        },
      });
    }
  });

  function clearErrors() {
    form.querySelectorAll(".error-message").forEach((e) => e.remove());
    form.querySelectorAll("input, select").forEach((el) => {
      el.style.borderColor = "";
    });
  }
});

const pinRG = document.getElementById("pinReg");
const cityRG = document.getElementById("cityReg");
const stateRG = document.getElementById("stateReg");

async function fetchStateAndCityRG(pin) {
  try {
    const response = await fetch(`https://api.postalpincode.in/pincode/${pin}`);
    const data = await response.json();
    if (data && data[0] && data[0].Status === "Success") {
      const postOffice = data[0].PostOffice[0];
      cityRG.value = postOffice.District || "";
      stateRG.value = postOffice.State || "";
    }
  } catch (error) {
    console.error("Error fetching PIN code details:", error);
  }
}

pinRG.addEventListener("change", (event) => {
  fetchStateAndCityRG(event.target.value);
});

const pinOT = document.getElementById("pin");
const cityOT = document.getElementById("city");
const stateOT = document.getElementById("state");

async function fetchStateAndCityOT(pin) {
  try {
    const response = await fetch(`https://api.postalpincode.in/pincode/${pin}`);
    const data = await response.json();
    if (data && data[0] && data[0].Status === "Success") {
      const postOffice = data[0].PostOffice[0];
      cityOT.value = postOffice.District || "";
      stateOT.value = postOffice.State || "";
    }
  } catch (error) {
    console.error("Error fetching PIN code details:", error);
  }
}

pinOT.addEventListener("change", (event) => {
  fetchStateAndCityOT(event.target.value);
});

function isAdult(dobString) {
  const dob = new Date(dobString);
  const today = new Date();
  let age = today.getFullYear() - dob.getFullYear();
  const monthDiff = today.getMonth() - dob.getMonth();

  if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
    age--;
  }
  return age >= 18;
}

const isValidEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
const isValidPhone = (phone) => /^[6-9]\d{9}$/.test(phone);
const isValidPIN = (pin) => /^\d{6}$/.test(pin);
const isValidAadhaar = (a) => /^\d{12}$/.test(a);
const isValidPAN = (pan) => /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(pan);
const isValidPassport = (pass) => /^[A-Z]{1}[0-9]{7}$/.test(pass);
function isValidName(name) {
  const nameRegex =
    /^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð\s.'-]{2,}$/u;
  return nameRegex.test(name);
}

function showNameError(input, message) {
  // Clear any existing error
  const existingError = input.parentNode.querySelector(".error-message");
  if (existingError) existingError.remove();

  // Add error message
  const errorDiv = document.createElement("div");
  errorDiv.className = "error-message text-danger mt-1";
  errorDiv.textContent = message;
  input.parentNode.appendChild(errorDiv);
  input.classList.add("is-invalid");
}

function showError(element, message) {
  const parent = element.closest(".form-group") || element.parentElement;
  const error = document.createElement("div");
  error.className = "error-message";
  error.textContent = message;
  error.style.color = "red";
  error.style.fontSize = "12px";
  error.style.marginTop = "5px";
  if (element.type === "checkbox") {
    element.parentElement.appendChild(error);
  } else {
    parent.appendChild(error);
  }
  element.style.borderColor = "red";
}

const restrictToNumbers = (event) => {
  event.target.value = event.target.value.replace(/\D/g, "");
};

document.getElementById("phone").addEventListener("input", restrictToNumbers);
document
  .getElementById("phoneReg")
  .addEventListener("input", restrictToNumbers);

const isValidAddress = (address) => {
  const addressRegex = /^[a-zA-Z0-9\s.,#\-()/&'":;]+$/;

  const codePatterns = [
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

  if (!addressRegex.test(address)) {
    return false;
  }

  for (const pattern of codePatterns) {
    if (pattern.test(address)) {
      return false;
    }
  }

  return true;
};

const inputIds = [
  "aadhaarReg",
  "panReg",
  "passportReg",
  "aadhaar",
  "pan",
  "passport",
];

inputIds.forEach((id) => {
  const el = document.getElementById(id);
  if (el) {
    el.setAttribute("autocomplete", "off");
    el.classList.add("masked");
  }
});
