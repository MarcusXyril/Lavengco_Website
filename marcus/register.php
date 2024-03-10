<?php
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.css">
</head>
<style>
     body {
        background-image: url('background.png'); /* Path to your background image */
        background-size: cover; /* Cover the entire background */
        background-repeat: no-repeat; /* No repeat the background image */
        background-attachment: fixed; /* Fixed background position */
    }
    .container {
    width: 750px;
    height: 1200px;
    margin: 0 auto;
    margin-top: 150px;
    margin-bottom: 100px;
    padding: 50px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 1); /* Soft shadow effect */
    background-color: rgba(0, 0, 0, .2); 
    border-radius: 20px; /* Rounded corners */
}
.form-group {
    margin-bottom: 30px;
}

/* Update form input colors */
.form-control {
    background-color: rgba(255, 255, 255, 0.1); /* Semi-transparent white */
    color: white; /* Text color */
    border-color: #b1d4ed; /* Light blue border */
}

.form-group label {
            color: white; /* Text color */
        }

/* Update form button colors */
.btn-primary {
    background-color: #55efc4; /* Deep blue button background */
    border-color: #4b7bec; /* Deep blue button border */
    color: #ffffff; /* White text */
}

.btn-primary:hover {
    background-color: #3867d6; /* Darker deep blue on hover */
    border-color: #3867d6;
}

.alert {
    margin-bottom: 20px;
    padding: 15px;
    border-radius: 10px;
}

.alert-danger {
    color: #d63031; /* Dark red text */
    background-color: #fab1a0; /* Light red background */
    border-color: #e17055; /* Light red border */
}

.alert-success {
    color: #00b894; /* Dark green text */
    background-color: #55efc4; /* Light green background */
    border-color: #00b894; /* Light green border */
}


</style>
<body>
    <div class="container">
        <?php
        //validate the submit button
        if(isset($_POST["submit"])){
            $LastName = $_POST["LastName"];
            $FirstName = $_POST["FirstName"];
            $email = $_POST["Email"];
            $password = $_POST["password"];
            $RepeatPassword = $_POST["repeat_password"];
 
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();
        // validate if all fields are empty
            if (empty($LastName) OR empty($FirstName) OR empty($email) OR empty($password) OR empty($RepeatPassword)) {
                array_push($errors, "All fields are required");
            }
        //validate if the email is not validated
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($errors, "Email is not valid");
            }
        // password should not be less than 8
            if(strlen($password)<8) {
                array_push($errors, "Password must be at least 8 characters long");
            }
        // check if password is the same
            if($password!= $RepeatPassword){
                array_push($errors, "Password does not match");
            }

            require_once "database.php";
            $sql = "SELECT * FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0) {
                array_push($errors, "Email Already Exist!");
            }
 
            if (count($errors)>0){
                foreach($errors as $error) {
                    echo"<div class='alert alert-danger'>$error</div>";
                    }
                }else{
                   require_once "database.php";
                    $sql = "INSERT INTO user(LASTNAME, FIRSTNAME, EMAIL, PASSWORD) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn); // initializes a statement and returns an object suitable for mysqli_stmt_prepare()
                   $preparestmt = mysqli_stmt_prepare($stmt, $sql);
                   if ($preparestmt) {
                    mysqli_stmt_bind_param($stmt, "ssss", $LastName, $FirstName, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'> You are Registered Successfully! </div>";
                } else {
                    die("Something went wrong");
                }
                }
            }
        ?>
        <form action="register.php" method="post">
        <div class="form-group">
        <label for="LastName">LastName:</label>
                <input type="text" class="form-control" name="LastName" >
            </div>
            <div class="form-group">
            <label for="FirstName">FirstName:</label>
                <input type="text" class="form-control" name="FirstName">
            </div>
            <div class="form-group">
            <label class="form-label">Region</label>
            <select name="region" class="form-control form-control-md" id="region"></select>
            <input type="hidden" class="form-control form-control-md" name="region_text" id="region-text" required>
        </div>
        <div class="form-group">
            <label class="form-label">Province</label>
            <select name="province" class="form-control form-control-md" id="province"></select>
            <input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required>
        </div>
        <div class="form-group">
            <label class="form-label">City / Municipality</label>
            <select name="city" class="form-control form-control-md" id="city"></select>
            <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text" required>
        </div>
        <div class="form-group">
            <label class="form-label">Barangay</label>
            <select name="barangay" class="form-control form-control-md" id="barangay"></select>
            <input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required>
        </div>
        <div class="form-group">
        <label class="form-label">Country</label required>
            <select class="form-control" name="country">
                <option value=""> Country</option>
                <option value="Philippines">Philippines</option>
            </select>
        </div>
        <div class="form-group">
        <input type="tel" class="form-control" name="phone_number" id="phone_number" placeholder="Cellphone Number" required>
        </div>
            <div class="form-group">
            <label for="Email">Email:</label>
                <input type="email" class="form-control" name="Email" >
            </div>
            <div class="form-group">
            <label for="Password">Password:</label>
                <input type="password" class="form-control" name="password" >
            </div>
            <div class="form-group">
	        <label for="Repeat_Password">Repeat_Password:</label>
                <input type="password" class="form-control" name="repeat_password" >
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div><p>Already registered? <a href="login.php"> Login Here</a></div>
    </div>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput.min.js"></script>
<script>
$(document).ready(function() {
    var input = document.querySelector("#phone_number");
    window.intlTelInput(input, {
         allowDropdown: true,
        autoHideDialCode: true,
         autoPlaceholder: "true",
        // dropdownContainer: document.body,
        excludeCountries: ["us"],
        formatOnDisplay: true,
        geoIpLookup: function(callback) {
           $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
             var countryCode = (resp && resp.country) ? resp.country : "";
             callback(countryCode);
           });
         },
         hiddenInput: "full_number",
         initialCountry: "auto",
         localizedCountries: { 'de': 'Deutschland' },
        // nationalMode: false,
        // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        // placeholderNumberType: "MOBILE",
        // preferredCountries: ['cn', 'jp'],
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.js",
    });
});
    
var my_handlers = {
    // fill province
    fill_provinces: function() {
        //selected region
        var region_code = $(this).val();

        // set selected text to input
        var region_text = $(this).find("option:selected").text();
        let region_input = $('#region-text');
        region_input.val(region_text);
        //clear province & city & barangay input
        $('#province-text').val('');
        $('#city-text').val('');
        $('#barangay-text').val('');

        //province
        let dropdown = $('#province');
        dropdown.empty();
        dropdown.append('<option selected="true" disabled>Choose State/Province</option>');
        dropdown.prop('selectedIndex', 0);

        //city
        let city = $('#city');
        city.empty();
        city.append('<option selected="true" disabled></option>');
        city.prop('selectedIndex', 0);

        //barangay
        let barangay = $('#barangay');
        barangay.empty();
        barangay.append('<option selected="true" disabled></option>');
        barangay.prop('selectedIndex', 0);

        // filter & fill
        var url = 'ph-json/province.json';
        $.getJSON(url, function(data) {
            var result = data.filter(function(value) {
                return value.region_code == region_code;
            });

            result.sort(function(a, b) {
                return a.province_name.localeCompare(b.province_name);
            });

            $.each(result, function(key, entry) {
                dropdown.append($('<option></option>').attr('value', entry.province_code).text(entry.province_name));
            })

        });
    },
    // fill city
    fill_cities: function() {
        //selected province
        var province_code = $(this).val();

        // set selected text to input
        var province_text = $(this).find("option:selected").text();
        let province_input = $('#province-text');
        province_input.val(province_text);
        //clear city & barangay input
        $('#city-text').val('');
        $('#barangay-text').val('');

        //city
        let dropdown = $('#city');
        dropdown.empty();
        dropdown.append('<option selected="true" disabled>Choose city/municipality</option>');
        dropdown.prop('selectedIndex', 0);

        //barangay
        let barangay = $('#barangay');
        barangay.empty();
        barangay.append('<option selected="true" disabled></option>');
        barangay.prop('selectedIndex', 0);

        // filter & Fill
        var url = 'ph-json/city.json';
        $.getJSON(url, function(data) {
            var result = data.filter(function(value) {
                return value.province_code == province_code;
            });

            result.sort(function(a, b) {
                return a.city_name.localeCompare(b.city_name);
            });

            $.each(result, function(key, entry) {
                dropdown.append($('<option></option>').attr('value', entry.city_code).text(entry.city_name));
            })

        });
    },
    // fill barangay
    fill_barangays: function() {
        // selected barangay
        var city_code = $(this).val();

        // set selected text to input
        var city_text = $(this).find("option:selected").text();
        let city_input = $('#city-text');
        city_input.val(city_text);
        //clear barangay input
        $('#barangay-text').val('');

        // barangay
        let dropdown = $('#barangay');
        dropdown.empty();
        dropdown.append('<option selected="true" disabled>Choose barangay</option>');
        dropdown.prop('selectedIndex', 0);

        // filter & Fill
        var url = 'ph-json/barangay.json';
        $.getJSON(url, function(data) {
            var result = data.filter(function(value) {
                return value.city_code == city_code;
            });

            result.sort(function(a, b) {
                return a.brgy_name.localeCompare(b.brgy_name);
            });

            $.each(result, function(key, entry) {
                dropdown.append($('<option></option>').attr('value', entry.brgy_code).text(entry.brgy_name));
            })

        });
    },

    onchange_barangay: function() {
        // set selected text to input
        var barangay_text = $(this).find("option:selected").text();
        let barangay_input = $('#barangay-text');
        barangay_input.val(barangay_text);
    },

};


$(function() {
    // events
    $('#region').on('change', my_handlers.fill_provinces);
    $('#province').on('change', my_handlers.fill_cities);
    $('#city').on('change', my_handlers.fill_barangays);
    $('#barangay').on('change', my_handlers.onchange_barangay);

    // load region
    let dropdown = $('#region');
    dropdown.empty();
    dropdown.append('<option selected="true" disabled>Choose Region</option>');
    dropdown.prop('selectedIndex', 0);
    const url = 'ph-json/region.json';
    // Populate dropdown with list of regions
    $.getJSON(url, function(data) {
        $.each(data, function(key, entry) {
            dropdown.append($('<option></option>').attr('value', entry.region_code).text(entry.region_name));
        })
    });

});


</script>
</body>
</html>