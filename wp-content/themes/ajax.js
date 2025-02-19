document.getElementById("search").addEventListener("input", function() {
    let query = this.value;
    fetch(`/wp-json/testtask/v1/slots/get?search=${query}`)
        .then(response => response.json())
        .then(slots => {
            let list = document.getElementById("slot-list");
            list.innerHTML = "";
            slots.forEach(slot => {
                list.innerHTML += `<li><img src="${slot.thumb}" alt="${slot.name}"><a href="/slot/${slot.slug}">${slot.name}</a></li>`;
            });
        });
});
