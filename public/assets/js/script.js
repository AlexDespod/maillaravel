const deleteButtons = document.querySelectorAll(".delete-button");
const foo = (e) => {
    const id = +e.target.getAttribute("data-id");
    console.log(id);
};
deleteButtons.forEach((item) => {
    item.addEventListener("click", foo);
});
