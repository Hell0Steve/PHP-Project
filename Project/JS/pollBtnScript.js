let poll_id;
let currentPageNumber = 1;
if (localStorage.getItem('POLL_ID')) {
    poll_id = localStorage.getItem('POLL_ID');
    loadDraft(poll_id);
}
else {
    poll_id = randomString(11);
    localStorage.setItem('POLL_ID', poll_id);
}

const pageNumber = document.getElementById("page-number");
pageNumber.innerText = currentPageNumber;

// Get all the sections
const sections = document.querySelectorAll('.section');

// Get the navigation buttons
const prevBtn = document.querySelector('#prev-btn');
prevBtn.disabled = true;

const nextBtn = document.querySelector('#next-btn');
let currentSection = 0;

// Hide all sections except the first one
sections.forEach((section, index) => {
    if (index !== currentSection) {
        section.style.display = 'none';
    }
});

// Handle next button click
nextBtn.addEventListener('click', () => {
    if (currentPageNumber < sections.length) {
        saveDraft(currentPageNumber, poll_id);

        // Hide the current section
        sections[currentSection].style.display = 'none';
        // Increment the current section
        currentSection++;
        // Show the next section
        sections[currentSection].style.display = 'block';
    
        currentPageNumber +=1;
        pageNumber.innerText = currentPageNumber;

        prevBtn.classList.remove('disabled');
        if (currentPageNumber === sections.length) {
            nextBtn.classList.add("disabled");
        }
    }
});

// Handle previous button click
prevBtn.addEventListener('click', () => {
    if (currentPageNumber > 1) {
        saveDraft(currentPageNumber, poll_id);

        // Hide the current section
        sections[currentSection].style.display = 'none';
        // Decrement the current section
        currentSection--;
        // Show the previous section
        sections[currentSection].style.display = 'block';

        currentPageNumber -= 1;
        pageNumber.innerText = currentPageNumber;

        nextBtn.classList.remove("disabled");
        if (currentPageNumber === 1) {
            prevBtn.classList.add("disabled");
        }
    }
});

function saveDraft(step, poll_id) { // Saving the draft in the DB when pressing the prev and next buttons.
    const idElement = document.getElementById("id");
    const ageElement = document.getElementById("age");
    const weightElement = document.getElementById("weight");
    const workoutElement = document.getElementById("workout");
    const activityElement = document.getElementById("activity");
    const mealsElement = document.getElementById("meals");
    const dietElement = document.getElementById("diet");

    $.post(
        "poll_save.php", {
            id: idElement.value,
            age: ageElement.value,
            weight: weightElement.value,
            workout: workoutElement.value,
            activity: activityElement.value,
            meals: mealsElement.value,
            diet: dietElement.value,
            poll_id,
            step,
        },
        function (data) {
            console.log(data);
        }
    );
}

function loadDraft(poll_id) { // Loading the draft from DB
    $.get("load_poll.php?poll_id=" + poll_id, function (data) {
        const response = JSON.parse(data);
        document.getElementById("id").value = response.id;
        document.getElementById("age").value = response.age;
        document.getElementById("weight").value = response.weight;
        document.getElementById("workout").value = response.workout;
        document.getElementById("activity").value = response.activity;
        document.getElementById("meals").value = response.meals;
        document.getElementById("diet").value = response.diet;
    });
}

function randomString(length) { // Generate a random string for the # of poll used in statistics.
    const chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}

const submitBtn = document.getElementById('submit'); // Handling submit button. Saving the draft in DB at last.
if (submitBtn) {
    submitBtn.addEventListener('click', function () {
        saveDraft(3, poll_id);
        localStorage.removeItem("POLL_ID");
        window.location = 'statistics.php';
    });
}