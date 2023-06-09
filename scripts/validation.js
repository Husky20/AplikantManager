function validateForm() {
    let firstName = document.getElementById("firstName").value;
    let lastName = document.getElementById("lastName").value;
    let birthDate = document.getElementById("birthDate").value;
    let email = document.getElementById("email").value;
    let attachment1 = document.getElementById("attachment1").value;
    let attachment2 = document.getElementById("attachment2").value;
    let startDateInputs = document.getElementsByName("internshipStartDates[]");
    let endDateInputs = document.getElementsByName("internshipEndDates[]");

    let isValid = true;

    if (firstName === "") {
        alert("Please enter your first name.");
        isValid = false;
    }

    if (lastName === "") {
        document.getElementById("lastNameError").textContent = "Please enter your last name.";
        document.getElementById("lastNameError").innerText = "Please enter your last name.";
        isValid = false;
    }

    if (birthDate === "" || !isValidDate(birthDate)) {
        document.getElementById("birthDateError").innerHTML = "Please enter a valid date in the format YYYY-MM-DD.";
        isValid = false;
    } else if (new Date(birthDate) > new Date()) {
        isValid = false;
        alert("Birth date cannot be later than today.");
    }

    if (email === "" || !isValidEmail(email)) {
        document.getElementById("emailError").innerHTML = "Please enter a valid email address.";
        isValid = false;
    }

    if (attachment1 === "") {
        document.getElementById("attachment1Error").innerHTML = "Please select Attachment 1.";
        isValid = false;
    }

    if (attachment2 === "") {
        document.getElementById("attachment2Error").innerHTML = "Please select Attachment 2.";
        isValid = false;
    }

    if (!isValidateInternship()) {
        isValid = false;
    }

    for (let i = 0; i < startDateInputs.length; i++) {
        let startDate = new Date(startDateInputs[i].value);
        let endDate = new Date(endDateInputs[i].value);

        if (startDateInputs[i].value === "" || !isValidDate(startDateInputs[i].value)) {
            isValid = false;
            alert("Please enter a valid date in the format YYYY-MM-DD.");
        }

        if (endDateInputs[i].value === "" || !isValidDate(endDateInputs[i].value)) {
            isValid = false;
            alert("Please enter a valid date in the format YYYY-MM-DD.");
        }

        if (startDate > new Date()) {
            isValid = false;
            alert("Start date cannot be later than today.");
        }

        if (startDate > endDate) {
            isValid = false;
            alert("Start date cannot be later than end date.");
        }
    }

    return isValid;
}

function setEndDateMin() {
    var startDateInput = document.getElementById("internshipStartDate1");
    var endDateInput = document.getElementById("internshipEndDate1");

    endDateInput.min = startDateInput.value;
}

function isValidDate(date) {
    let pattern = /^\d{4}-\d{2}-\d{2}$/;
    return pattern.test(date);
}

function isValidEmail(email) {
    let pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(email);
}

function isValidateInternship() {
    let internship = document.getElementById("internship").value;
    let isValid = true;

    if (internship === "") {
        document.getElementById("internshipError").innerHTML = "Please select internship.";
        isValid = false;
    } else {
        document.getElementById("internshipError").innerHTML = "";
    }

    return isValid;
}

document.addEventListener('DOMContentLoaded', function() {
    let addInternshipButton = document.getElementById('addInternshipButton');
    var internshipFields = document.getElementById('internshipFields');

    let counter = 1;

    function addInternship() {
        let internshipField = document.createElement('div');
        internshipField.className = 'internshipField';

        internshipField.innerHTML = `
          <label for="internshipCompany${counter}">Company</label>
          <input type="text" name="internshipCompanies[]" id="internshipCompany${counter}" required>
    
          <label for="internshipStartDate${counter}">Start Date</label>
          <input type="date" name="internshipStartDates[]" id="internshipStartDate${counter}" max="<?php echo date('Y-m-d'); ?>" required>
    
          <label for="internshipEndDate${counter}">End Date</label>
          <input type="date" name="internshipEndDates[]" id="internshipEndDate${counter}" oninput="setEndDateMin()" required>
          
          <button type="button" class="removeInternship btn">Remove</button>
        `;

        internshipFields.appendChild(internshipField);

        if (counter % 2 === 0) {
            internshipField.classList.add('even');
        } else {
            internshipField.classList.add('odd');
        }

        counter++;
    }
    function handleAttachment() {
        let showInputCheckbox = document.getElementById('showInputCheckbox');
        let inputContainer = document.getElementById('attachment3Container');

        if (showInputCheckbox.checked) {
            inputContainer.style.display = 'block';
        } else {
            inputContainer.style.display = 'none';
            inputContainer.querySelector('input').value = '';
        }
    }

    function removeInternship() {
        let internship = this.parentNode;
        internshipFields.removeChild(internship);
    }

    addInternshipButton.addEventListener('click', addInternship);

    internshipFields.addEventListener('click', function(event) {
        if (event.target.classList.contains('removeInternship')) {
            let internship = event.target.parentNode;
            internshipFields.removeChild(internship);
        }
    });

    let checkbox = document.getElementById('showInputCheckbox');
    checkbox.addEventListener('change', handleAttachment);

});




