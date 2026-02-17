document.getElementById("searchTable").addEventListener("keyup", function () {
  let keyword = this.value.toLowerCase();
  let rows = document.querySelectorAll("#mainTable tbody tr");

  rows.forEach(row => {
    row.style.display = row.innerText.toLowerCase().includes(keyword) ? "" : "none";
  });
});

let sortDirection = true;

function sortTable(colIndex) {
  let tbody = document.querySelector("#mainTable tbody");
  let rows = Array.from(tbody.rows);

  sortDirection = !sortDirection;

  rows.sort((rowA, rowB) => {
    let cellA = rowA.cells[colIndex].innerText.trim();
    let cellB = rowB.cells[colIndex].innerText.trim();

    // Number sort
    let numA = parseFloat(cellA.replace(/\D/g, ""));
    let numB = parseFloat(cellB.replace(/\D/g, ""));

    if (!isNaN(numA) && !isNaN(numB)) {
      return sortDirection ? numA - numB : numB - numA;
    }

    // Date sort
    let dateA = Date.parse(cellA);
    let dateB = Date.parse(cellB);

    if (!isNaN(dateA) && !isNaN(dateB)) {
      return sortDirection ? dateA - dateB : dateB - dateA;
    }

    // Text sort
    return sortDirection 
      ? cellA.localeCompare(cellB) 
      : cellB.localeCompare(cellA);
  });

  rows.forEach(row => tbody.appendChild(row));
}

