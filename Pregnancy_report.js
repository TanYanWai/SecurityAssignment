document.addEventListener("DOMContentLoaded", () => {
    const showMoreButton = document.getElementById("showMoreButton");
    const reportDetails = document.querySelectorAll(".report_details");
    const doctorNote = document.querySelector(".report_details_note");
    const genderOptions = document.querySelector(".report_details_options");
  
    showMoreButton.addEventListener("click", (e) => {
      reportDetails.forEach((element) => {
        if (element.style.display === "block") {
          element.style.display = "none";
        } else {
          element.style.display = "block";
        }
      });
  
      doctorNote.style.display = doctorNote.style.display === "block" ? "none" : "block";
  
      genderOptions.style.display = genderOptions.style.display === "block" ? "none" : "block";
  
      showMoreButton.textContent = showMoreButton.textContent === "Show More" ? "Show Less" : "Show More";
    });
  });

  function hideReportSearch() {
    var reportSearchDiv = document.querySelector('.report_search');
    reportSearchDiv.style.display = 'none';
}

function showAlert() {
  alert("Data inserted");
}