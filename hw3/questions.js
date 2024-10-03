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
res_arr = [];

for (const cat of cats) {
  if (cat.adoptionStatus == "available") {
    res_arr.push(cat.name);
  }
}
console.log("The cats that are available are " + res_arr.join());

test_output = Math.random() * 10;
let ter_var = test_output > 5 ? "greater than five!" : "less than five!";
console.log(ter_var);

for (cat of cats) {
  console.log(cat.name, cat.adoptionStatus);
}

if (1 == "1") {
  console.log("This is true");
}

if (1 === "1") {
  console.log("This is false");
}

function myFunction(arr) {
  return arr.name + " is cute!";
}
new_arr = cats.map(myFunction);
console.log(new_arr);
