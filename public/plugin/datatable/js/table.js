function datatable() {
    let th = document.querySelectorAll("table th.sort"),
        fselect = document.querySelectorAll(".sort_table select");
    for (let i = 0; i < th.length; i++) {
        th[i].onclick = () => {
            th[i].classList.toggle("sorting_desc");
            th[i].classList.toggle("sorting_asc");
            th[i].children[0].value = "asc";
            if (th[i].classList.contains("sorting_desc")) {
                th[i].children[0].value = "desc";
            }
            // trigger submit
            $(".sort_table").trigger("submit");
        }
    }
    for (let i = 0; i < fselect.length; i++) {
        fselect[i].onchange = () => {
            // trigger submit
            $(".sort_table").trigger("submit");
        }
    }
}