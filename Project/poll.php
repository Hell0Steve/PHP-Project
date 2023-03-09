<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="CSS/poll1.css">

    <title>Fitness and lifestyle survey</title>
</head>

<body>
    <?php 
        include_once 'common/_navbar.php';
    ?>

    <h1 style="text-align: center" ;>A poll about fitness and lifestyle:</h1>
<!-- First part of poll -->
    <form>
        <div class="section" id="general-info">
            <h2>General Info</h2>
            <label for="id">What is your ID:</label>
            <input type="text" id="id" name="id" required>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>
            <label for="weight">Weight:</label>
            <input type="number" id="weight" name="weight" required>
        </div>
<!-- Second part of poll -->
        <div class="section" id="physical-shape">
            <h2>Physical Shape</h2>
            <label for="workout">How many times a week do you workout?</label>
            <input type="number" id="workout" name="workout" required>

            <label for="activity">Physical Activity Level:</label>
            <select id="activity" name="activity" required>
                <option value="low">Low</option>
                <option value="moderate">Moderate</option>
                <option value="active">Active</option>
                <option value="very active">Very Active</option>
            </select>
        </div>

<!-- Third part of poll -->
        <div class="section" id="diet-section">
            <h2>Diet</h2>
            <label for="meals">How many meals do you eat a day?</label>
            <input type="number" id="meals" name="meals" required>

            <label for="diet">Diet:</label>
            <select id="diet" name="diet" required>
                <option value="omnivore">Omnivore</option>
                <option value="vegetarian">Vegetarian</option>
                <option value="vegan">Vegan</option>
            </select>
            <button type="button" class="btn btn-success" id="submit">Submit</button>

        </div>
<!-- Using JS for navigation buttons -->
        <div class="navigation-btns">
            <span id="prev-btn" class="disabled">
                <i class="fa-solid fa-caret-left"></i>
            </span>
            <span id="page-number"></span>
            <span id="next-btn">
                <i class="fa-solid fa-caret-right"></i>
            </span>
        </div>

    </form>

    <script src="JS/pollBtnScript.js"></script>

</body>

</html>