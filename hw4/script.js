document.addEventListener("DOMContentLoaded", function () {
  const listItems = document.querySelectorAll("#myList li");
  listItems.forEach((item) => {
    item.addEventListener("click", () => {
      listItems.forEach((li) => {
        li.style.color = "blue";
      });
    });
  });

  const cats = [
    {
      name: "Charlie",
      adoptionStatus: "available",
    },
    {
      name: "Lily",
      adoptionStatus: "not-available",
    },
    {
      name: "Coco",
      adoptionStatus: "available",
    },
    {
      name: "Oreo",
      adoptionStatus: "not-available",
    },
    {
      name: "Luna",
      adoptionStatus: "available",
    },
    {
      name: "Milo",
      adoptionStatus: "available",
    },
    {
      name: "Lola",
      adoptionStatus: "not-available",
    },
    {
      name: "Leo",
      adoptionStatus: "available",
    },
    {
      name: "Willow",
      adoptionStatus: "available",
    },
    {
      name: "Bella",
      adoptionStatus: "not-available",
    },
    {
      name: "Max",
      adoptionStatus: "available",
    },
    {
      name: "Cleo",
      adoptionStatus: "available",
    },
    {
      name: "Lucy",
      adoptionStatus: "not-available",
    },
    {
      name: "Daisy",
      adoptionStatus: "available",
    },
  ];
  console.log(cats);
  const ul = document.getElementById("cats-list");

  for (cat of cats) {
    let newLi = document.createElement("li");
    newLi.textContent = cat.name;
    ul.appendChild(newLi);
  }

  const form = document.getElementById("formbutton");
  const input = document.getElementById("fname");
  const errorMessage = document.getElementById("errorMessage");
  form.addEventListener("click", function (event) {
    event.preventDefault();

    if (input.value == "") {
      errorMessage.textContent = "Please Provide a Value";
      errorMessage.style.display = "block";
      errorMessage.style.backgroundColor = "red";
    } else {
      errorMessage.style.display = "block";
      errorMessage.textContent = "Success";
      errorMessage.style.backgroundColor = "green";
    }

    console.log(input.value);
  });
});
