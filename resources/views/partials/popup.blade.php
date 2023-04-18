<script>
    let identity = ""; // global identity variable

// open popup and display
function openPopupSubmit(text, identity) {
    document.querySelector(`#popup-overlay`).classList.toggle('active'); // show popup overlay
    document.querySelector(`#popup`).classList.toggle('active'); // show popup
    document.querySelector(`#popup-text`).innerHTML = text; // show the given popup text

    this.identity = identity; // assign identity to global identity variable
}

// accept popup
function acceptPopup() {
    document.getElementById(`${this.identity}-accept-form`).submit(); // submit the given form 
    document.querySelector(`#popup`).classList.toggle('active'); // close popup 
    document.querySelector(`#popup-overlay`).classList.toggle('active'); // close popup overlay
}

// close popup
function closePopup() {
    let popup = document.querySelector(`#popup`);

    popup.classList.toggle('active'); // close popup
    document.querySelector(`#popup-overlay`).classList.toggle('active'); // close popup overlay
}
</script>