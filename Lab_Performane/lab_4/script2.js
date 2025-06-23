const container = document.getElementById("container");

for (let i = 1; i <= 100; i++) {
  const box = document.createElement("div");
  box.className = "box";
  box.textContent = `Box ${i}`;

  if (i % 2 === 0) {
    box.style.backgroundColor = "green";
    box.style.color = "white";
  } else {
    box.style.backgroundColor = "orange";
    box.style.color = "aqua";
  }

  container.appendChild(box);
}
