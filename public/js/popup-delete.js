let identityDelete = ""; // global identity variable

// open popup and display
function openPopupDeleteSubmit(text, identity) {
    document.querySelector(`#popup-overlay-delete`).classList.toggle('active'); // show popup overlay
    document.querySelector(`#popup-delete`).classList.toggle('active'); // show popup
    document.querySelector(`#popup-text-delete`).innerHTML = text; // show the given popup text

    this.identityDelete = identity; // assign identity to global identity variable
}

// accept popup
function acceptPopupDelete() {
    document.getElementById(`${this.identityDelete}-delete-form`).submit(); // submit the given form 
    document.querySelector(`#popup-delete`).classList.toggle('active'); // close popup 
    document.querySelector(`#popup-overlay-delete`).classList.toggle('active'); // close popup overlay
}

// close popup
function closePopupDelete() {
    let popup = document.querySelector(`#popup-delete`);

    popup.classList.toggle('active'); // close popup
    document.querySelector(`#popup-overlay-delete`).classList.toggle('active'); // close popup overlay
}