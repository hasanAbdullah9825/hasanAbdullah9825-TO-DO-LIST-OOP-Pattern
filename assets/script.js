console.log("App.js loaded");
document.addEventListener("DOMContentLoaded", () => {
  const editButtons = document.querySelectorAll(".edit-btn");
  const editTaskModal = document.getElementById("editModal");
  const editTaskId = document.getElementById("editTaskId");
  const editTaskTitle = document.getElementById("editTaskTitle");
  const editTaskDescription = document.getElementById("editTaskDescription");
  const editTaskDueDate = document.getElementById("editTaskDueDate");

  editButtons.forEach((button) => {
    button.addEventListener("click", () => {
      console.log("App.js clicked");
      editTaskId.value = button.dataset.id;
      editTaskTitle.value = button.dataset.title;
      editTaskDescription.value = button.dataset.description;

      let rawDate = button.dataset.duedate; // "2025-02-15 00:00:00"
      let formattedDate = rawDate.split(" ")[0]; // Extracts "2025-02-15"
      document.getElementById("editTaskDueDate").value = formattedDate;

      console.log(button.dataset.duedate);
      editTaskModal.style.display = "flex";
    });
  });
});

document.getElementById("close-btn").addEventListener("click", () => {
  editTaskModal = document.getElementById("editModal");
  editTaskModal.style.display = "none";
});

window.addEventListener("click", (event) => {
  const editTaskModal = document.getElementById("editModal");
  if (event.target === editTaskModal) {
    editTaskModal.style.display = "none";
  }
});
