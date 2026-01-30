function previewAvatar(event) {
  const file = event.target.files[0];
  if (!file) return;

  const img = document.getElementById("avatarPreview");
  img.src = URL.createObjectURL(file);
}

// document.querySelectorAll(".tkb-cell.has-class").forEach((cell) => {
//   const colors = ["#E3F2FD", "#FCE4EC", "#E8F5E9", "#FFF3E0", "#F3E5F5"];
//   cell.style.background = colors[Math.floor(Math.random() * colors.length)];
// });

document.addEventListener("DOMContentLoaded", function () {
    const alertBox = document.getElementById("autoHideAlert");
    if (alertBox) {
        setTimeout(() => {
            alertBox.classList.add("hide");
            setTimeout(() => alertBox.remove(), 500);
        }, 3000);
    }
});