const dropboxAdmin = document.querySelector(".dropboxAdmin");
const ctx = document.getElementById("studentChart");

new Chart(ctx, {
  type: "bar",
  data: {
    labels: ["CNTT1", "CNTT2", "KT01", "QTKD"],
    datasets: [
      {
        label: "Nam",
        data: [30, 27, 20, 10],
        backgroundColor: "#3E7EDB",
      },
      {
        label: "Nữ",
        data: [10, 7, 6, 15],
        backgroundColor: "#4CAF50",
      },
    ],
  },
  options: {
    responsive: true,
    plugins: {
      legend: { position: "top" },
    },
  },
});

const avatar = document.querySelector(".avatar");
avatar.addEventListener("click", function (e) {
  e.stopPropagation();
  dropboxAdmin.classList.toggle("active");
});

document.addEventListener("DOMContentLoaded", function () {
  const icons = document.querySelectorAll(".info-item i");
  let tooltip;

  icons.forEach(icon => {
    icon.addEventListener("mouseenter", function (e) {
      const text = this.dataset.label;
      if (!text) return;

      tooltip = document.createElement("div");
      tooltip.className = "tooltip";
      tooltip.innerText = text;
      document.body.appendChild(tooltip);

      const rect = this.getBoundingClientRect();
      tooltip.style.left = rect.left + rect.width / 2 + "px";
      tooltip.style.top = rect.top - 10 + window.scrollY + "px";
      tooltip.style.transform = "translate(-50%, -100%)";
      tooltip.style.opacity = 1;
    });

    icon.addEventListener("mouseleave", function () {
      if (tooltip) {
        tooltip.remove();
        tooltip = null;
      }
    });
  });
});
