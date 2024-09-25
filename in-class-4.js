console.log("in-class-4.js loaded!");
const firstObject = {
  name: "Atharva",
  echo: () => {
    logMyName(this.name);
  },
};
function logMyName(name) {
  console.log(name);
}
firstObject.echo();
firstObject.name = "Shanbhag";
firstObject.echo();

const arr = [1, 2, 3, 4, 5];
for (let i = 0; i < arr.length; i++) {
  if (i % 2 == 0) {
    console.log(`${i} is odd`);
  } else {
    console.log(`${i} is even`);
  }
}
