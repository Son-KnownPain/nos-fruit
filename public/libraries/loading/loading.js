function myLoader(status = true) {
    if (status) {
        document.getElementById('loader').style.display = 'block';
    } else {
        document.getElementById('loader').style.display = 'none';
    }
}