const saveChanges = document.getElementById("saveChanges");
const infoConf = document.getElementById("infoConf");
const configureSection = document.querySelector(".configure-section");
let configData = {};

window.onload = foo.bind(null, foo2);

function foo2(item) {
    configData[item.getAttribute("data-id")] = item.value;
}

function foo(func) {
    const tableitems = configureSection.querySelectorAll("tbody tr");
    tableitems.forEach((item) => {
        let massOfInputs = item.querySelectorAll("input");
        // console.log(configData);
        massOfInputs.forEach((item) => {
            func(item);
        });
    });
}

saveChanges.addEventListener("click", (e) => {
    const obj = {};
    foo(function (item) {
        if (configData[item.getAttribute("data-id")] !== item.value) {
            obj[item.getAttribute("data-id")] = item.value;
            console.log(item.getAttribute("data-id"));
        }
    });

    console.log(JSON.stringify(obj));
    (async () => {
        try {
            const req = await fetch(
                `http://www.maillaravel.com/home/actions/${id}`,
                {
                    method: "PATCH",
                    body: JSON.stringify({ id: configData.id, ...obj }),
                    headers: {
                        "X-CSRF-TOKEN": token,
                        "Content-Type": "application/json",
                    },
                }
            );
            if (req.status !== 200) {
                infoConf.style.border = "solid red 2px";
                const res = await req.text();
                infoConf.innerHTML = res;
                return;
            }
            infoConf.style.border = "solid green 2px";
            const res = await req.text();
            infoConf.innerHTML = res;
        } catch (e) {
            console.log(e);
        }
    })();
});
