
function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;

    const img = document.getElementById('avatarPreview');
    img.src = URL.createObjectURL(file);
}

