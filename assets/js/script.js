function showPage(pageId) {
    const pages = [
        "visitors_page",
        "add_visitor_page",
        "handbooks_page",
        "dashboard_page"
    ];

    pages.forEach((page) => {
        const element = document.getElementById(page);
        element.style.display = page === pageId ? "block" : "none";
    });

    if (pageId === "add_visitor_page") {
        const form = document.querySelector("#add_visitor_page").querySelector("form");

        if (form) {
            form.reset();
        }

        const docFieldBlocks = [
            "passport_fields",
            "license_fields",
            "other_fields"
        ];

        docFieldBlocks.forEach(id => {
            const elem = document.getElementById(id);
            if (elem) elem.style.display = "none";
        });
    }
}

function setActiveLink(linkId) {
    document.querySelectorAll(".menu-link").forEach((link) => {
        link.classList.remove("active");
    });
    document.getElementById(linkId).classList.add("active");
}


function showFields(doc_type) {
    const fields = [
        "passport_fields",
        "license_fields",
        "other_fields"
    ];

    fields.forEach((field) => {
        const element = document.getElementById(field);
        element.style.display = "none";
        element.querySelectorAll('input').forEach(input => input.required = false);
        element.querySelectorAll('input').forEach(input => input.value = '');
    });

    const selected = document.getElementById(doc_type);
    selected.style.display = "flex";
    selected.querySelectorAll('input').forEach(input => input.required = true);
}

document.querySelector('#unit_code').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 3) {
        value = value.slice(0, 3) + '-' + value.slice(3, 6);
    }
    e.target.value = value.slice(0, 7);
});

document.querySelector('#phone').addEventListener('input', function (e) {
    let x = e.target.value.replace(/\D/g, '').substring(0, 11);
    let formatted = '+7';
    if (x.length > 1) formatted += '(' + x.substring(1, 4);
    if (x.length >= 4) formatted += ')' + x.substring(4, 7);
    if (x.length >= 7) formatted += '-' + x.substring(7, 9);
    if (x.length >= 9) formatted += '-' + x.substring(9, 11);
    e.target.value = formatted;
});

