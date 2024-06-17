const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

if (urlParams.get('user') === 'admin') {
    show_message("Welcome admin 🫡");
}
