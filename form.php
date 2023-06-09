<!DOCTYPE html>
<html lang="en">
<head>
    <title>Application Form</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script src="scripts/validation.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Application Form</h1>
        </header>

        <form id="applicationForm" method="post" onsubmit="return validateForm();" action="submit.php" enctype="multipart/form-data">
            <!-- Dane osoby -->
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>
            <div class="form-group">
                <label for="birthDate">Date of Birth:</label>
                <input type="date" id="birthDate" name="birthDate" max="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="education">Education:</label>
                <select id="education" name="education" required>
                    <option value="primary">Primary</option>
                    <option value="secondary">Secondary</option>
                    <option value="higher">Higher</option>
                </select>
            </div>

            <!-- Załączniki -->
            <div class="form-group">
                <label for="attachment1">Attachment 1:</label>
                <input type="file" id="attachment1" name="attachment1"  accept=".jpg, .pdf, .doc" required>
            </div>
            <div class="form-group">
                <label for="attachment2">Attachment 2:</label>
                <input type="file" id="attachment2" name="attachment2"  accept=".jpg, .pdf, .doc" required>
            </div>

            <label for="showInputCheckbox">Add another attachment:</label>
            <input type="checkbox" id="showInputCheckbox">

            <div id="attachment3Container" style="display: none;" class="form-group">
                <label for="attachment3">Attachment 3:</label>
                <input type="file" id="attachment3" name="attachment3">
            </div>

            <div id="internshipContainer">
                <h2>Internships</h2>
                <div class="internship">
                    <div id="internshipFields">
                        <div class="internshipField">
                            <label for="internshipCompany1">Company</label>
                            <input type="text" name="internshipCompanies[]" id="internshipCompany1" required>

                            <label for="internshipStartDate1">Start Date</label>
                            <input type="date" name="internshipStartDates[]" id="internshipStartDate1" max="<?php echo date('Y-m-d'); ?>" required>

                            <label for="internshipEndDate1">End Date</label>
                            <input type="date" name="internshipEndDates[]" id="internshipEndDate1"  oninput="setEndDateMin()" required>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" id="addInternshipButton" class="btn">Add Another Internship</button>

            <!-- Przyciski -->
            <div class="form-group">
                <div class="form-btn">
                    <button type="submit" class="btn">Submit</button>
                    <button type="reset" class="btn">Reset</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
