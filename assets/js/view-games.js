function openOverlay(title, price, genre, releaseYear, imageUrl, gameId) {
    document.getElementById('overlay-title').innerText = title;
    document.getElementById('overlay-price').innerText = price;
    document.getElementById('overlay-genre').innerText = genre;
    document.getElementById('overlay-release-year').innerText = releaseYear;
    document.getElementById('overlay-image').src = imageUrl; // Set the image source
    document.getElementById('wishlist-game-id').value = gameId; // Set the game ID for wishlist
    document.getElementById('overlay').style.display = 'flex'; // Show overlay
}

function closeOverlay() {
    document.getElementById('overlay').style.display = 'none'; // Hide overlay
}

// Toggle dropdown visibility
function toggleDropdown() {
    document.getElementById("dropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches ('.profile-button')) {
        var dropdowns = document.getElementsByClassName("dropdown");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

function toggleDropdown() {
    document.getElementById("dropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.sort-button button')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}