document.addEventListener('DOMContentLoaded', function () {
    const editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
    const profilePictureInput = document.getElementById('profilePictureInput');
    const profilePicture = document.querySelector('.img-fluid.rounded-circle');

    profilePictureInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                profilePicture.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
});
