const daysTag = document.querySelector(".days");
const currentDate = document.querySelector(".current-date");
const prevIcon = document.getElementById("prev");
const nextIcon = document.getElementById("next");
const formContainer = document.querySelectorAll(".form-container");

let selectedDate = null;

let date = new Date();
let currYear = date.getFullYear();
let currMonth = date.getMonth();

const months = [
  "January", "February", "March", "April", "May", "June", "July",
  "August", "September", "October", "November", "December"
];

const renderCalendar = () => {
  let firstDayOfMonth = new Date(currYear, currMonth, 1).getDay();
  let lastDateOfMonth = new Date(currYear, currMonth + 1, 0).getDate();
  let lastDayOfMonth = new Date(currYear, currMonth, lastDateOfMonth).getDay();
  let lastDateOfLastMonth = new Date(currYear, currMonth, 0).getDate();

  let liTag = "";
  for (let i = firstDayOfMonth; i > 0; i--) {
    liTag += `<li class="inactive">${lastDateOfLastMonth - i + 1}</li>`;
  }

  for (let i = 1; i <= lastDateOfMonth; i++) {
    let isToday = i === date.getDate() && currMonth === date.getMonth() && currYear === date.getFullYear() ? "active" : "";
    liTag += `<li class="${isToday}" data-date="${i}">${i}</li>`;
  }

  for (let i = lastDayOfMonth + 1; i < 7; i++) {
    liTag += `<li class="inactive">${i - lastDayOfMonth}</li>`;
  }

  currentDate.innerText = `${months[currMonth]} ${currYear}`;
  daysTag.innerHTML = liTag;

  const dateElements = document.querySelectorAll(".days li");
  dateElements.forEach((dateElement) => {
    dateElement.addEventListener("click", () => {
      selectedDate = String(dateElement.getAttribute("data-date")).padStart(2, "0");
      date.setDate(selectedDate);
      renderCalendar();
      formContainer.forEach((container) => {
        container.style.display = "block";
      });
    });
  });
};

prevIcon.addEventListener("click", () => {
  currMonth--;
  if (currMonth < 0) {
    currYear--;
    currMonth = 11;
  }
  date = new Date(currYear, currMonth, 1);
  renderCalendar();
});

nextIcon.addEventListener("click", () => {
  currMonth++;
  if (currMonth > 11) {
    currYear++;
    currMonth = 0;
  }
  date = new Date(currYear, currMonth, 1);
  renderCalendar();
});

document.getElementById("forInput").addEventListener("submit", () => {
  if (selectedDate !== null) {
    const selectedDateInput = document.createElement("input");
    selectedDateInput.setAttribute("type", "hidden");
    selectedDateInput.setAttribute("name", "selectedDate");
    selectedDateInput.setAttribute("value", selectedDate);
    document.getElementById("forInput").appendChild(selectedDateInput);
  }
});

renderCalendar();