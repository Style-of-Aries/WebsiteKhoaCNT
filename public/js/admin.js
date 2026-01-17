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
