</div>

<!-- Include jQuery and Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="js/script.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script>
    // Function to get and remove the 'msg' parameter from the URL
function getAndRemoveMsgParameter() {
    const urlParams = new URLSearchParams(window.location.search);
    const msg = urlParams.get('msg');

    if (msg) {
        // Display the 'msg' parameter in an alert
       // Create a Bootstrap alert div
       const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-info alert-dismissible fade show';
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${msg}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        // Append the alert div to the body
        $(".main-area").prepend(alertDiv);

        // Remove the 'msg' parameter from the URL without reloading the page
        if (window.history.replaceState) {
            const newUrl = window.location.href.replace(/([?&])msg=.*?(&|$)/, '$1$2');
            window.history.replaceState(null, null, newUrl);
        }
    }
}

// Call the function when the page loads
window.onload = getAndRemoveMsgParameter;

</script>
</body>
</html>